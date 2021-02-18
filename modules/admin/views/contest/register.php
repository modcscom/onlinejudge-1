<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\Contest;

$this->title = $model->title;
$contest_id = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
?>
<h1><?= Html::encode($model->title) ?></h1>

<?php Modal::begin([
    'header' => '<h2>' . Yii::t('app', 'Add participating user') . '</h2>',
    'toggleButton' => ['label' => Yii::t('app', 'Add participating user'), 'class' => 'btn btn-success'],
]);?>
<?= Html::beginForm(['contest/register', 'id' => $model->id]) ?>
    <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <p class="text-muted">Đây là cuộc thi Offline. Các tài khoản được thêm vào đây sẽ được gắn dấu sao trên bảng xếp hạng và sẽ không tham gia vào bảng xếp hạng</p>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::label(Yii::t('app', 'User'), 'user') ?>
        <?= Html::textarea('user', '',['class' => 'form-control', 'rows' => 10]) ?>
        <p class="hint-block">Nhập tên người dùng muốn tham gia, một tên người dùng trên một dòng, không có dòng trống thừa.</p>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>
<?php Modal::end(); ?>

<?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
    <?php Modal::begin([
        'header' => '<h2>' . Yii::t('app', 'Generate user for the contest') . '</h2>',
        'toggleButton' => ['label' => Yii::t('app', 'Generate user for the contest'), 'class' => 'btn btn-success'],
    ]);?>
        <p class="text-muted">Bạn có thể tạo tài khoản cho cuộc thi Offline tại đây.</p>
        <p class="text-danger">Lưu ý: Trong cùng một cuộc thi, sử dụng nhiều lần chức năng này sẽ xóa tài khoản đã tạo trước đó, vui lòng không thực hiện thao tác này sau khi cuộc thi bắt đầu.</p>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($generatorForm, 'prefix')->textInput([
                'maxlength' => true, 'value' => 'c' . $model->id . 'user', 'disabled' => true
        ]) ?>

        <?= $form->field($generatorForm, 'team_number')->textInput(['maxlength' => true, 'value' => '50']) ?>

        <?= $form->field($generatorForm, 'names')->textarea(['rows' => 10])  ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
    <?= Html::a(Yii::t('app', 'Copy these accounts to distribute'), ['contest/printuser', 'id' => $model->id], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => Yii::t('app', 'Username'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model->user->username, ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => Yii::t('app', 'Nickname'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model->user->nickname, ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'user_password',
            'value' => function ($contestUser, $key, $index, $column) use ($model) {
                if ($model->scenario == Contest::SCENARIO_OFFLINE) {
                    return $contestUser->user_password;
                } else {
                    return 'Mật khẩu không được cung cấp trong cuộc thi Online';
                }
            },
            'format' => 'raw',
            'visible' => $model->scenario == Contest::SCENARIO_OFFLINE
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($contest_id) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => 'Xóa mục này cũng sẽ xóa bài nộp của thí sinh trong cuộc thi này. Bạn có chắc chắn xóa nó không?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['contest/register', 'id' => $contest_id, 'uid' => $model->user->id]), $options);
                },
            ]
        ],
    ],
]); ?>
