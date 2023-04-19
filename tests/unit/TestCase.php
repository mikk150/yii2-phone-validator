<?php

namespace yiiunit\extensions\phonevalidator;

use Codeception\Test\Unit;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\helpers\ArrayHelper;

/**
*
*/
abstract class TestCase extends Unit
{
    /**
     * @property \libphonenumber\PhoneNumberUtil
     */
    protected $phoneNumberUtil;

    public function getPhoneNumber($regionCode)
    {
        return $this->phoneNumberUtil->getExampleNumber($regionCode);
    }

    public function getPhonenumberForType($regionCode, $typeCode)
    {
        return $this->phoneNumberUtil->getExampleNumberForType($regionCode, $typeCode);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->mockApplication();
    }

    protected function tearDown(): void
    {
        $this->destroyApplication();
    }


    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'runtimePath' => dirname(__DIR__) . '/runtime',
        ], $config));
    }

    protected function getVendorPath()
    {
        $vendor = dirname(dirname(__DIR__)) . '/vendor';
        if (!is_dir($vendor)) {
            $vendor = dirname(dirname(dirname(dirname(__DIR__))));
        }
        return $vendor;
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }
}
