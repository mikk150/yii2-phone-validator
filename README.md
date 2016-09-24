yii2-phone-validator
====================

This extension validates phone numbers

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