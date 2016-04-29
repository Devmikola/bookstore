<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 *
 * @property Author $author
 */
class Book extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'name', 'date'], 'required', 'message' => 'Поле "{attribute}" не заполнено.'],
            [['date_create', 'date_update', 'date'], 'safe'],
            [['author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpeg, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Date Update',
            'preview' => 'Ссылка на превью книги',
            'date' => 'Дата выхода',
            'author_id' => 'Автор',
            'imageFile' => 'Изображение-превью книги'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function uploadImageFile()
    {
        if ($this->validate()) {

            if($this->preview)
            {
                Yii::$app->get('s3bucket')->delete('book_preview/' . substr($this->preview, strrpos($this->preview, '/') + 1));
            }

            if(Yii::$app->get('s3bucket')->upload('book_preview/' . $this->imageFile->baseName . '.' . $this->imageFile->extension,
                $this->imageFile->tempName))
            {
                $this->preview = Yii::$app->get('s3bucket')->getUrl('book_preview/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            } else {
                throw new Exception("File was not loaded, check the logs.");
            }
            return true;
        } else {
            return false;
        }
    }

}
