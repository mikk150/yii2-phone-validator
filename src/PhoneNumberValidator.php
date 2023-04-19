<?php

namespace mikk150\phonevalidator;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
*
*/
class PhoneNumberValidator extends \yii\validators\Validator
{
    /**
     * Attribute name or path that points to default region
     */
    public $countryAttribute;

    /**
     * Validator default region
     */
    public $country;

    /**
     * The PhoneNumberFormat the phone number should be formatted into or false if no fornatting is required
     */
    public $format = PhoneNumberFormat::E164;

    /**
     * Phone number types that are valid
     */
    public $acceptedNumberTypes;

    /**
     * error message when libphonenumber encoutered an error parsing phone number
     */
    public $invalidFormatMessage;

    /**
     * error message when phone number is invalid type
     */
    public $invalidTypeMessage;

    /**
     * @var PhoneNumberUtil
     */
    private $_phoneNumberUtil;

    /**
     *
     */
    private $_model;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_phoneNumberUtil = PhoneNumberUtil::getInstance();

        if (!$this->countryAttribute && !$this->country) {
            throw new InvalidConfigException('The "countryAttribute" or "country" property must be set.');
        }
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is not valid phone number.');
        }
        if ($this->invalidFormatMessage === null) {
            $this->invalidFormatMessage = Yii::t('yii', '{attribute} has an invalid format.');
        }
        if ($this->invalidTypeMessage === null) {
            $this->invalidTypeMessage = Yii::t('yii', '{attribute} is invalid type.');
        }

    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if ($this->isEmpty($value) && $this->skipOnEmpty) {
            return null;
        }

        if (!is_string($value) && !is_numeric($value)) {
            return [$this->message, []];
        }

        try {
            $numberProto = $this->getNumberProto($value);
            if (!$this->_phoneNumberUtil->isValidNumber($numberProto)) {
                return [$this->message, []];
            }
            if ($this->acceptedNumberTypes && !in_array($this->_phoneNumberUtil->getNumberType($numberProto), $this->acceptedNumberTypes)) {
                return [$this->invalidTypeMessage, []];
            }
        } catch (NumberParseException $e) {
            return [$this->invalidFormatMessage, []];
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttributes($model, $attributes = null)
    {
        $this->_model = $model;

        parent::validateAttributes($model, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if ($this->format === false) {
            parent::validateAttribute($model, $attribute);
        } else {
            $result = $this->validateValue($model->$attribute);
            if (!empty($result)) {
                $this->addError($model, $attribute, $result[0], $result[1]);
            } else {
                $numberProto = $this->getNumberProto($model->$attribute);
                $model->$attribute = $this->_phoneNumberUtil->format($numberProto, $this->format);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        LibPhoneNumberAsset::register($view);
        $country = $this->country;
        if ($this->countryAttribute && $this->_model) {
            $country = ArrayHelper::getValue($this->_model, $this->countryAttribute);
        }

        $types = false;
        if ($this->acceptedNumberTypes) {
            $types = array_map([$this, 'numberTypeMapper'], $this->acceptedNumberTypes);
        }
        $types = Json::encode($types);

        $message = Yii::$app->getI18n()->format($this->message, [
            'attribute' => $model->getAttributeLabel($attribute),
        ], Yii::$app->language);

        $invalidFormatMessage = Yii::$app->getI18n()->format($this->invalidFormatMessage, [
            'attribute' => $model->getAttributeLabel($attribute),
        ], Yii::$app->language);

        $invalidTypeMessage = Yii::$app->getI18n()->format($this->invalidTypeMessage, [
            'attribute' => $model->getAttributeLabel($attribute),
        ], Yii::$app->language);

        return <<<JAVASCRIPT
        if (value) {
            var phoneNumberUtil = window.libphonenumber.PhoneNumberUtil.getInstance();
            var types = {$types};
            try {
                var numberProto = phoneNumberUtil.parse(value, "{$country}");
                if (!phoneNumberUtil.isValidNumber(numberProto)){
                    messages.push("{$message}");
                }
                if (types && types.indexOf(phoneNumberUtil.getNumberType(numberProto)) === -1) {
                    messages.push("{$invalidTypeMessage}");
                }
            } catch (err) {
                messages.push("{$invalidFormatMessage}");
            }
        }
JAVASCRIPT;
    }

    private function numberTypeMapper($phpNumberType)
    {
        $numberMap = [
            PhoneNumberType::FIXED_LINE => 0,           // FIXED_LINE
            PhoneNumberType::MOBILE => 1,               // MOBILE
            PhoneNumberType::FIXED_LINE_OR_MOBILE => 2, // FIXED_LINE_OR_MOBILE
            PhoneNumberType::TOLL_FREE => 3,            // TOLL_FREE
            PhoneNumberType::PREMIUM_RATE => 4,         // PREMIUM_RATE
            PhoneNumberType::SHARED_COST => 5,          // SHARED_COST
            PhoneNumberType::VOIP => 6,                 // VOIP
            PhoneNumberType::PERSONAL_NUMBER => 7,      // PERSONAL_NUMBER
            PhoneNumberType::PAGER => 8,                // PAGER
            PhoneNumberType::UAN => 9,                  // UAN
            PhoneNumberType::VOICEMAIL => 10,           // VOICEMAIL
            PhoneNumberType::UNKNOWN => -1,             // UNKNOWN
        ];
        if (isset($numberMap[$phpNumberType])) {
            return $numberMap[$phpNumberType];
        }
    }

    /**
     * Gets the number prototype.
     *
     * @param      string  $value  phonenumber to get
     *
     * @return     \libphonenumber\PhoneNumber
     */
    private function getNumberProto($value)
    {
        $country = $this->country;
        if ($this->countryAttribute && $this->_model) {
            $country = ArrayHelper::getValue($this->_model, $this->countryAttribute);
        }
        
        return $this->_phoneNumberUtil->parse($value, $country);
    }
}
