<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Province;
$this->registerJsFile(Yii::getAlias("@web") . '/js/select2/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::getAlias("@web") . '/js/select2/css/select2.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Tags */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Cấu hình tổng quan";
?>
<h1><?= Html::encode("Cấu hình ") ?></h1>
<div class="tags-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'baseUrl')->textInput() ?>

    <?= $form->field($model, 'nameApp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'baseBackendUrl')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton("Chỉnh sửa", ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>