<?php

namespace ddruganov\Yii2ApiEssentials\common\http\filters;

use Yii;
use yii\base\ActionFilter;
use yii\db\Transaction;

class TransactionFilter extends ActionFilter
{
    private Transaction $transaction;

    public function beforeAction($action)
    {
        $this->transaction = Yii::$app->getDb()->beginTransaction();

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $result->isSuccessful()
            ? $this->transaction->commit()
            : $this->transaction->rollBack();

        return parent::afterAction($action, $result);
    }
}
