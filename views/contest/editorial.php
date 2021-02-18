<?php

use yii\helpers\Html;

$this->title = Html::encode($model->title);
$this->params['model'] = $model;
?>
<div class="contest-editorial">
    <div style="padding: 50px">
        <?php
        if ($model->editorial != NULL) {
            echo Yii::$app->formatter->asHtml($model->editorial);
        } else {
            echo 'Tác giả đã ra đảo chơi với khỉ, hiện không có ở đây để hướng dẫn =))';
        }
        ?>
    </div>
</div>
