<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property double $rate
 * @property double $gain
 * @property integer $user_position
 * @property integer $correct_position
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Log extends ActiveRecord
{
    const TYPE_LOSE = 0;
    const TYPE_WIN = 1;

    /**
     * @return array
     */
    public static function getType()
    {
        return [
            self::TYPE_LOSE => 'Проигрыш',
            self::TYPE_WIN  => 'Выигрыш'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rate', 'gain', 'user_position', 'correct_position', 'type'], 'required'],
            [['user_id', 'user_position', 'correct_position', 'type', 'created_at', 'updated_at'], 'integer'],
            [['rate', 'gain'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'user_id'          => 'Пользователь',
            'rate'             => 'Ставка',
            'gain'             => 'Выигрыш',
            'user_position'    => 'Ответ пользователя',
            'correct_position' => 'Правильный ответ',
            'type'             => 'Тип',
            'created_at'       => 'Дата игры',
            'updated_at'       => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
