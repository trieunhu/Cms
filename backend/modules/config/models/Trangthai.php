<?php

namespace backend\modules\config\models;

use Yii;


class Trangthai extends \common\models\Trangthai
{
    public $type_select;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trangthai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['value_min','value_max'],'integer'],
            [['value_min','value_max'], 'default', 'value'=> 0],
            [['ten'], 'string', 'max' => 255],
            [['type','type_select', 'thuoc_tinh'], 'string', 'max' => 22]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên thuộc tính',
            'value_max' => 'Giá trị lớn nhất',
            'value_min' => 'Giá trị nhỏ nhất',
            'type' => 'Kiểu thuộc tính',
            'thuoc_tinh' => 'Thuộc tính',
            'type_select'=>'Danh sách thuộc tính'
        ];
    }
}
