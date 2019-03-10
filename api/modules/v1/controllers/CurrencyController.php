<?php

namespace app\api\modules\v1\controllers;

use app\models\Currency;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth,
    yii\filters\ContentNegotiator,
    yii\filters\VerbFilter;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\Response;


class CurrencyController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                ['class' => HttpBearerAuth::className()],
                ['class' => QueryParamAuth::className(), 'tokenParam' => 'token'],
            ]
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }


    public function actionCurrencies($pagination = 0): array
    {
        return Currency::find()->asArray()->offset($pagination)->all();
    }

    public function actionView(int $id): array
    {
        return Currency::find()->where(['id' => $id])->asArray()->all();
    }
}