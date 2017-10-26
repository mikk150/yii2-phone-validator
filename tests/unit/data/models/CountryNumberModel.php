<?php

namespace yiiunit\extensions\phonevalidator\data\models;

/**
*
*/
class CountryNumberModel extends \yii\base\Model
{
    public $phone;
    public $country;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className(), 'countryAttribute' => 'country']
        ];
    }
}
