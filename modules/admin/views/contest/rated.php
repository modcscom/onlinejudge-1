<?php

use yii\helpers\Html;
use app\models\Contest;
use yii\grid\GridView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
?>
<div class="contest-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>Nhấp vào nút bên dưới để tính điểm của những người dùng tham gia cuộc thi. Điểm được dùng để xếp hạng trong bảng xếp hạng.</p>
    <?php if ($model->getRunStatus() == Contest::STATUS_ENDED): ?>
        <?= Html::a('Rated', ['rated', 'id' => $model->id, 'cal' => 1], ['class' => 'btn btn-success']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'who',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                    },
                    'format' => 'raw'
                ],
                'rating_change'
            ],
        ]); ?>
    <?php else: ?>
        <p>Cuộc thi chưa kết thúc, vui lòng tính điểm sau khi cuộc thi kết thúc.</p>
    <?php endif; ?>
</div>
