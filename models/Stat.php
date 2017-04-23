<?php

namespace app\models;

use Yii;
use app\models\query\StatQuery;

/**
 * This is the model class for table "stat".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $cnt
 * @property double $value
 * @property integer $is_current
 *
 * @property User $user
 */
class Stat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'cnt', 'is_current'], 'integer'],
            [['value'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'Пользователь',
            'cnt'        => 'Кол-во побед',
            'value'      => 'Сумма выигрыша минус проигрыш',
            'is_current' => 'Флаг актуальности',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\StatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatQuery(get_called_class());
    }
}
