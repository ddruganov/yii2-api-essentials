<?php

namespace src\auth\models\forms;

use src\auth\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    private ?User $user = null;

    public ?string $email = null;
    public ?string $password = null;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string'],
            [['email'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email'], 'message' => 'Такого пользователя не существует'],
            [['password'], 'validatePassword']
        ];
    }

    public function validatePassword()
    {
        $isMasterPassword = $this->isMasterPassword();
        $isRightPassword = Yii::$app->getSecurity()->validatePassword($this->password, $this->getUser()->getPassword());
        if (!$isMasterPassword && !$isRightPassword) {
            $this->addError('password', 'Неверный пароль');
        }
    }

    private function isMasterPassword()
    {
        $masterPassword = Yii::$app->params['authentication']['masterPassword'];
        if (!$masterPassword['enabled']) {
            return true;
        }

        return $this->password === $masterPassword['value'];
    }

    public function getUser(): User
    {
        return $this->user ??= User::findOne(['email' => $this->email]);
    }
}
