<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dashboard".
 *
 * @property integer $dashboard_id
 * @property string $dashboard_name
 * @property string $pbix_file
 * @property string $description
 * @property string $models
 * @property string $report_id
 * @property string $form_data
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dashboard_name', 'pbix_file', 'description', 'models', 'report_id', 'form_data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dashboard_id' => 'Dashboard ID',
            'dashboard_name' => 'Dashboard Name',
            'pbix_file' => 'Pbix File',
            'description' => 'Description',
            'models' => 'Models',
            'report_id' => 'Report ID',
            'form_data' => 'Form Data',
        ];
    }
}
