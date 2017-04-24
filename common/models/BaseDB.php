<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $value
 * @property string $position
 * @property string $new_tab
 * @property string $date_begin
 * @property string $date_end
 * @property string $type
 * @property integer $banner_order
 */
class BaseDB extends \yii\db\ActiveRecord
{
    public $seo_title;
    public $seo_description;
    public $seo_keyword;
    public $fb_title;
    public $fb_description;
    public $fb_image;
    public $slug;
    function getSeoPost($seo = FALSE) {
        $taxonomy = Taxonomy::findOne(['table_name' => $this->tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
        if ($taxonomy) {
            $json[] = json_decode($taxonomy->value);
            $this->seo_title = $json[0]->seo_title;
            $this->seo_description = $json[0]->seo_description;
            $this->seo_keyword = $json[0]->seo_keyword;
            $this->fb_description = $json[0]->fb_description;
            $this->fb_title = $json[0]->fb_title;
            if ($this->fbimage) {
                $this->fb_image = $this->fbimage->id;
            }
            if ($seo) {
                \Yii::$app->view->title = $this->title;
                \Yii::$app->view->registerMetaTag([
                    'property' => 'description',
                    'content' => $this->seo_description
                ]);
            }
        }
        if ($seo) {
            \Yii::$app->view->title = $this->getTitle('none');
            \Yii::$app->view->registerMetaTag([
                'property' => 'description',
                'content' => $this->seo_description
            ]);
        }
    }
    function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
            $query->where(['table_name' => 'category', 'post_table' => $this->tableName()]);
        });
    }
    function getCategoriesMenu() {
        $list = $this->categories;
        foreach ($list as $value) {
            if ($value->menu) {
                return $value;
            }
        }
        return NULL;
    }
    function getStringTags() {
        $s = "";
        $i = 0;
        if ($this->tags != NULL) {
            foreach ($this->tags as $value) {
                if ($i == count($this->tags) - 1) {
                    $s .= $value->title;
                } else {
                    $s .= $value->title . ',';
                }
                $i++;
            }
        }
        return $s;
    }

    function getStringCategories() {
        $s = "";
        $i = 0;
        if ($this->categories != NULL) {
            foreach ($this->categories as $value) {
                if ($i == count($this->categories) - 1) {
                    $s .= $value->title;
                } else {
                    $s .= $value->title . ',';
                }
                $i++;
            }
        }
        return $s;
    }

    function getTags() {
        return $this->hasMany(Tags::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
            $query->where(['table_name' => 'tags', 'post_table' => $this->tableName()]);
        });
    }
    public function getSlug(){
        $model = Slug::findOne(['table_id'=>$this->id,'table_name'=>$this->tableName()]);
        if ($model){
            return $model->value;
        }
        return '';
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
            $query->where(['table_name' => 'images', 'post_table' => $this->tableName()]);
        });
    }

    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
            $query->where(['table_name' => 'fbimages', 'post_table' => $this->tableName()]);
        });
    }
}
