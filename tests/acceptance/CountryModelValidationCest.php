<?php

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;

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
        $I->executeJS('$(\'[name="CountryNumberModel[phone]"]\').change()');
        $I->wait(1);
        $I->dontSeeElement('.has-error');
    }
}
