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
}
