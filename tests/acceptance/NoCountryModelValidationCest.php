<?php

use Facebook\WebDriver\WebDriverKeys;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;

/**
*
*/
class NoCountryModelValidationCest
{
    public function testInvalidFormat(TestGuy $I)
    {
        $I->amOnPage('/?r=test/no-country-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('AR', PhoneNumberType::MOBILE), PhoneNumberFormat::NATIONAL);

        $I->fillField('//input[@name="NoCountryNumberModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="NoCountryNumberModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->seeElement('.has-error');
    }

    public function testValidFormat(TestGuy $I)
    {
        $I->amOnPage('/?r=test/no-country-model');

        $phoneNumber = $I->formatPhoneNumber($I->getPhonenumberForType('AR', PhoneNumberType::MOBILE), PhoneNumberFormat::INTERNATIONAL);

        $I->fillField('//input[@name="NoCountryNumberModel[phone]"]', $phoneNumber);
        $I->pressKey('//input[@name="NoCountryNumberModel[phone]"]', WebDriverKeys::TAB);
        $I->wait(1);

        $I->dontSeeElement('.has-error');
    }
}
