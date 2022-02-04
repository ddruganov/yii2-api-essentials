<?php

namespace ddruganov\Yii2ApiEssentials\traits;

use ddruganov\Yii2ApiEssentials\DateHelper;

trait SoftDelete
{
    public function delete()
    {
        if (!$this->beforeDelete()) {
            return false;
        }

        $columnName = $this->softDeleteColumnName ?? 'deleted_at';
        $this->setAttributes([
            $columnName => DateHelper::now()
        ]);
        $success = $this->save();

        $this->afterDelete();

        return $success;
    }
}
