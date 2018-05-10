<?php

namespace yiiunit\extensions\phonevalidator\data\models;

/**
 *
 */
class NoFormatterModel extends \yii\base\Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className(), 'country' => 'US', 'format' => false]
        ];
    }
}
