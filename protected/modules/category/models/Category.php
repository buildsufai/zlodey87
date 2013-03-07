<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property Blog[] $blogs
 */
class Category extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Category the static model class
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
        return 'categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('title, alias', 'unique'),
            array('sort, parent_id', 'numerical', 'integerOnly' => true),
            array('title, alias', 'length', 'max' => 100),
            array('status', 'in', 'range' => array(0, 1)),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alias, status, sort, parent_id', 'safe'),
            array('id, title, alias, status', 'safe', 'on' => 'search'),
        );
    }
    
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);

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
            'blogs' => array(self::HAS_MANY, 'Blog', 'cat_id'),
            'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'alias' => 'Псевдоним',
            'status' => 'Вывод на сайте',
            'sort' => 'Порядок сорировки',
            'parent_id' => 'Родительская запись',
        );
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
            if (!$this->isNewRecord) {
                Yii::app()->cache->delete('cat' . $this->alias);
            }
            // сбросить кэш
            Yii::app()->cache->delete('all.cat.title');
            Yii::app()->cache->delete('all.cat.title2');
            return true;
        } else {
            return false;
        }
    }

    /*
     * после удаления записи из таблицы
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        // сбросить кэш
        Yii::app()->cache->delete('all.cat.title');
        Yii::app()->cache->delete('all.cat.title2');
        Yii::app()->cache->delete('cat' . $this->alias);
        // удалить дочерние записи
        self::model()->deleteAll('parent_id = ' . $this->id);
    }

    /**
     * возвр-т список всех опубл-х категорий
     */
    public static function getAll()
    {
        if (($models = Yii::app()->cache->get('all.cat.title')) === false) {
            $models = self::model()->findAll(array('order' => 'title', 'condition' => 'status = 1'));
            Yii::app()->cache->set('all.cat.title', $models, 1800);
        }
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * возвр-т список всех опубл-х категорий
     */
    public static function getAll2()
    {
        if (($models = Yii::app()->cache->get('all.cat.title2')) === false) {
            $models = self::model()->findAll(array('order' => 'title', 'condition' => 'status = 1'));
            Yii::app()->cache->set('all.cat.title2', $models, 1800);
        }
        return $models;
    }

    /**
     * возвр-т url
     */
    public function getUrl()
    {
        return '/catalog/' . $this->alias;
    }

    /*
     * получить данные по полученному псевдониму
     */
    public static function getByAlias($alias)
    {
        if (!empty($alias)) {
            if (($data = Yii::app()->cache->get('cat' . $alias)) === false) {
                $criteria = new CDbCriteria();
                $criteria->condition = 'status = :status';
                $criteria->addCondition('alias = :alias');
                $criteria->select = 'id, title';
                $criteria->limit = '1';
                $criteria->params = array(':status' => 1, ':alias' => $alias);
                $data = self::model()->find($criteria);
                if ($data === null) {
                    throw new CHttpException(404);
                }
                Yii::app()->cache->set('cat' . $alias, $data, 1800);
            }
        }
        return $data;
    }

}