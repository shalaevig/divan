<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

use common\models\query\FeedbackQuery;

/**
 * Модель обратной связи.
 */ 
class Feedback extends ActiveRecord 
{

    /**
     * Состояния.
     */ 
    const STATUS_MODERATION = 0;
    const STATUS_PROCESS = 1;
    const STATUS_REJECT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * Получить массив состояний.
     * 
     * @return array
     */ 
    public static function getStatusList() 
    {
        return [
            self::STATUS_MODERATION => 'На модерации',
            self::STATUS_PROCESS => 'Обработана',
            self::STATUS_REJECT => 'Отклонена',
        ];
    }

    /**
     * Получить текстовое описание состояния.
     * 
     * @return string
     */ 
    public function getStatusValue() 
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['customer'], 'string', 'max' => 256],
            [['phone'], 'string', 'max' => 50],
            [['phone'], 'match', 
                'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}/', 
                'message' => 'Телефон должен быть в формате +7(999)999-99-99'],
            [['customer'],
                'filter', 'filter' => function($value) {
                    return trim(strip_tags($value));
                },
                'skipOnEmpty' => true
            ],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'customer' => 'ФИО',
            'phone' => 'Телефон',
            'status' => 'Состояние',
        ];
    }

}
