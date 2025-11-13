<?php

namespace yiiacceptance\controllers;

use yii\web\Controller;
use yiiacceptance\models\CountryNumberModel;
use yiiacceptance\models\NoCountryNumberModel;
use yiiacceptance\models\NumberModel;
use yiiacceptance\models\NumberTypeModel;

/**
*
*/
class TestController extends Controller
{
    public function actionNumberModel()
    {
        $model = new NumberModel;

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionNumberTypeModel()
    {
        $model = new NumberTypeModel;

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionCountryModel()
    {
        $model = new CountryNumberModel();

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionNoCountryModel()
    {
        $model = new NoCountryNumberModel();

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
