<?php

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Facebook\WebDriver\WebDriverKeys;

/**
*
*/
class CountryModelValidationCest
{
    public function testInvalidFormat(TestGuy $I)
    {
        $I->amOnPage('/?r=test/country-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('AR', PhoneNumberType::MOBILE), PhoneNumberFormat::NATIONAL);

        $I->fillField('//input[@name="CountryNumberModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="CountryNumberModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->dontSeeElement('.has-error');
    }
}
