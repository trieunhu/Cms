<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('Admin');
        $author = $auth->createRole('Author');
        $Contributor = $auth->createRole('Contributor');
        $Editer = $auth->createRole('Editer');
        // add "createPost" permission
        $manageAll = $auth->createPermission('manageAll');
        $manageAll->description = 'Quản lý tất cả';
        $auth->add($manageAll);

        // add "updatePost" permission
        $managePost = $auth->createPermission('managePost');
        $managePost->description = 'Tạo và chỉnh sửa bài viết';
        $auth->add($managePost);
        
        $manageUser = $auth->createPermission('manageUser');
        $manageUser->description = 'Chỉnh sửa và tạo người dùng';
        $auth->add($manageUser);
        // author
        $auth->add($author);
        $auth->addChild($author, $managePost);
        //Editer
        $auth->add($Editer);
        $auth->addChild($Editer, $author);
        $auth->addChild($Editer, $managePost);
        $auth->addChild($Editer, $manageUser);
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $Editer);
        $auth->addChild($admin, $managePost);
        $auth->addChild($admin, $manageUser);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 7);
    }
}