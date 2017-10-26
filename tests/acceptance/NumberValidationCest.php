<?php

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;

/**
*
*/
class NumberValidationCest
{
    public function testInvalidFormat(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-model');

        $I->fillField('//input[@name="NumberModel[phone]"]', '+000 00000 000000');
        $I->executeJS('$(\'[name="NumberModel[phone]"]\').change()');
        $I->wait(1);
        $I->see('Phone has an invalid format.');
    }

    public function testValidNumber(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('US', PhoneNumberType::MOBILE), PhoneNumberFormat::NATIONAL);


        $I->fillField('//input[@name="NumberModel[phone]"]', $phoneNumber);
        $I->executeJS('$(\'[name="NumberModel[phone]"]\').change()');
        $I->wait(1);
        $I->dontSeeElement('.has-error');
    }
}
