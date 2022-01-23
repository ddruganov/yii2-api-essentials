<?php

namespace src\http\filters;

use src\exceptions\ModelNotFoundException;
use src\ExecutionResult;
use src\exeptions\PermissionDeniedException;
use src\models\rbac\Permission;
use Throwable;
use Yii;
use yii\base\ActionFilter;

class AllowFilter extends ActionFilter
{
    public array $rules = [];

    public function beforeAction($action)
    {
        try {
            $permissionName = $this->rules[$this->getActionId($action)] ?? null;
            $permission = Permission::findOne(['name' => $permissionName]);
            if (!$permission) {
                throw new ModelNotFoundException(Permission::class);
            }

            $user = Yii::$app->get('auth')->getCurrentUser();

            if (!Yii::$app->rbac->checkPermission($permission, $user)) {
                throw new PermissionDeniedException();
            }
        } catch (Throwable $t) {
            $isPermissionDeniedException = $t instanceof PermissionDeniedException;
            if (!$isPermissionDeniedException) {
                throw $t;
            }

            Yii::$app->getResponse()->data = ExecutionResult::exception($t->getMessage());
            Yii::$app->getResponse()->setStatusCode(403);
            Yii::$app->end();
        }

        return true;
    }
}
