<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $permissions
 * @var yii\data\ActiveDataProvider $roles
 * @var bool $isRules
 */
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
$this->title = "Phân quyền người dùng";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
     <p>
        <?= Html::a('Tạo quyền mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $permissions,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


