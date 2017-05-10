<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $m_id
 * @property string $model_name
 * @property string $attributes
 */
class DataModel extends \yii\db\ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_name'], 'required'],
            [['model_name', 'attributes'], 'string'],
            [['model_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_id' => 'M ID',
            'model_name' => 'Model Name',
            'attributes' => 'Attributes',
        ];
    }
	
	public function afterSave($insert, $changeAttributes) {
		parent::afterSave($insert, $changeAttributes);
		$attributes = unserialize($this->attributes);	
//print_r($attributes);	die;	
		$columns = ['id' => 'pk'];
		foreach($attributes as $attribute){
			$columns[$attribute['field_name']]=$attribute['field_type'];
		}
		$migration = new \yii\db\Migration();
		$migration->createTable($this->model_name, $columns);

		return true;
	}
}
