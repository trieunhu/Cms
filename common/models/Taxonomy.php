<?php

namespace common\models;
use common\func\FunctionCommon;

use Yii;

/**
 * This is the model class for table "taxonomy".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $type
 * @property string $value
 */
class Taxonomy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taxonomy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'table_name', 'type', 'value'], 'required'],
            [['table_id'], 'integer'],
            [['type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_id' => 'Table ID',
            'table_name' => 'Table Name',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }
    public static function setTaxonomy($table_id,$table_name,$type,$value) {
        $model = Taxonomy::findOne(['table_id'=>$table_id,'table_name'=>$table_name,'type'=>$type]);
        if (!$model) {
            $model = new Taxonomy;
            $model->table_id = $table_id;
            $model->table_name = $table_name;
            $model->type = $type;
        }
        $model->value = $value;
        $model->save();
        return $model;
    }
}
