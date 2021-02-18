<?php

use yii\helpers\Html; 
$this->title = $model->title;
$problems = $model->problems;
$rank_result = $model->getRankData(false);
$first_blood = $rank_result['first_blood'];
$result = $rank_result['rank_result'];
$submit_count = $rank_result['submit_count'];

$this->registerAssetBundle('yii\bootstrap\BootstrapPluginAsset');
?>

<div class="wrap">
    <div class="container">
        <div class="alert alert-warning alert-dismissible fade in hidden-print" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <p>Lưu ý</p>
            <ul>
                <li>Bạn có thể sử dụng chức năng Print trên trình duyệt. Xuất file với định dạng xuất PDF. Thông báo  này sẽ không xuất hiện trong cửa sổ Print của trình duyệt.</li>
                <li>Trong lúc diễn ra cuộc thi, nếu bảng xếp hạng đã được thiết lập, ngay cả khi bảng xếp hạng đó được ẩn đi, thì bảng xếp hạng đó vẫn sẽ là bảng xếp hạng theo thời gian thực.</li>
                <li>Sau khi cuộc thi kết thúc, vì hệ thống vẫn tiếp tục cho nộp bài nên bảng xếp hạng này là bảng xếp hạng trong thời gian diễn ra cuộc thi.</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-3 text-left">
                <strong>Start </strong>
                <?= $model->start_time ?>
            </div>
            <div class="col-md-6 text-center">
                <h2 class="contest-title"><?= Html::encode($model->title) ?></h2>
            </div>
            <div class="col-md-3 text-right">
                <strong>End </strong>
                <?= $model->end_time ?>
            </div>
        </div>
        <table class="table table-bordered table-rank">
            <thead>
            <tr>
                <th width="60px">Rank</th>
                <th width="120px">Username</th>
                <th width="120px">Nickname</th>
                <th title="# solved / penalty time" colspan="2">Score</th>
                <?php foreach($problems as $key => $p): ?>
                    <th>
                        <?= chr(65 + $key) ?>
                        <br>
                        <span style="color:#7a7a7a; font-size:12px">
                            <?php
                            if (isset($submit_count[$p['problem_id']]['solved']))
                                echo $submit_count[$p['problem_id']]['solved'];
                            else
                                echo 0;
                            ?>
                            /
                            <?php
                            if (isset($submit_count[$p['problem_id']]['submit']))
                                echo $submit_count[$p['problem_id']]['submit'];
                            else
                                echo 0;
                            ?>
                        </span>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0, $ranking = 1; $i < count($result); $i++): ?>
                <?php $rank = $result[$i]; ?>
                <tr>
                    <th>
                        <?php
                        if ($model->scenario == \app\models\Contest::SCENARIO_OFFLINE && $rank['role'] != \app\models\User::ROLE_PLAYER) {
                            echo '*';
                        } else {
                            echo $ranking;
                            $ranking++;
                        }
                        ?>
                    </th>
                    <th>
                        <?= Html::encode($rank['username']); ?>
                    </th>
                    <th>
                        <?= Html::encode($rank['nickname']); ?>
                    </th>
                    <th class="score-solved">
                        <?= $rank['solved'] ?>
                    </th>
                    <th class="score-time">
                        <?= intval($rank['time'] / 60) ?>
                    </th>
                    <?php
                    foreach($problems as $key => $p) {
                        $css_class = "";
                        $num = 0;
                        $time = "";
                        if (isset($rank['ac_time'][$p['problem_id']]) && $rank['ac_time'][$p['problem_id']] > 0) {
                            if ($first_blood[$p['problem_id']] == $rank['user_id']) {
                                $css_class = 'solved-first';
                            } else {
                                $css_class = 'solved';
                            }
                            $num = $rank['ce_count'][$p['problem_id']] + $rank['wa_count'][$p['problem_id']] + 1;
                            $time = intval($rank['ac_time'][$p['problem_id']]);
                        } else if (isset($rank['pending'][$p['problem_id']]) && $rank['pending'][$p['problem_id']]) {
                            $css_class = 'pending';
                            $num = $rank['ce_count'][$p['problem_id']] + $rank['wa_count'][$p['problem_id']] + $rank['pending'][$p['problem_id']];
                            $time = '';
                        } else if (isset($rank['wa_count'][$p['problem_id']])) {
                            $css_class = 'attempted';
                            $num = $rank['ce_count'][$p['problem_id']] + $rank['wa_count'][$p['problem_id']];
                            $time = '';
                        }
                        if ($num == 0) {
                            $num = '';
                            $span = '';
                        } else if ($num == 1) {
                            $span = 'try';
                        } else {
                            $span = 'tries';
                        }
                        echo "<th class=\"table-problem-cell {$css_class}\">{$time}<br><small>{$num} {$span}</small></th>";
                    }
                    ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->setting->get('ojName') ?> OJ <?= date('Y') ?></p>
    </div>
</footer>
