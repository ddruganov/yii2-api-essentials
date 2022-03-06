<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\traits\SoftDelete;
use tests\unit\BaseUnitTest;
use Yii;
use yii\db\ActiveRecord;
use yii\db\pgsql\Schema;

class SoftDeleteTest extends BaseUnitTest
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
        $this->assertNull($this->model->deleted_at);
    }

    public function testDelete()
    {
        $this->model->save();
        $this->model->delete();

        $this->assertNotNull($this->model->deleted_at);
        $this->assertNotNull($this->model->find()->exists());
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
        };
    }
}
