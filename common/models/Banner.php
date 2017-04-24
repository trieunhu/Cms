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
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'value', 'position', 'new_tab', 'date_begin', 'date_end', 'type', 'banner_order'], 'required'],
            [['url', 'value'], 'string'],
            [['date_begin', 'date_end'], 'safe'],
            [['banner_order'], 'integer'],
            [['name', 'position', 'type'], 'string', 'max' => 255],
            [['new_tab'], 'string', 'max' => 11]
        ];
    }
    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Banner::tableName()]);
                });
    }
    public function getHinhAnh() {
        $linkImage = '';
        $atl = '';
        if ($this->image) {
            $linkImage = $this->image->getUrl();
            $atl = $this->image->alt;
        }
        $image = "<img src='$linkImage' alt='$atl' class='img-responsive' />";
        return $image;
    }
    public function getValue() {
        $taget = '';
        $url = $this->url;
        if ($this->new_tab == 'open_tab') {
            $taget = 'target="_blank"';
        }
        $a = "<a href='$url' $taget>".$this->getHinhAnh()."</a>";
        return $a;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'value' => 'Value',
            'position' => 'Position',
            'new_tab' => 'New Tab',
            'date_begin' => 'Date Begin',
            'date_end' => 'Date End',
            'type' => 'Type',
            'banner_order' => 'Banner Order',
        ];
    }
}
