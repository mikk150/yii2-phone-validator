<?php

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Facebook\WebDriver\WebDriverKeys;

/**
*
*/
class NumberTypeValidationCest
{
    public function testValidPhoneType(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-type-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('AR', PhoneNumberType::MOBILE), PhoneNumberFormat::E164);

        $I->fillField('//input[@name="NumberTypeModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="NumberTypeModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->dontSeeElement('.has-error');
    }

    public function testInvalidPhoneType(TestGuy $I)
    {
        $I->amOnPage('/?r=test/number-type-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('AR', PhoneNumberType::FIXED_LINE), PhoneNumberFormat::E164);

        $I->fillField('//input[@name="NumberTypeModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="NumberTypeModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->seeElement('.has-error');
    }
}
