<?php

namespace yiiacceptance\models;

/**
*
*/
class NoCountryNumberModel extends \yii\base\Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className()]
        ];
    }
}
