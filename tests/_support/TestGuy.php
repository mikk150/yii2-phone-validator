<?php

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumber;
use Codeception\Scenario;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class TestGuy extends \Codeception\Actor
{
    use _generated\TestGuyActions;

    /**
     * @property \libphonenumber\PhoneNumberUtil
     */
    protected $phoneNumberUtil;

    public function __construct(Scenario $scenario)
    {
        $this->scenario = $scenario;
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public function getPhoneNumber($regionCode)
    {
        return $this->phoneNumberUtil->getExampleNumber($regionCode);
    }

    public function getPhonenumberForType($regionCode, $typeCode)
    {
        return $this->phoneNumberUtil->getExampleNumberForType($regionCode, $typeCode);
    }

    public function formatPhoneNumber(PhoneNumber $number, $type)
    {
        return $this->phoneNumberUtil->format($number, $type);
    }



   /**
    * Define custom actions here
    */
}
