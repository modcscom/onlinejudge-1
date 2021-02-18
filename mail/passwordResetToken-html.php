<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Vui lòng truy cập vào liên kết bên dưới để đặt lại mật khẩu của bạn:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
