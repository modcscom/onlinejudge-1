<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Polygon System');
?>
<h2><?= $this->title ?></h2>
<p><?= Yii::t('app', 'You can prepare the problem professionally') ?>. Reference at <a href="https://polygon.codeforces.com/" target="_blank">Codeforces Polygon</a></p>
<hr>
<div class="problem-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Problem'), ['/polygon/problem/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('/problem/_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->user) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                    }
                    return '';
                },
                'format' => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'problem'
            ],
        ],
    ]); ?>
</div>
