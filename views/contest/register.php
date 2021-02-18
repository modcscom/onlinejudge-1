<?php

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2>Cuộc thi sắp diễn ra: <?= Html::encode($model->title) ?></h2>

<h4>Điều khoản tham gia</h4>
<p>1. Không chia sẻ bài nộp với người khác</p>
<p>2. Không tấn công, phá hoại hệ thống dưới mọi hình thức</p>

<?= Html::a(Yii::t('app', 'Chấp nhận và đăng ký'), ['/contest/register', 'id' => $model->id, 'register' => 1]) ?>
