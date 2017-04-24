<?php

namespace backend\modules\posts\models;

use Yii;
use common\func\FunctionCommon;
/**
 * This is the model class for table "taxonomy".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $type
 * @property string $value
 */
class Taxonomy extends \common\models\Taxonomy
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
            [['table_name'], 'string', 'max' => 255],
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
    
}
