<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Trangthai */

$this->title = $model->ten;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trangthai-update">
    <p>
        <?= Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>


    <?=
    $this->render('_form', [
        'model' => $model,
        'types' => $types,
    ])
    ?>

</div>
