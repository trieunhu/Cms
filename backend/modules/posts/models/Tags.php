<?php

namespace backend\modules\posts\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 */
class Tags extends \common\models\Tags {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['id','fb_image'], 'integer'],
            [['description','seo_title','slug' ,'seo_description', 'seo_keyword', 'fb_title', 'fb_description'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'seo_title' => "Seo Title",
            'seo_description' => "Seo Description",
            'seo_keyword' => "Keyword",
            'fb_title' => "Facebook Title",
            'fb_description' => 'FaceBook Description',
            'fb_image' => 'Ảnh FaceBook'
        ];
    }

}
