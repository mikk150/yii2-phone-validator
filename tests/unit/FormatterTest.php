<?php

namespace yiiunit\extensions\phonevalidator;

use mikk150\phonevalidator\PhoneNumberValidator;
use libphonenumber\PhoneNumberFormat;
use \yiiunit\extensions\phonevalidator\data\models\NumberModel;

/**
*
*/
class FormatterTest extends TestCase
{
    public function testFormatter()
    {
        $model = new NumberModel([
            'phone' => $this->phoneNumberUtil->format($this->getPhoneNumber('US'), PhoneNumberFormat::NATIONAL),
        ]);
        $model->validate();

        $phoneNumber = $this->phoneNumberUtil->parse($model->phone, 'US');
        $this->assertSame($this->phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164), $model->phone);
    }
}
