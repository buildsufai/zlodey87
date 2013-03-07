<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $cat_id
 * @property string $title
 * @property string $alias
 * @property string $image
 * @property integer $status
 * @property string $note
 * @property string $text
 * @property string $created_at
 * @property integer $created_by
 * @property integer $views
 * @property string $created_at
 * @property integer $price
 * @property integer $old_price
 * @property string $state
 * @property string $stock
 * @property string $meta_k
 * @property string $meta_d
 *
 * The followings are the available model relations:
 * @property Users $createdBy
 * @property Categories $cat
 */
class Product extends CActiveRecord
{
    
    public $path = '/images/product/';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'products';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('cat_id, title, text, price', 'required'),
            array('cat_id, views, price, old_price, created_by', 'numerical', 'integerOnly' => true),
            array('status', 'in', 'range' => array(0, 1)),
            array('state', 'in', 'range' => array('simple', 'hit', 'discount', 'bestprice', 'new')),
            array('title, alias', 'unique'),
            array('meta_k, meta_d, stock, note', 'length', 'max' => 255),
            array('image', 'file',
                'types' => 'jpeg, jpg, gif, png', // допустимые форматы
                'minSize' => 1, // 1 MB
                'maxSize' => 1048576, // 1 MB
                'allowEmpty' => false, // можно не загружать
                'allowEmpty' => true, // можно не загружать
                'tooLarge' => 'Файл весит больше 1 MB. Пожалуйста, загрузите файл меньшего размера.',
            ),
            array('image', 'required', 'on' => 'create'),
            array('created_at', 'type', 'type' => 'datetime',
                'datetimeFormat' => 'yyyy-mm-dd hh:mm:ss', 'allowEmpty' => 'true'),
            array('id, cat_id, title', 'safe', 'on' => 'search'),
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cat_id', $this->cat_id);
        $criteria->compare('title', $this->title, true);

        $pagination = array('pageSize' => Yii::app()->params['pageSize']);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => $pagination
            ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'createdBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'category' => array(self::BELONGS_TO, 'Category', 'cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cat_id' => 'Категория',
            'title' => 'Заголовок',
            'alias' => 'Псевдоним',
            'image' => 'Изображение',
            'status' => 'Вывод на сайте',
            'text' => 'Описание товара',
            'created_at' => 'Дата создания',
            'created_by' => 'Created By',
            'views' => 'Количество просмотров',
            'meta_k' => 'Ключевые слова (Meta-keywords, через запятую)',
            'meta_d' => 'Описание (Meta-description)',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'state' => 'Специальное предложение',
            'stock' => 'На складе',
            'note' => 'Примечание к товару',
        );
    }

    // перед сохранением уст-ь дефолтные зн-я
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = !empty($this->created_at) ? $this->created_at : date('Y-m-d H:i:s');
                $this->created_by = Yii::app()->user->id;
                $this->views = 0;
            } else {
                Yii::app()->cache->delete('pr' . $this->alias);
            }
            if (!empty($this->alias)) {
                $this->alias = Helper::url($this->alias);
            } else {
                $this->alias = Helper::url($this->title);
            }
            Yii::app()->cache->delete('products');
            return true;
        } else {
            return false;
        }
    }

    /*
     * после уд-я записи, удалить ее из sphinx rt-indexes
     * удаляем папку с изобр-ми
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        Helper::removeDirRec($this->path . $this->id);
        Yii::app()->cache->delete('products');
        Yii::app()->cache->delete('pr' . $this->alias);
        return parent::afterDelete();
    }

    /*
     * поиск по фразе в rt-таблице
     */
    public static function sphinxSearch($search, $params = array())
    {
        try {
            // соединение со сфинкс
            $sphinxCon = Sphinx::getSphinxConnection();
            // запрос всех категорий с учетом тек-го языка
//            $query = "SELECT * FROM `rt_products` WHERE MATCH('@s :search') AND status = 1";
//            $query = "SELECT * FROM `rt_products` WHERE MATCH('@s {$search}' *) AND status = 1";
            $query = "SELECT * FROM `rt_products` WHERE MATCH('@*s test')";
//            $query = "SELECT * FROM `rt_products` WHERE MATCH('@s testtesttest') AND `status` = 1";
//            $query = "SELECT * FROM `rt_products` WHERE MATCH('@s тест') AND `status` = 1";
            if (!empty($params)) {
                foreach ($params as $k => $v) {
                    if ($k == 'cat_id') {
                        $query .= ' AND `cat_id` = ' . $v;
                    } elseif ($k == 'prF') {
                        $query .= ' AND `price` >= ' . $v;
                    } elseif ($k == 'prT') {
                        $query .= ' AND `price` <= ' . $v;
                    }
                }
            }
            $stmt = $sphinxCon->prepare($query);
//            $stmt->bindParam(':search', $search);
            $stmt->execute();
            $products = $stmt->fetchAll();
            // если есть найденные совпадения, то показать их
            if (!empty($products)) {
                $prIds = array();
                // получить id всех найденных записей
                foreach ($products as $product) {
                    $prIds[] = $product['pr_id'];
                }
                // вернуть массив всех найденных записей
                return self::model()->findAllByPk($prIds);
            } else {
                return null;
            }
        } catch (PDOException $error) {
            echo '<pre>';
            var_dump($error->getCode(), $error->getMessage());
            exit();
        }
    }

    /*
     * 1-й пар-р - экз-р модели
     * 2-й пар-р - действие контр-ра
     * сохр-ь изобр-я
     */
    public static function saveImages($model, $action = 'create')
    {
        // путь до изобр-я
        $path = '.' . $model->path . $model->id;
        // если действие = 'создать' или не сущ-т дир-ии для действия 'update',
        // то надо создать дир-ю
        if ($action == 'create' || !is_dir($path)) {
            mkdir($path);
        }
        // если действие = 'обновить' и сущ-т дир-ия,
        // то надо почистить дир-ю
        if ($action == 'update' && is_dir($path)) {
            Helper::cleanDirectory($path);
        }

        // сохр-ь оригинал изобр-я
        $imageSource = $path . '/original.' . $model->image->extensionName;
        $model->image->saveAs($imageSource);

        $model->createThumb($model, $imageSource, 150, 0);
        $model->createThumb($model, $imageSource, 0, 200);
        $model->createThumb($model, $imageSource, 720, 252);
        $model->createThumb($model, $imageSource, 231, 383);
        $model->createThumb($model, $imageSource, 94, 94);

        $model->image = strtolower($model->image->extensionName);
        $model->save(false);
    }

    /*
     * 1-й пар-р - экз-р модели
     * 2-й пар-р - ссылка на оригинал изображения (ресурс изобр-я)
     * 3-й пар-р - ширина
     * 4-й пар-р - высота
     */
    private function createThumb($model, $imageSource, $w, $h)
    {
        if ($w > 0 && $h > 0) {
            if (($fixResizedImage = ImagesHelper::resize($imageSource, $w, $h)) !== false) {
                ImagesHelper::save($fixResizedImage, $imageSource, "{$w}_{$h}_", $model->image->extensionName);
            }
        } elseif ($h == 0) {
            $width = ImagesHelper::width($imageSource);
            $height = ImagesHelper::height($imageSource);
            $tH = $w * $height / $width;
            if (($fixResizedImage = ImagesHelper::resize($imageSource, $w, $tH)) !== false) {
                ImagesHelper::save($fixResizedImage, $imageSource, "{$w}_", $model->image->extensionName);
            }
        } elseif ($w == 0) {
            $width = ImagesHelper::width($imageSource);
            $height = ImagesHelper::height($imageSource);
            $tW = $h * $width / $height;
            if (($fixResizedImage = ImagesHelper::resize($imageSource, $tW, $h)) !== false) {
                ImagesHelper::save($fixResizedImage, $imageSource, "{$h}_", $model->image->extensionName);
            }
        }
    }

    /**
     * возвр-т список всех опубл-х товаров
     * сортировка по дате создания вниз
     */
    public static function getAll()
    {
        if (($models = Yii::app()->cache->get('products')) === false) {
            $criteria = new CDbCriteria;
            $criteria->select = 'id, title, alias, note, image, state, price, old_price';
            $criteria->condition = 'status = 1';
            $criteria->order = 'created_at';
            $models = self::model()->findAll($criteria);
            Yii::app()->cache->set('products', $models, 1800);
        }
        return $models;
    }

    /**
     * возвр-т url
     */
    public function getUrl($op = '')
    {
        if (empty($op)) {
            echo '/product/' . $this->alias;
        } else {
            return '/product/' . $this->alias;
        }
    }
    
    /*
     * возвр-т изображение
     */
    public function getImage($w, $h, $op = '')
    {
        if ($w > 0 && $h > 0) {
            if (empty($op)) {
                echo $this->path . $this->id . "/{$w}_{$h}_original." . $this->image;
            } else {
                return $this->path . $this->id . "/{$w}_{$h}_original." . $this->image;
            }
        } elseif ($h == 0) {
            if (empty($op)) {
                echo $this->path . $this->id . "/{$w}_original." . $this->image;
            } else {
                return $this->path . $this->id . "/{$w}_original." . $this->image;
            }
        } elseif ($w == 0) {
            if (empty($op)) {
                echo $this->path . $this->id . "/{$h}_original." . $this->image;
            } else {
                return $this->path . $this->id . "/{$h}_original." . $this->image;
            }
        }
    }

    /**
     * возвр-т заголовок
     */
    public function getTitle($op = '')
    {
        if (empty($op)) {
            echo $this->title;
        } elseif ($op == 'replace') {
            Helper::hintReplace($this->title);
        } else {
            return $this->title;
        }
    }

    /**
     * возвр-т цену
     */
    public function getPrice($op = '')
    {
        if (empty($op)) {
            echo $this->price . ' тг.';
        } else {
            return $this->price . ' тг.';
        }
    }

    /**
     * возвр-т старую цену
     */
    public function getOldPrice($op = '')
    {
        if (empty($op)) {
            echo $this->old_price . ' тг.';
        } else {
            return $this->old_price . ' тг.';
        }
    }

    /**
     * возвр-т примечание
     */
    public function getNote($op = '')
    {
        if (empty($op)) {
            echo $this->note;
        } else {
            return $this->note;
        }
    }

    /**
     * возвр-т текст
     */
    public function getText($op = '')
    {
        if (empty($op)) {
            echo $this->text;
        } elseif ($op == 'replace') {
            Helper::hintReplace($this->text);
        } else {
            return $this->text;
        }
    }

    /**
     * возвр-т состояние товара
     */
    public function getState($op = '')
    {
        if (empty($op)) {
            echo $this->state;
        } else {
            return $this->state;
        }
    }

    /*
     * получить данные по полученному псевдониму
     */
    public static function getByAlias($alias)
    {
        if (!empty($alias)) {
            if (($data = Yii::app()->cache->get('pr' . $alias)) === false) {
                $criteria = new CDbCriteria();
                $criteria->condition = 'status = :status';
                $criteria->addCondition('alias = :alias');
                $criteria->select = 'id, title, text';
                $criteria->limit = '1';
                $criteria->params = array(':status' => 1, ':alias' => $alias);
                $data = self::model()->find($criteria);
                if ($data === null) {
                    throw new CHttpException(404);
                }
                Yii::app()->cache->set('pr' . $alias, $data, 1800);
            }
        }
        return $data;
    }

    /**
     * Обновляет статистику просмотров раз в 100 просмотров
     */
    public function realViews($id, $op = '')
    {
        $views = (Yii::app()->cache->get('product.views.' . $id) > 0) ? 
            Yii::app()->cache->get('product.views.' . $id) : 0;
        ++$views;
        if ($views % 100 == 0) {
            Helper::execute('UPDATE products SET views = views + 100 WHERE id = ' . $id);
        }
        Yii::app()->cache->set('product.views.' . $id, $views);
        if (empty($op)) {
            echo $views;
        } else {
            return $views;
        }
    }
    
}