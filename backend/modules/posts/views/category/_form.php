<?php

use yii\helpers\Html;
use \backend\modules\posts\models\Category;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Category */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::getAlias("@web") . '/js/macKeys.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <div class="col-md-12 no-padding">
        <div class="box box-primary">
            <div class="box-header">
                <?= Html::activeDropDownList($model, "parent_id", \yii\helpers\ArrayHelper::map(Category::find()->all(), "id", "title"), ["class" => "form-control", "prompt" => "Danh mục cha"]) ?>
                <?=  $model->isNewRecord ? '':$form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                <?= Html::activeDropDownList($model, "type", ['posts'=>"Bài viết",'product'=>'Sản phẩm'], ["class" => "form-control", "prompt" => "Phân loại"]) ?>
                <div class="col-md-4 form-group">
                    <label class="control-label" for="category-title">Ảnh đại diện</label>
                    <?= \backend\modules\posts\components\images\SelectImageWidgets::widget(['model'=>$model]) ?>
                </div>
            </div>
        </div>
    </div>
    <?= backend\modules\posts\components\SeoPostWidgets::widget(['model' => $model, 'form' => $form]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= backend\modules\posts\components\images\UpImageWidgets::widget(); ?>

</div>
