<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\behaviors\TimestampBehavior;
use tests\unit\BaseUnitTest;
use Yii;
use yii\db\ActiveRecord;
use yii\db\pgsql\Schema;

class TimestampBehaviorTest extends BaseUnitTest
{
    private ActiveRecord $model;

    protected function _setUp()
    {
        parent::_setUp();
        $this->model = $this->createTestActiveRecord();
    }

    public function testInsert()
    {
        $this->model->save();

        $this->assertNotNull($this->model->created_at);
        $this->assertNotNull($this->model->updated_at);

        $this->assertEquals($this->model->created_at, $this->model->updated_at);
    }

    public function testUpdate()
    {
        $this->model->save();
        $originalCreatedAt = $this->model->created_at;
        sleep(1);
        $this->model->save();

        $this->assertNotNull($this->model->created_at);
        $this->assertEquals($this->model->created_at, $originalCreatedAt);

        $this->assertNotNull($this->model->updated_at);

        $this->assertNotEquals($this->model->created_at, $this->model->updated_at);
        $this->assertTrue($this->model->updated_at > $this->model->created_at);
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
        };
    }
}
