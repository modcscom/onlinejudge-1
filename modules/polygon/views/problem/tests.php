<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\polygon\models\Problem;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$files = $model->getDataFiles();
?>

<?php if (extension_loaded('zip')): ?>
    <p>
        <?= Html::a('Download all data', ['download-data', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
    </p>
<?php else: ?>
    <p>
        The server does not enable the php-zip extension. If you need to download the test data, please install the php-zip extension.
    </p>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered table-rank">
        <thead>
        <tr>
            <th width="80px">ID</th>
            <th>Verdict</th>
            <th>Time</th>
            <th>Memory</th>
            <th>Submit Time</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?= Html::a($solutionStatus['id'], ['/polygon/problem/solution-detail', 'id' => $model->id, 'sid' => $solutionStatus['id']]) ?></th>
            <th><?= Problem::getResultList($solutionStatus['result']) ?></th>
            <th><?= $solutionStatus['time'] ?>MS</th>
            <th><?= $solutionStatus['memory'] ?>KB</th>
            <th><?= $solutionStatus['created_at'] ?></th>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-4">
        <p>
            After uploading the input file, click RUN for the system to automatically generate the output file. 
        </p>
        <p class="text-info">
            Refresh the page after uploading to see the result
        </p>
        <?= \app\widgets\webuploader\MultiImage::widget() ?>
        <p></p>
        <?= Html::a(Yii::t('app', 'Run'), ['/polygon/problem/run', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </div>


    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                <caption>
                    Standard input file
                    <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => 'in']) ?>" onclick="return confirm('Are you sure to delete all input files?');">Delete all input files</a>
                </caption>
                <tr>
                    <th>File name</th>
                    <th>Size</th>
                    <th>Time modified</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($files as $file): ?>
                    <?php
                        if (!strpos($file['name'], '.in'))
                        continue;
                    ?>
                    <tr>
                        <th><?= $file['name'] ?></th>
                        <th><?= $file['size'] ?></th>
                        <th><?= date('Y-m-d H:i', $file['time']) ?></th>
                        <th><a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id,'name' => $file['name']]) ?>"
                            target="_blank"
                            title="<?= Yii::t('app', 'View') ?>">
                            <span class="glyphicon glyphicon-eye-open"></span></a>
                        &nbsp;
                            <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => $file['name']]) ?>"
                            title="<?= Yii::t('app', 'Delete') ?>">
                            <span class="glyphicon glyphicon-remove"></span></a>
                        </th>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                <caption>
                    Standard output file
                    <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => 'out']) ?>" onclick="return confirm('Are you sure to delete all output files?');">
                    Delete all output files</a>
                </caption>
                <tr>
                    <th>File name</th>
                    <th>Size</th>
                    <th>Time modified</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($files as $file): ?>
                    <?php
                    if (!strpos($file['name'], '.out') && !strpos($file['name'], '.ans'))
                        continue;
                    ?>
                    <tr>
                        <th><?= $file['name'] ?></th>
                        <th><?= $file['size'] ?></th>
                        <th><?= date('Y-m-d H:i', $file['time']) ?></th>
                        <th>
                            <a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id,'name' => $file['name']]) ?>"
                            target="_blank"
                            title="<?= Yii::t('app', 'View') ?>">
                            <span class="glyphicon glyphicon-eye-open"></span></a>
                        &nbsp;
                            <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => $file['name']]) ?>"
                            title="<?= Yii::t('app', 'Delete') ?>">
                            <span class="glyphicon glyphicon-remove"></span></a>
                        </th>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>