<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Log;
use app\models\Stat;

/**
 * StatController
 */
class StatController extends Controller
{
    /**
     * Пересчет суммы выигрыша пользователей
     */
    public function actionIndex()
    {
        $stats = Stat::find()
        	->notCurrent()
        	->limit(50)
        	->all();

        foreach ($stats as $stat)
        {
        	$sum = Log::find()
	        	->andWhere([
	        		'user_id' => $stat->user_id
	        	])
	        	->sum('gain');

	        $stat->value = $sum;
	        $stat->is_current = 1;
	        $stat->save();
        }
    }
}
