<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Stat]].
 *
 * @see \app\models\Stat
 */
class StatQuery extends \yii\db\ActiveQuery
{
    /**
    * СТатистика свежая
    */
    public function current()
    {
        return $this->andWhere([
            'is_current' => 1,
        ]);
    }

    /**
    * Сьатистика старая
    */
    public function notCurrent()
    {
        return $this->andWhere([
            'is_current' => 0,
        ]);
    }
}
