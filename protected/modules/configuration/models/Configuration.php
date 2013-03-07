<?php

/**
 * This is the model class for table "configurations".
 *
 * The followings are the available columns in table 'configurations':
 * @property integer $id
 * @property string $header_info
 * @property string $footer_info
 * @property string $email
 * @property string $img
 */
class Configuration extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Configuration the static model class
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
        return 'configurations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('header_info, footer_info, email', 'required'),
            array('email', 'length', 'max' => 100),
            array('email', 'email'),
            array('img', 'file',
                'types' => 'jpg, jpeg, gif, png', // допустимые форматы
                'maxSize' => 1048576, // 1 MB
                'allowEmpty' => 'true', // можно не загружать
                'tooLarge' => 'Файл весит больше 1 MB. Пожалуйста, загрузите файл меньшего размера.',
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, header_info, footer_info, email', 'safe'),
            array('id, header_info, footer_info, email', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'header_info' => 'Информация в шапке',
            'footer_info' => 'Информация в футере',
            'email' => 'Email',
            'img' => 'Изображение 210/130',
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
        $criteria->compare('header_info', $this->header_info, true);
        $criteria->compare('footer_info', $this->footer_info, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
    }
    
    /*
     * 1-й пар-р - экз-р модели
     * 2-й пар-р - действие контр-ра
     * сохр-ь изобр-я
     */
    public static function saveImages($model)
    {
        // путь до изобр-я
        $path = './images/config';
        // если действие = 'обновить' и сущ-т дир-ия,
        // то надо почистить дир-ю
        Helper::cleanDirectory($path);

        // сохр-ь оригинал изобр-я
        $imageSource = $path . '/original.' . $model->img->extensionName;
        $model->img->saveAs($imageSource);

        $width = ImagesHelper::width($imageSource);
        $height = ImagesHelper::height($imageSource);

        // создание миниатюры изображения
        $thumbWidth = 150; // ширина будущего изображения в px
        $thumbHeight = $thumbWidth * $height / $width; // высота будущего изображения в px
        if ($fixResizedImage = ImagesHelper::resize($imageSource, $thumbWidth, $thumbHeight)) {
            // сохранение полученного изображения
            ImagesHelper::save($fixResizedImage, $imageSource, '150_', $model->img->extensionName);
        }

        // создание миниатюры изображения
        $widthThumb = 210; // ширина будущего изображения в px
        $heightThumb = 130; // высота будущего изображения в px
        if ($fixResizedImage = ImagesHelper::resize($imageSource, $widthThumb, $heightThumb)) {
            // сохранение полученного изображения
            ImagesHelper::save($fixResizedImage, $imageSource, '210_130_', $model->img->extensionName);
        }

        // save image extension
        $model->img = strtolower($model->img->extensionName);
        $model->save(false);
    }

    // перед сохранением уст-ь дефолтные зн-я
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            Yii::app()->cache->delete('config');
            return true;
        } else {
            return false;
        }
    }

    public static function getConfig()
    {
        if (($data = Yii::app()->cache->get('config')) === false) {
            $data = self::model()->findByPk(1);
            Yii::app()->cache->set('config', $data);
        }
        if ($data === null) {
            throw new CHttpException(404);
        }
        return $data;
    }

}