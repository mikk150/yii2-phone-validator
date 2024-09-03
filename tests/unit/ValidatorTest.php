<?php

namespace yiiunit\extensions\phonevalidator;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use mikk150\phonevalidator\PhoneNumberValidator;

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

    public function testValidateRightNumberType()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'AR',
            'acceptedNumberTypes' => [PhoneNumberType::MOBILE]
        ]);
        $phoneNumber = $this->phoneNumberUtil->format($this->getPhonenumberForType('AR', PhoneNumberType::MOBILE), PhoneNumberFormat::INTERNATIONAL);
        $this->assertTrue($validator->validate($phoneNumber));
    }

    public function testValidateWrongNumberType()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'AR',
            'acceptedNumberTypes' => [PhoneNumberType::MOBILE]
        ]);
        $phoneNumber = $this->phoneNumberUtil->format($this->getPhonenumberForType('AR', PhoneNumberType::FIXED_LINE), PhoneNumberFormat::INTERNATIONAL);
        $this->assertFalse($validator->validate($phoneNumber));
    }

    public function testWrongNumber()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'US'
        ]);
        $this->assertFalse($validator->validate('+00 0000 00000'));
    }

    public function testInvalidNumber()
    {
        $validator = new PhoneNumberValidator([
            'country' => 'US'
        ]);
        $this->assertFalse($validator->validate('+372 999 999'));
    }
}
