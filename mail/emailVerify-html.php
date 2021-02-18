<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Vui lòng truy cập vào liên kết bên dưới để xác minh email: </p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
