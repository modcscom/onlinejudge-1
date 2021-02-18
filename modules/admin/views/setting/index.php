<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Setting');

?>

<div class="setting-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>
    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OJ Name'), 'ojName') ?>
        <?= Html::textInput('ojName', $settings['ojName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OI Mode'), 'oiMode') ?>
        <?= Html::radioList('oiMode', $settings['oiMode'], [
            1 => 'Yes',
            0 => 'No'
        ]) ?>
        <p class="hint-block">
            If you want enable OI mode, please select yes button and add the parameter (-o) when starting the judgment service.
        </p>
        <p class="hint-block">Open /home/judge/onlinejudge/judge and run <code>sudo ./dispatcher -o</code> to enable OI mode.</p>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'School Name'), 'ojName') ?>
        <?= Html::textInput('schoolName', $settings['schoolName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Do you want to share code'), 'isShareCode') ?>
        <?= Html::radioList('isShareCode', $settings['isShareCode'], [
            1 => 'Yes',
            0 => 'No'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Scoreboard frozen time'), 'scoreboardFrozenTime') ?>
        <?= Html::textInput('scoreboardFrozenTime', $settings['scoreboardFrozenTime'], ['class' => 'form-control']) ?>
        <p class="hint-block">This time is calculated from the end of the contest.</p>
    </div>

    <hr>
    <div class="form-horizontal">
        <h4>SMTP configuration</h4>

        <div class="form-group">
            <?= Html::label('Password Reset Token Expire', 'passwordResetTokenExpire', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('passwordResetTokenExpire', $settings['passwordResetTokenExpire'], ['class' => 'form-control']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Verify the email?', 'mustVerifyEmail', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::radioList('mustVerifyEmail', $settings['mustVerifyEmail'], [
                    1 => 'Yes',
                    0 => 'No'
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Host', 'emailHost', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailHost', $settings['emailHost'], ['class' => 'form-control', 'placeholder' => 'smtp.exmail.qq.com']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Username', 'emailUsername', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailUsername', $settings['emailUsername'], ['class' => 'form-control', 'placeholder' => 'no-reply@t36oj.tk']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Password', 'emailPassword', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPassword', $settings['emailPassword'], ['class' => 'form-control', 'placeholder' => 'you_password']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Port', 'emailPort', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPort', $settings['emailPort'], ['class' => 'form-control', 'placeholder' => '465']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Encryption', 'emailEncryption', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailEncryption', $settings['emailEncryption'], ['class' => 'form-control', 'placeholder' => 'ssl']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>

</div>
