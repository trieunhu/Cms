<?php
namespace backend\modules\posts\components;

use yii\base\Widget;
use backend\modules\posts\models\Category;

class TagsPostWidgets extends Widget{
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $s = $this->model->getStringTags();
        return $this->render('tags_post',['s'=>$s]);
    }
}
?>

