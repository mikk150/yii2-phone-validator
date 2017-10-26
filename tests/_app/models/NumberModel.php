<?php

namespace yiiacceptance\models;

/**
*
*/
class NumberModel extends \yii\base\Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', \mikk150\phonevalidator\PhoneNumberValidator::className(), 'country' => 'US']
        ];
    }
}
