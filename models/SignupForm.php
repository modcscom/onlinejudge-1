<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $verifyCode;
    public $studentNumber;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['studentNumber', 'integer'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Tên người dùng đã tồn tại.'],
            ['username', 'string', 'max' => 16, 'min' => 4],
            ['username', 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{4,16}$)[a-z\d_]{4,16}$/i', 'message' => 'Tên người dùng có thể gồm chữ số, chữ cái latin, dấu gạch dưới, không có ký tự đặc biệt, không phải một số nguyên, độ dài từ 4-16 ký tự.'],
            ['username', 'match', 'pattern' => '/^(?!c[\d]+user[\d])/', 'message' => 'Use c+number+user+number as the account name system reserved'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Email đã được đăng ký bởi người dùng khác.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 16],

            ['verifyCode', 'captcha']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Tên người dùng',
            'password' => 'Mật khẩu',
            'email' => 'Email',
            'verifyCode' => 'Mã xác thực',
            'studentNumber' => 'Mã sinh viên'
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->nickname = $this->username;
        $user->email = $this->email;
        $user->is_verify_email = User::VERIFY_EMAIL_NO;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if (Yii::$app->setting->get('mustVerifyEmail')) {
            $user->generateEmailVerificationToken();
            if (!$this->sendEmail($user)) {
                Yii::$app->session->setFlash('error','Hệ thống không thể gửi email xác thực tài khoản.');
                return null;
            }
            $user->status = User::STATUS_INACTIVE;
        } else {
            $user->status = User::STATUS_ACTIVE;
        }
        if (!$user->save()) {
            return null;
        }
        Yii::$app->db->createCommand()->insert('{{%user_profile}}', [
            'user_id' => $user->id,
            'student_number' => $this->studentNumber
        ])->execute();
        return $user;
    }

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->setting->get('emailUsername') => Yii::$app->setting->get('ojName')])
            ->setTo($this->email)
            ->setSubject('Đăng ký tài khoản - ' . Yii::$app->setting->get('ojName'))
            ->send();
    }
}
