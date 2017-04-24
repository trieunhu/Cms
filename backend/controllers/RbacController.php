<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use \yii\rbac\Item;

/**
 * Site controller
 */
class RbacController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionCreate() {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $managePost = $auth->createPermission('managePost');
        $managePost->description = 'Tạo và chỉnh sửa bài viết';
        $auth->add($managePost);

        // add "updatePost" permission
        $manageUser = $auth->createPermission('manageUser');
        $manageUser->description = 'Chỉnh sửa và tạo người dùng';
        $auth->add($manageUser);

        $manage = $auth->createPermission('manageAll');
        $manage->description = 'Quản lý tất cả';
        $auth->add($manage);
        $default = $auth->createRole('Contributor');
        $auth->add($default);
        // người dùng viết bài
        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('Author');
        $auth->add($author);
        $auth->addChild($author, $managePost);
//
//        // người dùng quản lý
        $editer = $auth->createRole('Editer');
        $auth->add($editer);
        $auth->addChild($editer, $managePost);
        $auth->addChild($editer, $manageUser);
        $auth->addChild($editer, $author);
//        // add "admin" role and give this role the "updatePost" permission
//        // as well as the permissions of the "author" role
//        // người dùng quản trị
        $admin = $auth->createRole('Admin');
        $auth->add($admin);
        $auth->addChild($admin, $managePost);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $editer);
        $auth->addChild($admin, $manage);
        $auth->addChild($admin, $manageUser);
        
        $auth->assign($admin, Yii::$app->user->id);
    }

    public function actionIndex() {
        $rules = \Yii::$app->getAuthManager()->getRules();
        $permissions = new ArrayDataProvider(
                [
            'id' => 'permissions',
            'allModels' => \Yii::$app->getAuthManager()->getPermissions(),
            'sort' => [
                'attributes' => ['name', 'description', 'ruleName', 'createdAt', 'updatedAt'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
                ]
        );
        $roles = new ArrayDataProvider(
                [
            'id' => 'roles',
            'allModels' => \Yii::$app->getAuthManager()->getRoles(),
            'sort' => [
                'attributes' => ['name', 'description', 'ruleName', 'createdAt', 'updatedAt'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
                ]
        );
        return $this->render(
                        'index', [
                    'permissions' => $permissions,
                    'roles' => $roles,
                    'isRules' => !empty($rules),
                        ]
        );
    }

    public function actionDelete($id) {
        \Yii::$app->getAuthManager()->remove(new Item(['name' => $id]));
        return $this->redirect(['index']);
    }

}
