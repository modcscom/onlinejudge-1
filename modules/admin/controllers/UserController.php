<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\models\User;
use app\models\UserSearch;

class UserController extends Controller
{
    public $layout = 'main';
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
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isPost) {
            $keys = Yii::$app->request->post('keylist');
            $action = Yii::$app->request->get('action');
            foreach ($keys as $key) {
                Yii::$app->db->createCommand()->update('{{%user}}', [
                    'role' => $action
                ], ['id' => $key])->execute();
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $newPassword = Yii::$app->request->post('User')['newPassword'];
            $role = Yii::$app->request->post('User')['role'];
            if (!empty($newPassword)) {
                Yii::$app->db->createCommand()->update('{{%user}}', [
                    'password_hash' => Yii::$app->security->generatePasswordHash($newPassword)
                ], ['id' => $model->id])->execute();
            } else if (!empty($role)) {
                $model->role = intval($role);
                $model->save();
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Saved successfully'));
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        Yii::$app->session->setFlash('error', 'Does not support deleting users ');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
