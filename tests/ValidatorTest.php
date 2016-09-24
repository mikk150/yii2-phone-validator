<?php

namespace yiiunit\extensions\phonevalidator;

use mikk150\phonevalidator\PhoneNumberValidator;
use libphonenumber\PhoneNumberFormat;

/**
*
*/
class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'US'
        ]);
        $phoneNumber = $this->phoneNumberUtil->format($this->getPhoneNumber('US'), PhoneNumberFormat::INTERNATIONAL);
        $this->assertTrue($validator->validate($phoneNumber));
    }

    public function testWrongNumber()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'US'
        ]);
        $this->assertFalse($validator->validate('+00 0000 00000'));
    }
}
