<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property integer $menu
 * @property integer $sort
 * @property integer $parent_id
 * @property string $title_a
 * @property string $title_h
 * @property string $meta_k
 * @property string $meta_d
 * @property string $announce
 * @property string $menu_t
 * @property integer $status
 * @property string $image
 */
class Page extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Pages the static model class
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
        return 'pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, alias, text, menu, sort, announce, menu_t, status', 'required'),
            array('menu, sort, parent_id, status', 'numerical', 'integerOnly' => true),
            array('title_a, title_h, menu_t', 'length', 'max' => 100),
            array('status, menu', 'in', 'range' => array(0, 1)),
            array('title, alias', 'unique'),
            array('meta_k, meta_d', 'length', 'max' => 255),
            array('image', 'file',
                'types' => 'jpg, gif, png', // допустимые форматы
                'maxSize' => 1048576, // 1 MB
                'allowEmpty' => 'true', // можно не загружать
                'tooLarge' => 'Файл весит больше 1 MB. Пожалуйста, загрузите файл меньшего размера.',
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alias, text, menu, sort, parent_id, title_a, title_h, meta_k, meta_d, announce, menu_t, status, image', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'menu' => 'Показать в меню',
            'parent_id' => 'Родительская запись',
            'menu_t' => 'Заголовок в меню',
            'title' => 'Заголовок',
            'alias' => 'Псевдоним',
            'image' => 'Изображение',
            'status' => 'Вывод на сайте',
            'sort' => 'Порядок сорировки',
            'announce' => 'краткое описание',
            'text' => 'основной материал',
            'title_a' => 'Title-ссылки',
            'title_h' => 'Заголовок',
            'meta_k' => 'Ключевые слова (Meta-keywords, через запятую)',
            'meta_d' => 'Описание (Meta-description)',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('menu', $this->menu);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title_a', $this->title_a, true);
        $criteria->compare('title_h', $this->title_h, true);
        $criteria->compare('meta_k', $this->meta_k, true);
        $criteria->compare('meta_d', $this->meta_d, true);
        $criteria->compare('announce', $this->announce, true);
        $criteria->compare('menu_t', $this->menu_t, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('image', $this->image, true);

        $pagination = array('pageSize' => Yii::app()->params['pageSize']);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
        ));
    }

    // перед сохранением уст-ь дефолтные зн-я
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if (!empty($this->alias)) {
                $this->alias = Helper::url($this->alias);
            } else {
                $this->alias = Helper::url($this->title);
            }
            // сбросить кэш
            Yii::app()->cache->delete('all.page.title');
            if (!$this->isNewRecord) {
                if ($this->id == 1) {
                    Yii::app()->cache->delete('about');
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /*
     * после удаления материала из таблицы, удаляем его папку с изобр-ми
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        // сбросить родит-й элемент у потомков, удаляемой записи
        self::model()->updateAll(array('parent_id' => 0),  'parent_id = ' . $this->id);
        // путь до изобр-я
        $path = './images/page/' . $this->id;
        Helper::removeDirRec($path);
        // сбросить кэш
        Yii::app()->cache->delete('all.page.title');
    }

    /*
     * 1-й пар-р - экз-р модели
     * 2-й пар-р - действие контр-ра
     * сохр-ь изобр-я
     */
    public static function saveImages($model, $action = 'create')
    {
        // путь до изобр-я
        $path = './images/page/' . $model->id;
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

        $width = ImagesHelper::width($imageSource);
        $height = ImagesHelper::height($imageSource);

        // создание миниатюры изображения
        $thumbWidth = 150; // ширина будущего изображения в px
        $thumbHeight = $thumbWidth * $height / $width; // высота будущего изображения в px
        if ($fixResizedImage = ImagesHelper::resize($imageSource, $thumbWidth, $thumbHeight)) {
            // сохранение полученного изображения
            ImagesHelper::save($fixResizedImage, $imageSource, '150_', $model->image->extensionName);
        }

        // создание миниатюры изображения
        $widthThumb = 51; // ширина будущего изображения в px
        $heightThumb = 35; // высота будущего изображения в px
        if ($fixResizedImage = ImagesHelper::resize($imageSource, $widthThumb, $heightThumb)) {
            // сохранение полученного изображения
            ImagesHelper::save($fixResizedImage, $imageSource, '51_35_', $model->image->extensionName);
        }

        // save image extension
        $model->image = strtolower($model->image->extensionName);
        $model->save(false);
    }

    /**
     * возвр-т список всех опубл-х записей
     */
    public static function getAll()
    {
        if (($models = Yii::app()->cache->get('all.page.title')) === false) {
            $models = self::model()->findAll(array('order' => 'title', 'condition' => 'status = 1'));
            Yii::app()->cache->set('all.page.title', $models, 600);
        }
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    // about
    public static function getAbout()
    {
        if (($model = Yii::app()->cache->get('about')) === false) {
            $model = self::model()->findByPk(1);
            Yii::app()->cache->set('about', $model, 6000);
        }
        if ($model === null) {
            throw new CHttpException(404);
        }
        return $model;
    }
    
}