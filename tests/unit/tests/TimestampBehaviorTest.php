<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\behaviors\TimestampBehavior;
use ddruganov\Yii2ApiEssentials\testing\UnitTest;
use Yii;
use yii\db\ActiveRecord;
use yii\db\pgsql\Schema;

final class TimestampBehaviorTest extends UnitTest
{
    public function testInsert()
    {
        $model = $this->createTestActiveRecord();
        $model->save();

        $this->assertNotNull($model->getCreatedAt());
        $this->assertNotNull($model->getUpdatedAt());

        $this->assertEquals($model->getCreatedAt(), $model->getUpdatedAt());
    }

    public function testUpdate()
    {
        $model = $this->createTestActiveRecord();
        $model->save();
        $originalCreatedAt = $model->getCreatedAt();
        sleep(1);
        $model->save();

        $this->assertNotNull($model->getCreatedAt());
        $this->assertEquals($model->getCreatedAt(), $originalCreatedAt);

        $this->assertNotNull($model->getUpdatedAt());

        $this->assertNotEquals($model->getCreatedAt(), $model->getUpdatedAt());
        $this->assertTrue($model->getUpdatedAt() > $model->getCreatedAt());
    }

    private function createTestActiveRecord()
    {
        Yii::$app->getDb()->createCommand()->createTable('test', [
            'id' => Yii::$app->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_PK),
            'created_at' => Yii::$app->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_TIMESTAMP),
            'updated_at' => Yii::$app->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_TIMESTAMP),
        ])->execute();

        return new class extends ActiveRecord
        {
            public static function tableName()
            {
                return 'test';
            }

            public function rules()
            {
                return [
                    [['created_at', 'updated_at'], 'safe']
                ];
            }

            public function behaviors()
            {
                return [TimestampBehavior::class];
            }

            public function getCreatedAt()
            {
                return $this->created_at;
            }

            public function getUpdatedAt()
            {
                return $this->updated_at;
            }
        };
    }
}
