<?php

namespace mikk150\phonevalidator;

use yii\web\AssetBundle;

/**
*
*/
class LibPhoneNumberAsset extends AssetBundle
{
    public $sourcePath = '@bower/google-libphonenumber/dist';

    public $js = [
        'libphonenumber.js'
    ];
}
