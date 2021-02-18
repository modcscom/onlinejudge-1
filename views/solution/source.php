<?php

use yii\helpers\Html;

$this->title = $model->id;

if (!$model->canViewSource()) {
    return 'Không được phép xem mã nguồn';
}
?>
<div class="solution-view">
    <div class="row">
        
        <div class="col-md-6">
            <p><?= Yii::t('app', 'Submit Time') ?>：<?= $model->created_at ?></p>
        </div>
        <div class="col-md-6">
            <p>Run ID: <?= Html::a($model->id, ['/solution/detail', 'id' => $model->id]) ?></p>
        </div>
    </div>
    <div class="pre"><p><?= Html::encode($model->source) ?></p></div>
</div>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('.pre p').each(function(i, block) {  
                hljs.highlightBlock(block);
            });
        })
    })(jQuery);
</script>