<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;


$this->title = Yii::t('app', 'Users');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        Selected items:
        <a id="general-user" class="btn btn-success" href="javascript:void(0);">
            Set as Normal user
        </a>
        <a id="vip-user" class="btn btn-success" href="javascript:void(0);">
            Set as VIP user
        </a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['id' => 'grid'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            'id',
            'username',
           // 'nickname',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->role == \app\models\User::ROLE_PLAYER) {
                        return 'Contestant';
                    } else if ($model->role == \app\models\User::ROLE_USER) {
                        return 'Normal User';
                    } else if ($model->role == \app\models\User::ROLE_VIP) {
                        return 'VIP User';
                    } else if ($model->role == \app\models\User::ROLE_ADMIN) {
                        return 'Administrator';
                    }
                    return 'not set';
                },
                'format' => 'raw'
            ],
    
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    $this->registerJs('
    $("#general-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "'.\yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_USER]).'", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#vip-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "'.\yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_VIP]).'", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    ');
    ?>
</div>
