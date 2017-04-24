<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slug
 */
class Tags extends BaseDB {


    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tags';
    }

    public static function setTagsValue($value) {
        $tag = Tags::findOne(['title' => $value]);
        if (!$tag) {
            $tag = new Tags;
            $tag->title = $value;
            $tag->save();
            Slug::create($tag->id,$tag->tableName(),$tag->title);
        }
        return $tag;
    }
    function getPosts() {
        return $this->hasMany(Posts::className(), ['id' => 'post_id'])->andOnCondition(['type' => 'post'])->viaTable("post_relationships", ['table_id' => 'id'], function ($query) {
            $query->where(['table_name' => self::tableName(), 'post_table' => Posts::tableName()]);
        })->orderBy(['id'=>SORT_DESC]);
    }

    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'fbimages', 'post_table' => Tags::tableName()]);
                });
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Tags::tableName()]);
                });
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
        $link = Url::to(['/home/category/post', 'slug' => $this->slug]);
        return $link;
    }


}
