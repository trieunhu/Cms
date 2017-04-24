<?php

namespace backend\modules\config\controllers;

use backend\modules\config\models\ConfigApp;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ConfigappController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['manageAll'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $model = new ConfigApp();
        $model->baseUrl = ConfigApp::getValueConfig("baseUrl");
        $model->nameApp = ConfigApp::getValueConfig("nameApp");
        $model->baseBackendUrl = ConfigApp::getValueConfig("baseBackendUrl");
        if ($model->load(Yii::$app->request->post())) {
            ConfigApp::setValueConfig("baseUrl", $model->baseUrl);
            ConfigApp::setValueConfig("baseBackendUrl", $model->baseBackendUrl);
            ConfigApp::setValueConfig("nameApp", $model->nameApp);
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
