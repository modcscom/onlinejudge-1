<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Vui lòng truy cập vào liên kết bên dưới để xác minh email:

<?= $verifyLink ?>
