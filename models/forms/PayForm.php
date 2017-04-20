<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Pay;

/**
 * PayForm
 */
class PayForm extends Model
{
    public $id;
    public $user_id;
    public $value;

    protected $_model = null;

    /**
    * AR model Group
    */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = $this->id ? Pay::findOne((int)$this->id) : new Pay();
        }
        return $this->_model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'number'],
            ['value', 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
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
            'value'      => 'Сумма',
        ];
    }

    public function save()
    {
        if ($this->validate())
        {
            $this->model->setAttributes($this->getAttributes());
            $this->model->loadDefaultValues();

            if($this->model->save())
            {
                $this->id = $this->model->id;

                $user = User::findOne($this->user_id);
                $user->balance = $user->balance + $this->value;
                $user->save();

                return true;
            }            
        }

        return false;
    }
}
