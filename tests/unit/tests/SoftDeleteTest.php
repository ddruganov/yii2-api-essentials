<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\testing\UnitTest;
use ddruganov\Yii2ApiEssentials\traits\SoftDelete;
use Yii;
use yii\db\ActiveRecord;
use yii\db\pgsql\Schema;

final class SoftDeleteTest extends UnitTest
{
    public function testInsert()
    {
        $model = $this->createTestActiveRecord();
        $model->save();
        $this->assertNull($model->getDeletedAt());
    }

    public function testDelete()
    {
        $model = $this->createTestActiveRecord();
        $model->save();
        $model->delete();

        $this->assertNotNull($model->getDeletedAt());
        $this->assertNotNull($model->find()->exists());
    }

    private function createTestActiveRecord()
    {
        Yii::$app->getDb()->createCommand()->createTable('test', [
            'id' => Yii::$app->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_PK),
            'deleted_at' => Yii::$app->getDb()->getSchema()->createColumnSchemaBuilder(Schema::TYPE_TIMESTAMP),
        ])->execute();

        return new class extends ActiveRecord
        {
            use SoftDelete;

            public static function tableName()
            {
                return 'test';
            }

            public function rules()
            {
                return [
                    [['deleted_at'], 'safe']
                ];
            }

            public function getDeletedAt()
            {
                return $this->deleted_at;
            }
        };
    }
}
