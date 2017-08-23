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
 * @property $birthDate
 * @property integer $child
 * @property integer $classManagement
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_TEACHER = 'teacher';
    const USER_TYPE_EXPERT = 'expert';
    const USER_TYPE_PUPIL = 'pupil';
    const USER_TYPE_PARENT = 'parent';

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
            [['isAdmin', 'child', 'classManagement', 'parent'], 'integer'],
            [['name', 'lastName', 'email', 'phone', 'password', 'photo'], 'string', 'max' => 50],
            [['birthDate'], 'default', 'value' => date('Y-m-d')],
//            [['point'], 'safe'],
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
            'className' => 'Класс',
            'class' => 'Класс',
            'point' => 'Оценка',
            'child' => 'Ребенок',
            'classManagement' => 'Классное руководство',
            'parent' => 'Родитель',
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




    /**
     * Возвращает список пользователей по роли
     *
     * @param $role
     * @return array
     */
    public static function getUsersByRole($role)
    {
        $auth = Yii::$app->authManager;
        $users = $auth->getUserIdsByRole($role);

        return $users;
    }

    public static function getAllPupil($revertName = false)
    {
        $pupilsId = self::getUsersByRole('pupil');
        $users = User::find()->where(['id' => $pupilsId])->all();

        $data = [];
        foreach ($users as $user) {
            if ($revertName) {
                $data[$user->id] = $user->lastName . ' ' . $user->name;
            } else {
                $data[$user->id] = $user->name . ' ' . $user->lastName;
            }
        }

        return $data;
    }

    public static function getAllParents()
    {
        $pupilsId = self::getUsersByRole('parent');
        $users = User::find()->where(['id' => $pupilsId])->all();

        $data = [];
        foreach ($users as $user) {
            $data[$user->id] = $user->name . ' ' . $user->lastName;
        }

        return $data;
    }

    public static function getAllModerators()
    {
        $pupilsId = self::getUsersByRole(['expert', 'teacher']);
        $users = User::find()->where(['id' => $pupilsId])->all();

        $data = [];
        foreach ($users as $user) {
            $data[$user->id] = $user->name . ' ' . $user->lastName;
        }

        return $data;
    }

    public function getClass()
    {
        return $this->hasOne(SchoolClass::className(), ['id' => 'school_class_id'])
            ->viaTable('school_class_users', ['users_id' => 'id']);
    }

    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['id' => 'event_id'])
            ->viaTable('events_users', ['user_id' => 'id']);
    }

    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id'])
            ->viaTable('events_users', ['user_id' => 'id']);
    }

    public function getPoints()
    {
//        return $this->hasMany(Events::className(), ['id' => 'event_id'])
//            ->viaTable('points', ['user_id' => 'id']);
        return $this->hasOne(Points::className(), ['user_id' => 'id']);
//            ->andOnCondition(['points.event_id' => 'user.event_id']);
    }

    public function getPoint()
    {
        return (isset($this->points->point)) ? $this->points->point : '';

    }

    public function getPointed($eventId = 0)
    {
        return Points::findOne(['event_id' => $eventId, 'user_id' => $this->id]) ?? '';
    }

    public function getClassName()
    {
        return (isset($this->class->name)) ? $this->class->name : '';
    }

    public function getEventName()
    {
        return (isset($this->events->name)) ? $this->events->name : '';
    }

    public function getEventId()
    {
        return (isset($this->events->id)) ? $this->events->id : '';
    }

    public static function getDataPupilWithoutClass($classID = 9999)
    {
        $pupilsId = self::getUsersByRole('pupil');
        $usersData = User::find()
            ->joinWith('class')
            ->andWhere(['user.id' => $pupilsId, 'school_class_id' => $classID])
            ->orWhere(['user.id' => $pupilsId, 'school_class_id' => null]);

        return $usersData;
    }

    /**
     * Удаляет все связи учеников с данным классом
     * @param $classId
     */
    public static function deleteRelationWithClass($classId)
    {
        SchoolClassUsers::deleteAll(['school_class_id' => $classId]);
    }

    /**
     * Удаляет все связи учеников с событием
     * @param $eventId
     */
    public static function deleteRelationWithEvent($eventId)
    {
        EventsUsers::deleteAll(['event_id' => $eventId]);
    }

    /**
     * Возвращает название роли пользователя, если их несколько - вернет
     * имя первой.
     *
     * @param $userId
     * @return string
     */
    public static function getRoleDescByUserId( $userId)
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($userId);

        if (isset($roles[key($roles)]->description))
            return $roles[key($roles)]->description;

        return '';
    }

    /**
     * Возвращает название роли пользователя, если их несколько - вернет
     * имя первой.
     *
     * @param $userId
     * @return string
     */
    public static function getRoleNameByUserId( $userId)
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($userId);

        if (isset($roles[key($roles)]->name))
            return $roles[key($roles)]->name;

        return '';
    }

    public function isPupilInThisEvent($eventId)
    {
        foreach ($this->events as $event)
            if ($event->id == $eventId)
                return true;

        return false;
    }

    /**
     * Проверяет является ли текущий пользователь администратором
     *
     * @return bool
     */
    public static function isAdmin()
    {
        $role = self::getRoleNameByUserId(Yii::$app->user->identity->id);
        if ($role == self::USER_TYPE_ADMIN)
            return true;
        return false;
    }

    /**
     * Проверяет имеет ли текущий пользователь определенную роль
     *
     * @param $roleName
     * @return bool
     */
    public static function isRole($roleName)
    {
        $role = self::getRoleNameByUserId(Yii::$app->user->identity->id);
        if ($role == $roleName)
            return true;
        return false;
    }

}
