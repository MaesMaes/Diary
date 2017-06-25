<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isAdmin
 * @property string $photo
 * @property string $lastName
 * @property string $phone
 * @property  $birthDate
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'lastName', 'email', 'phone', 'password', 'photo'], 'string', 'max' => 50],
            [['birthDate'], 'default', 'value' => date('Y-m-d')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'lastName' => 'Фамилия',
            'birthDate' => 'Дата рождения',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'isAdmin' => 'Is Admin',
            'photo' => 'Фото',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity( $id )
    {
        return User::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken( $token, $type = null )
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey( $authKey )
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }

    public static function getRolesData($id)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRolesByUser($id);
        $role = ArrayHelper::map($role, 'name', 'description');

        $roles = User::getRolesMap();

        return [
            'role' => $role,
            'roles' => $roles
        ];
    }

    /**
     * Возвращает ассоциативный массив всех ролей в виде:
     * [
     *    'admin' => 'Администратор'
     *    ...
     * ]
     *
     * @return array
     */
    public static function getRolesMap()
    {
        $roles = Yii::$app->authManager->getRoles();
        return ArrayHelper::map($roles, 'name', 'description');
    }

    /**
     * Update-тит роль пользователя
     *
     * @param $userID
     * @param $roleName
     */
    public static function updateRole($userID, $roleName)
    {
        $auth = $roles = Yii::$app->authManager;

        $auth->revokeAll($userID);

        $role = $auth->getRole($roleName);
        $auth->assign($role, $userID);
    }

    /**
     * Возвращает имя по роли по ID пользователя
     *
     * @param $id
     * @return mixed
     */
    public static function getRoleName($id)
    {
        $auth = $roles = Yii::$app->authManager;
        $role = $auth->getRolesByUser($id);

        $roleName = '';
        if ($role) {
            $role = ArrayHelper::map($role, 'name', 'description');
            $roleName = $role[key($role)];
        }

        return $roleName;
    }
}
