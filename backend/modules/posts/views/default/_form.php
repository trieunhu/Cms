<?php

use yii\widgets\ActiveForm;

$this->registerCssFile(Yii::getAlias("@web") . '/css/jquery.tag-editor.css');
$this->registerJsFile(Yii::getAlias("@web") . '/js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/jquery.caret.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/jquery.tag-editor.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/macKeys.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <?= $model->isNewRecord ? '' : $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= \backend\modules\posts\components\CkEditorWidgets::widget(['model'=>$model,'form'=>$form]); ?>
                </div>
            </div>
            <?= backend\modules\posts\components\SeoPostWidgets::widget(['model' => $model, 'form' => $form]); ?>
        </div>
        <?= backend\modules\posts\components\CreatePostWidgets::widget(['model' => $model, 'form' => $form]); ?>
        <?= backend\modules\posts\components\CategoryPostWidgets::widget(['model' => $model]); ?>
        <?= backend\modules\posts\components\TagsPostWidgets::widget(['model' => $model]); ?>
        <?= backend\modules\posts\components\images\FileUpImageWidgets::widget(['model' => $model,'title'=>'Ảnh đại diện']); ?>
    </div>

    <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
    <?= backend\modules\posts\components\images\UpImageWidgets::widget(); ?>
</div>