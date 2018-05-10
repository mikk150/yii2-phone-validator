<?php

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Facebook\WebDriver\WebDriverKeys;

/**
*
*/
class NumberValidationCest
{
    public function testInvalidFormat(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-model');

        $I->fillField('//input[@name="NumberModel[phone]"]', '+000 00000 000000');
        $I->pressKey('//input[@name="NumberModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->see('Phone has an invalid format.');
    }

    public function testValidNumber(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('US', PhoneNumberType::MOBILE), PhoneNumberFormat::NATIONAL);

        $I->fillField('//input[@name="NumberModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="NumberModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);
    
        $I->dontSeeElement('.has-error');
    }
}
