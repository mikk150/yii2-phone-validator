<?php

namespace yiiunit\extensions\phonevalidator;

use \yiiunit\extensions\phonevalidator\data\models\NoFormatterModel;
use \yiiunit\extensions\phonevalidator\data\models\NumberModel;
use libphonenumber\PhoneNumberFormat;
use yiiunit\extensions\phonevalidator\data\models\NoCountryModel;

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

    public function testFormatterDisabled()
    {
        $number = $this->phoneNumberUtil->format($this->getPhoneNumber('US'), PhoneNumberFormat::NATIONAL);

        $model = new NoFormatterModel([
            'phone' => $number,
        ]);
        $model->validate();

        $this->assertSame($number, $model->phone);
    }
    
    public function testTryToFormatNationalNumberWithNoCountry()
    {
        $number = $this->phoneNumberUtil->format($this->getPhoneNumber('US'), PhoneNumberFormat::NATIONAL);
        $model = new NoCountryModel([
            'phone' => $number,
        ]);

        $this->assertFalse($model->validate());
    }

    public function testTryToFormatNumberWithNoCountry()
    {
        $numberProto = $this->getPhoneNumber('US');
        $number = $this->phoneNumberUtil->format($numberProto, PhoneNumberFormat::INTERNATIONAL);
        $model = new NoCountryModel([
            'phone' => $number,
        ]);

        $model->validate();
        $number = $this->phoneNumberUtil->format($numberProto, PhoneNumberFormat::E164);
        $this->assertSame($number, $model->phone);
    }
}
