<?php

namespace src\common\behaviors;

use src\common\DateHelper;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class TimestampBehavior extends Behavior
{
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'onBeforeValidate',
        ];
    }

    public function onBeforeValidate(Event $event): void
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;

        if ($model->hasAttribute('created_at') && !$model->getAttribute('created_at')) {
            $model->setAttributes([
                'created_at' => DateHelper::now()
            ]);
        }

        if ($model->hasAttribute('updated_at')) {
            $model->setAttributes([
                'updated_at' => DateHelper::now()
            ]);
        }
    }
}
