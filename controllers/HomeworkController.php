<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\ContestProblem;
use app\models\ContestUser;
use app\models\Problem;
use app\models\Solution;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
use app\models\Homework;
use app\models\ContestAnnouncement;
use yii\web\NotFoundHttpException;


class HomeworkController extends BaseController
{
    public function init()
    {
        Yii::$app->language = 'vi-VN';
        parent::init(); 
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDeleteproblem($id, $pid)
    {
        $model = $this->findModel($id);
        $model->deleteProblem($pid);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Đã xoá'));
        return $this->redirect(['/homework/update', 'id' => $id]);
    }

    public function actionAddproblem($id)
    {
        $model = $this->findModel($id);

        if (($post = Yii::$app->request->post())) {
            $pid = intval($post['problem_id']);
            $problemStatus = (new Query())->select('status')
                ->from('{{%problem}}')
                ->where('id=:id', [':id' => $pid])
                ->scalar();
            if ($problemStatus == null || ($problemStatus == Problem::STATUS_HIDDEN && Yii::$app->user->identity->role != User::ROLE_ADMIN)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Bài tập không tồn tại.'));
            } else if ($problemStatus == Problem::STATUS_PRIVATE && (Yii::$app->user->identity->role == User::ROLE_USER ||
                                                                     Yii::$app->user->identity->role == User::ROLE_PLAYER)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Chủ đề riêng tư, chỉ áp dụng cho người dùng VIP'));
            } else {
                $problemInContest = (new Query())->select('problem_id')
                    ->from('{{%contest_problem}}')
                    ->where(['problem_id' => $pid, 'contest_id' => $model->id])
                    ->exists();
                if ($problemInContest) {
                    Yii::$app->session->setFlash('info', Yii::t('app', 'Bài tập có trong cuộc thi.'));
                    return $this->redirect(['/homework/update', 'id' => $id]);
                }
                $count = (new Query())->select('contest_id')
                    ->from('{{%contest_problem}}')
                    ->where(['contest_id' => $model->id])
                    ->count();

                Yii::$app->db->createCommand()->insert('{{%contest_problem}}', [
                    'problem_id' => $pid,
                    'contest_id' => $model->id,
                    'num' => $count
                ])->execute();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Nộp bài thành công'));
            }
            return $this->redirect(['/homework/update', 'id' => $id]);
        }
    }

    public function actionUpdateproblem($id)
    {
        $model = $this->findModel($id);

        if (($post = Yii::$app->request->post())) {
            $pid = intval($post['problem_id']);
            $new_pid = intval($post['new_problem_id']);

            $oldProblemStatus = (new Query())->select('status')
                ->from('{{%problem}}')
                ->where('id=:id', [':id' => $pid])
                ->scalar();
            $newProblemStatus = (new Query())->select('status')
                ->from('{{%problem}}')
                ->where('id=:id', [':id' => $new_pid])
                ->scalar();

            if (!empty($oldProblemStatus) && !empty($newProblemStatus)) {
                $problemInContest = (new Query())->select('problem_id')
                    ->from('{{%contest_problem}}')
                    ->where(['problem_id' => $new_pid, 'contest_id' => $model->id])
                    ->exists();
                if ($problemInContest) {
                    Yii::$app->session->setFlash('info', Yii::t('app', 'Bài tập có trong cuộc thi.'));
                    return $this->refresh();
                }
                if ($newProblemStatus == Problem::STATUS_VISIBLE || Yii::$app->user->identity->role == User::ROLE_ADMIN
                    || ($newProblemStatus == Problem::STATUS_PRIVATE && Yii::$app->user->identity->role == User::ROLE_VIP)) {
                    Yii::$app->db->createCommand()->update('{{%contest_problem}}', [
                        'problem_id' => $new_pid,
                    ], ['problem_id' => $pid, 'contest_id' => $model->id])->execute();
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Nộp bài thành công'));
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Bài tập không tồn tại.'));
            }
            return $this->redirect(['/homework/update', 'id' => $id]);
        }
    }

    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        $announcements = new ActiveDataProvider([
            'query' => ContestAnnouncement::find()->where(['contest_id' => $model->id])
        ]);

        $newAnnouncement = new ContestAnnouncement();
        if ($newAnnouncement->load(Yii::$app->request->post())) {
            $newAnnouncement->contest_id = $model->id;
            $newAnnouncement->save();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Đã lưu'));
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'announcements' => $announcements,
            'newAnnouncement' => $newAnnouncement
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        ContestUser::deleteAll(['contest_id' => $model->id]);
        ContestProblem::deleteAll(['contest_id' => $model->id]);
        Solution::deleteAll(['contest_id' => $model->id]);
        $groupId = $model->group_id;
        $model->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Đã xoá'));
        return $this->redirect(['/group/view', 'id' => $groupId]);
    }

    protected function findModel($id)
    {
        if (($model = Homework::findOne($id)) !== null) {
            if ($model->hasPermission()) {
                return $model;
            } else {
                throw new ForbiddenHttpException('Không được phép thực hiện thao tác này.');
            }
        }
        throw new NotFoundHttpException('Trang được yêu cầu không tồn tại.');
    }
}