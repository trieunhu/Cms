<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $value
 * @property string $table_name
 * @property string $type
 * @property integer $menu_order
 * @property integer $new_tab
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'name', 'value', 'table_name', 'type', 'menu_order', 'new_tab'], 'required'],
            [['parent_id', 'menu_order', 'new_tab'], 'integer'],
            [['name', 'value', 'table_name', 'type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'value' => 'Value',
            'table_name' => 'Table Name',
            'type' => 'Type',
            'menu_order' => 'Menu Order',
            'new_tab' => 'New Tab',
        ];
    }
    function getChilds() {
        return $this->hasMany(Menu::className(), ['parent_id' => 'id']);
    }

    function getParent() {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }
    function getCategory() {
        if ($this->table_name == Category::tableName()) {
            return $this->hasOne(Category::className(), ['id' => 'value']);
        }  else {
            return NULL;
        }
    }
    public function getLink() {
        $link = '';
        if ($this->table_name == 'linktinh') {
            $link = $this->value;
        } else {
            if ($this->table_name == "category") {
                $category = Category::findOne($this->value);
                if ($category) {
                    $link = $category->getLink();
                }
            }
        }
        return $link;
    }
}
