<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * UserForm
 */
class UserForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;

    protected $_model = null;

    /**
    * AR model User
    */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = $this->id ? User::findOne((int)$this->id) : new User();
        }
        return $this->_model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'name'          => 'ФИО',
            'email'         => 'Email',
            'password'      => 'Пароль',
        ];
    }

    public function save()
    {
        if ($this->validate())
        {
            $this->model->setAttributes($this->getAttributes());
            $this->model->loadDefaultValues();

            $this->model->setPassword($this->password);

            if($this->model->save())
            {
                $this->id = $this->model->id;

                return true;
            }            
        }

        return false;
    }

    public static function find()
    {
        $query = User::find();

        return $query;
    }
}
