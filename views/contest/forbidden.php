<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Contest;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['model'] = $model;
?>
<?php if ($model->status == Contest::STATUS_PRIVATE): ?>
    <h2 class="text-center">Chỉ những người tham gia cuộc thi mới xem được nội dung.</h2>
    <?php
        $this->title = Yii::$app->setting->get('ojName');
        $this->params['model']->title = '';
        $this->params['model']->start_time = '';
        $this->params['model']->end_time = '';
    ?>
<?php else: ?>
    <h4 class="text-left">Bạn chưa đăng ký tham gia cuộc thi</h4>
    <h4 class="text-left">Vui lòng đăng ký trước hoặc quay lại sau khi cuộc thi kết thúc</h4>
    <hr>
    <?php if ($model->getRunStatus() == Contest::STATUS_RUNNING): ?>
        <a href="<?= Url::toRoute(['/contest/standing2', 'id' => $model->id]) ?>">
            <h3 class="text-center">Xem bảng xếp hạng</h3>
        </a>
    <?php endif; ?>
    <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <p>Cuộc thi theo hình thức offline, nếu bạn có nhu cầu tham gia vui lòng liên hệ quản trị viên</p>
    <?php else: ?>
        <h4>Điều khoản tham gia</h4>
        <p>1. Không chia sẻ bài nộp với người khác</p>
        <p>2. Không tấn công, phá hoại hệ thống dưới mọi hình thức</p>

        <?= Html::a(Yii::t('app', 'Chấp nhận và đăng ký'), ['/contest/register', 'id' => $model->id, 'register' => 1]) ?>
    <?php endif; ?>
<?php endif; ?>