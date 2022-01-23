<?php

namespace src\auth\http\filters;

use src\auth\exeptions\PermissionDeniedException;
use src\auth\models\rbac\Permission;
use src\common\exceptions\ModelNotFoundException;
use src\common\ExecutionResult;
use Throwable;
use Yii;
use yii\base\ActionFilter;

class RbacFilter extends ActionFilter
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

        return parent::beforeAction($action);
    }
}
