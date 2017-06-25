<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    /**
     * Консольная команда для создания стандартных ролей пользователей
     */
    public function actionRoleCreate()
    {
        die;
        $auth = Yii::$app->authManager;

        $roles = [
            'admin' => 'Администратор',
            'pupil' => 'Ученик',
            'teacher' => 'Педагог',
            'expert' => 'Эксперт',
            'parent' => 'Родитель',
        ];

        foreach ($roles as $roleName => $desc) {
            $role = $auth->createRole($roleName);
            $role->description = $desc;
            $auth->add($role);
        }

        echo "Роли успешно добавлены\n";
    }

    /**
     * Создает и распределяет права доступа
     */
    public function actionCreatePermit()
    {
        die;
        $auth = Yii::$app->authManager;

        $permissions = [
            'admin' => [
                'permit' => 'userManage',
                'desc' => 'CRUD пользователей'
            ]
        ];

        foreach ($permissions as $roleName => $info) {
            $permit = $auth->createPermission($info['permit']);
            $permit->description = $info['desc'];
            $auth->add($permit);

            $role = $auth->getRole($roleName);
            $auth->addChild($role, $permit);
        }

        echo "Права доступа успешно распределены\n";
    }

    /**
     * Назначает роли пользователям
     */
    public function actionAssignRoles()
    {
        $roles = [
            'admin' => [1],
        ];

        $auth = Yii::$app->authManager;
        foreach ($roles as $roleName => $ids) {
            $role = $auth->getRole($roleName);

            foreach ($ids as $id) {
                $auth->assign($role, $id);
            }
        }

        echo "Роли успешно распределены\n";
    }
}
