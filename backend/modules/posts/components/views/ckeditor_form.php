<?php 
use mihaildev\ckeditor\CKEditor;
?>
<a class="btn btn-default " onclick="showPopupImage('','',2)">Thêm ảnh</a>
<?=
$form->field($model, $field)->widget(CKEditor::className(), [
    'editorOptions' => [
        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
        'inline' => false, //по умолчанию false
    ],
    'options' => [
        'id' => 'editor'
    ]
]);
?>