<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Log;

/**
 * LogForm
 */
class LogForm extends Model
{
    public $id;
    public $user_id;
    public $rate;
    public $gain;
    public $user_position;
    public $correct_position;
    public $type;

    protected $_model = null;

    /**
    * AR model Group
    */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = $this->id ? Log::findOne((int)$this->id) : new Log();
        }
        return $this->_model;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rate', 'user_position', 'correct_position'], 'required'],
            [['user_id', 'user_position', 'correct_position', 'type'], 'integer'],
            [['rate', 'gain'], 'number'],
            ['rate', 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            ['rate', 'validateRate'],
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
            'user_position'    => 'Ответ',
            'correct_position' => 'Правильный ответ',
            'type'             => 'Тип',
        ];
    }

    /**
     * Валидация ставки
     * Ставка должна быть <= баланса пользователя
     *
     * @param string $attribute
     * @param array $params
     */
    public function validateRate($attribute, $params)
    {
        $user = User::findOne($this->user_id);

        if ($user)
        {
            if ($user->balance < $this->rate)
            {
                $this->addError($attribute, 'Ставка не должна превышать ваш баланс.');
            }
        }
    }

    public function save()
    {
        if ($this->validate())
        {
            $this->model->setAttributes($this->getAttributes());
            $this->model->loadDefaultValues();
            $this->model->type = $this->user_position == $this->correct_position ? Log::TYPE_WIN : Log::TYPE_LOSE;
            $this->model->gain = $this->user_position == $this->correct_position ? 
                round($this->model->rate + 0.1*$this->model->rate, 1) : -$this->model->rate;


            if($this->model->save())
            {
                $this->id = $this->model->id;
                $this->gain = $this->model->gain;
                $this->type = $this->model->type;

                $user = User::findOne($this->user_id);
                $user->balance = $user->balance + $this->gain;
                $user->save();

                return true;
            }            
        }

        return false;
    }

    public function getIsNewRecord()
    {
        return $this->model->isNewRecord;
    }
}
