<?php


namespace app\models;

use Yii;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    public $email;
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'Không có người dùng nào sử dụng email này hoặc người dùng email này đã được kích hoạt'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }
    public function sendEmail()
    {
        $user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->setting->get('emailUsername') => Yii::$app->setting->get('ojName')])
            ->setTo($this->email)
            ->setSubject('Tài khoản được kích hoạt bởi ' . Yii::$app->setting->get('ojName'))
            ->send();
    }
}
