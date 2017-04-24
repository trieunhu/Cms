<?php

namespace common\models;

use Yii;
use common\func\FunctionCommon;

/**
 * This is the model class for table "slug".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $value
 * @property integer $status
 * @property integer $orders
 */
class Slug extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slug';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'table_name', 'value'], 'required'],
            [['table_id', 'status', 'orders'], 'integer'],
            [['table_name'], 'string', 'max' => 20],
            [['value'], 'string', 'max' => 255]
        ];
    }

    public static function deleteModel($id,$name){
        $model = self::findOne(['table_id'=>$id,'table_name'=>$name]);
        if ($model) {
            $model->delete();
        }
    }
    public static function create($id,$name,$title,$isCreateSlug = true){
        if ($isCreateSlug){
            $title = FunctionCommon::toSlug(FunctionCommon::stripVietnamese($title));
        }
        $model = self::findOne(['table_id'=>$id,'table_name'=>$name]);
        if (!$model){
            $model = new self();
            $all = self::find()->where(['value'=>$title])->count();
            if ($all > 0){
                $title .= '-'.strtotime(date('Y-m-d H:i:s'));
            }
        }else{
            $all = self::find()->where(['value'=>$title])->andWhere('id != :id',[':id'=>$model->id])->count();
            if ($all > 0){
                $title .= '-'.strtotime(date('Y-m-d H:i:s'));
            }
        }
        $model->table_id = $id;
        $model->table_name = $name;
        $model->value = $title;
        $model->save();
        return $model;

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'orders' => Yii::t('app', 'Orders'),
        ];
    }
}
