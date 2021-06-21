<?php

use yii\helpers\Html;

$this->title = "Home";
?>
<div class="row blog">
    <div class="col-md-8">
        <div class="jumbotron">
            <h1>Hello world!</h1>
            <p>Welcome to <?= Yii::$app->setting->get('ojName') ?> </p>
            <p>Power by <a href="https://facebook.com/vietthientran.301/">Greenhat1998 </a> - based on <a href="http://www.hustoj.org/">HUSTOJ</a></h3>
            <p>The People's Police University of Technology and Logictics</p>
        </div>
    </div>
    <div class="col-md-4">
        <?php if (!empty($contests)): ?>
        <div class="sidebar-module">
            <h2>Cuộc thi sắp diễn ra</h2>
            <ol class="list-unstyled">
                <?php foreach ($contests as $contest): ?>
                <li>
                    <?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']]) ?>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif; ?>
        <?php if (!empty($news)): ?>
            <hr>
            <div class="blog-main">
                <?php foreach ($news as $v): ?>
                    <div class="blog-post">
                        <h2 class="blog-post-title"><?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']]) ?></h2>
                        <p class="blog-post-meta">
                            <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asDate($v['created_at']) ?></p>
                    </div>
                <?php endforeach; ?>
                <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                ]); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($discusses)): ?>
            <hr>
            <div class="sidebar-module">
                <h4>Recently discuss</h4>
                <ol class="list-unstyled">
                    <?php foreach ($discusses as $discuss): ?>
                        <li class="index-discuss-item">
                            <div>
                                <?= Html::a(Html::encode($discuss['title']), ['/discuss/view', 'id' => $discuss['id']]) ?>
                            </div>
                            <small class="text-muted">
                                <span class="glyphicon glyphicon-user"></span>
                                <?= Html::a(Html::encode($discuss['nickname']), ['/user/view', 'id' => $discuss['username']]) ?>
                                &nbsp;•&nbsp;
                                <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($discuss['created_at']) ?>
                                &nbsp;•&nbsp;
                                <?= Html::a(Html::encode($discuss['ptitle']), ['/problem/view', 'id' => $discuss['pid']]) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>
    </div>

</div>
