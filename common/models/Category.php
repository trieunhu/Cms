<?php

namespace common\models;

use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $type
 */
class Category extends BaseDB
{
    const TYPE_POST = 'posts';
    const TYPE_BDS = 'batdongsan';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }
    function getPostsChilds() {
        
    }
    function getPosts() {
        return $this->hasMany(Posts::className(), ['id' => 'post_id'])->andOnCondition(['type' => Posts::TYPE_POST])->viaTable("post_relationships", ['table_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'category', 'post_table' => Posts::tableName()]);
                })->orderBy(['id'=>SORT_DESC]);
    }
    function getBds() {
        return $this->hasMany(Batdongsan::className(), ['id' => 'post_id'])->viaTable("post_relationships", ['table_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'category', 'post_table' => Batdongsan::tableName()]);
                });
    }
    function getMenu($type = "Main") {
        return $this->hasOne(Menu::className(),['value'=>'id'])->andOnCondition(['table_name'=>  self::tableName(),'type'=>$type]);
    }
    function getChilds() {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    public function getTitle($the = '') {
        if ($the == '') {
            $link = "<a href='" . $this->getLink() . "'>$this->title</a>";
        } else {
            if ($the == 'none'){
                $link = $this->title;
            }else{
                $link = "<$the><a href='" . $this->getLink() . "'>$this->title</a></$the>";
            }
        }
        return $link;
    }

    public function getLink() {
        $link = Url::to(['/home/category/post', 'slug' => $this->getSlug()]);
        return $link;
    }

    function getHinhAnhLink() {
        
    }
    function getIdChilds(){
        $arrs = [];
        if (!in_array($this->id, $arrs)) {
            $arrs[] = $this->id;
        }
        foreach ($this->childs as $value) {
            $arrs[] = $value->id;
            if (count($value->childs) > 0) {
                $arrs = array_merge($arrs,$value->getIdChilds());
            }
        }
        return $arrs;
    }



    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'fbimages', 'post_table' => Category::tableName()]);
                });
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Category::tableName()]);
                });
    }

    function getParent() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getCategoiesParent() {
        return \yii\helpers\ArrayHelper::map(Category::findAll("parent_id = 0"));
    }
}
