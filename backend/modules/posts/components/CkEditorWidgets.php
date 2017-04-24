<?php

namespace backend\modules\posts\components;

use yii\base\Widget;

class CkEditorWidgets extends Widget {

    public $model;
    public $form;
    public $field = 'description';

    public function init() {
        // add your logic here
        parent::init();
    }

    public function run() {
        return $this->render('ckeditor_form',['model'=>  $this->model,'field'=>  $this->field,'form'=>  $this->form]);
    }

}
?>

