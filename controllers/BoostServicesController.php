<?php

namespace app\controllers;

use app\models\BoostServices;
use app\models\BoostServicesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoostServicesController implements the CRUD actions for BoostServices model.
 */
class BoostServicesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['categories','index'], // Укажите здесь действия, которые хотите ограничить
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index', 'create'],
                        'roles' => ['?'], // Запретить доступ для гостей (неавторизованных пользователей)
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'], // Разрешить доступ для авторизованных пользователей
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all BoostServices models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BoostServicesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the BoostServices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BoostServices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoostServices::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
