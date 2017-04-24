<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Trangthai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trangthai-form">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['role' => 'form'],

        'fieldConfig' => [
            'options' => [
                'tag' => 'div'
            ],

        ],
    ]);
    $styleFixValue = 'display: none;';
    $radioCheck = 0;
    if (!$model->isNewRecord) {
        if ($model->value_min != 0 || $model->value_max != 0){
            $radioCheck = 1;
            $styleFixValue = '';
        }
    }
    ?>


    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
            <label class="radio-inline"><input type="radio" checked="checked" id="radio_select" name="optradio">Thuộc
                tính có sãn</label>
            <label class="radio-inline"><input type="radio" name="optradio" id="radio_input">Thuộc tính mới</label>
            <?= $form->field($model, 'type', ['options' => ['id' => 'input_text', 'style' => 'display:none;']])->textInput(['maxlength' => true]) ?>
            <?=
            $form->field($model, 'type_select', ['options' => ['id' => 'input_select']])
                ->dropDownList($types, ["class" => "form-control", "prompt" => "Kiểu", 'id' => 'select_type']
                )
            ?>
            <?= $form->field($model, 'thuoc_tinh')->textInput(['maxlength' => true]) ?>
            <label class="radio-inline"><input type="radio" <?= $radioCheck == 0 ? 'checked' : ''; ?> value="0" name="value_fix" id="radio_no_fix">Thuộc
                tính cố định</label>
            <label class="radio-inline"><input type="radio" <?= $radioCheck == 1 ? 'checked' : ''; ?> value="1" name="value_fix" id="radio_input_fixed">Thuộc tính giá trị</label>
            <div class="value-input row" style="margin: 10px -15px; <?= $styleFixValue ?> ">
                <?= $form->field($model, 'value_min', ['template' => '
            <div class="input-group">
                {input}
            </div>',
                    'options' => [
                        'class' => 'col-md-2'
                    ]
                    , 'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('value_min'),
                        'class' => 'form-control',
                    ]])->textInput() ?>
                <?= $form->field($model, 'value_max', ['template' => '
            <div class="input-group">
                {input}
            </div>',
                    'options' => [
                        'class' => 'col-md-2'
                    ]
                    , 'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('value_max'),
                        'class' => 'form-control',
                    ]])->textInput() ?>
            </div>


            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    var valueselect = "<?= $model->type ?>";
    $('#radio_input').change(function () {
        if ($(this).prop("checked")) {
            $('#input_text').show();
            $('#input_select').hide();
            $('#select_type').val("")
        }
    });
    $('#radio_select').change(function () {
        if ($(this).prop("checked")) {
            $('#input_text').hide();
            $('#input_select').show();
            $('#select_type').val(valueselect);
        }
    });
    $('#radio_input_fixed').change(function () {
        if ($(this).prop("checked")) {
            $('.value-input').show();
        }
    });
    $('#radio_no_fix').change(function () {
        if ($(this).prop("checked")) {
            $('.value-input').hide();
        }
    });
</script>
<style>
    .radio-inline {
        margin-bottom: 10px
    }
</style>