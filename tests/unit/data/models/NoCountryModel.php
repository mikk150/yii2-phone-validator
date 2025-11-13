<?php

namespace yiiunit\extensions\phonevalidator\data\models;

/**
 *
 */
class NoCountryModel extends \yii\base\Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className()]
        ];
    }
}
