<?php

namespace yiiacceptance\controllers;

use yii\web\Controller;
use yiiacceptance\models\NumberModel;
use yiiacceptance\models\NumberTypeModel;
use yiiacceptance\models\CountryNumberModel;

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
}
