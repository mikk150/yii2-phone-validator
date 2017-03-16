<?php

namespace yiiacceptance\models;

use libphonenumber\PhoneNumberType;

/**
*
*/

class NumberTypeModel extends \yii\base\Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className(), 'country' => 'US', 'acceptedNumberTypes' => [PhoneNumberType::MOBILE]]
        ];
    }
}
