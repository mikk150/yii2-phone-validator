yii2-phone-validator
====================

This extension validates phone numbers

[![Build Status](https://travis-ci.org/mikk150/yii2-phone-validator.svg?branch=master)](https://travis-ci.org/mikk150/yii2-phone-validator)
[![codecov](https://codecov.io/gh/mikk150/yii2-phone-validator/branch/master/graph/badge.svg)](https://codecov.io/gh/mikk150/yii2-phone-validator)

It will also format phone number to ITU-T E.164 or any other format that LibPhoneNumber supports(for full support see libphonenumber\PhoneNumberFormat)

## Usage
```php

// add this in your model
use mikk150\phonevalidator\PhoneNumberValidator;

// use the validator in your model rules
public function rules() {
    return [
        [['phone'], PhoneNumberValidator::className(), 'country' => 'US']
    ];
}
```