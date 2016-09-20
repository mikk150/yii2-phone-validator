<?php

namespace mikk150\phonevalidator;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use Yii;

/**
*
*/
class PhoneNumberValidator extends \yii\validators\Validator
{
    /**
     *
     */
    public $countryAttribute;

    /**
     *
     */
    public $country;

    /**
     *
     */
    public $format = PhoneNumberFormat::E164;

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
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        try {
            $numberProto = $this->getNumberProto($value);
            if (!$this->_phoneNumberUtil->isValidNumber($numberProto)) {
                return [$this->message, []];
            }
        } catch (NumberParseException $e) {
            return [$this->message, []];
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

        return <<<JS
messages.push("test")
JS;
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
