<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_lab_post".
 *
 * @property integer $lpid
 * @property string $lp_title
 * @property string $lp_content
 * @property string $lp_datetime
 * @property integer $lp_status
 * @property integer $lp_class
 * @property integer $lp_class2
 */
class TbLabPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_lab_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lp_content'], 'string'],
            [['lp_datetime'], 'safe'],
            [['lp_status', 'lp_class', 'lp_class2'], 'integer'],
            [['lp_title'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lpid' => 'Lpid',
            'lp_title' => 'Lp Title',
            'lp_content' => 'Lp Content',
            'lp_datetime' => 'Lp Datetime',
            'lp_status' => 'Lp Status',
            'lp_class' => 'Lp Class',
            'lp_class2' => 'Lp Class2',
        ];
    }
}
