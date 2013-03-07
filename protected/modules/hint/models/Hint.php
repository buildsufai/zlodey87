<?php

/**
 * This is the model class for table "hints".
 *
 * The followings are the available columns in table 'hints':
 * @property integer $id
 * @property string $q
 * @property string $hint
 */
class Hint extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Hint the static model class
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
        return 'hints';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('q, hint', 'required'),
            array('q', 'length', 'max' => 255),
            array('q', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, q, hint', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'q' => 'Не понятный термин',
            'hint' => 'Подсказка',
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
        $criteria->compare('q', $this->q, true);
        $criteria->compare('hint', $this->hint, true);

        $pagination = array('pageSize' => Yii::app()->params['pageSize']);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => $pagination
            ));
    }

    // перед сохранением уст-ь дефолтные зн-я
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            Yii::app()->cache->delete('hints');
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
        Yii::app()->cache->delete('hints');
    }

    /**
     * возвр-т список всех записей
     */
    public static function getAll()
    {
        if (($models = Yii::app()->cache->get('hints')) === false) {
            $models = self::model()->findAll();
            Yii::app()->cache->set('hints', $models, 1800);
        }
        return $models;
    }

}