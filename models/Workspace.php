<?php

namespace app\models;

use Yii;
use app\models\Collection;

/**
 * This is the model class for table "workspaces".
 *
 * @property integer $w_id
 * @property string $workspace_name
 * @property string $workspace_id
 * @property integer $collection_id
 *
 * @property Datasets[] $datasets
 * @property Reports[] $reports
 * @property Collections $collection
 */
class Workspace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workspaces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workspace_name', 'workspace_id'], 'string'],
            [['collection_id'], 'integer'],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'collection_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'w_id' => 'W ID',
            'workspace_name' => 'Workspace Name',
            'workspace_id' => 'Workspace ID',
            'collection_id' => 'Collection ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatasets()
    {
        return $this->hasMany(Dataset::className(), ['workspace_id' => 'w_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['workspace_id' => 'w_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['collection_id' => 'collection_id']);
    }
}
