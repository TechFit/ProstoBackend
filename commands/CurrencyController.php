<?php

namespace app\commands;

use Yii;
use app\models\Currency;
use yii\console\Controller;

/**
 * Class CurrencyController
 * @package app\commands
 */
class CurrencyController extends Controller
{
    const ACTUAL_CURRENCY_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public function actionUpdate()
    {
        echo "Update start \n";

        $xml_contents = file_get_contents(self::ACTUAL_CURRENCY_URL);

        $currency_nodes = simplexml_load_string($xml_contents);

        $currencies = [];

        foreach ($currency_nodes AS $key => $node) {

            $value  = floatval(str_replace(',', '.', str_replace('.', '', $node->Value)));

            array_push($currencies, ['name' => (string) $node->Name, 'rate' => $value]);

        }

        $db = Yii::$app->db;
        $sql = $db->queryBuilder->batchInsert(Currency::tableName(), ['name', 'rate'], $currencies);
        $db->createCommand($sql . ' ON DUPLICATE KEY UPDATE name = VALUES(name), rate = VALUES(rate)')->execute();

        echo "Update done \n";
    }
}
