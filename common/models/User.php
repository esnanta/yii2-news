<?php

namespace common\models;

use common\commands\AddToTimelineCommand;
use common\models\query\UserQuery;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int         $id
 * @property string      $username
 * @property string      $password_hash
 * @property string      $email
 * @property string      $auth_key
 * @property string      $access_token
 * @property string      $oauth_client
 * @property string      $oauth_client_user_id
 * @property string      $publicIdentity
 * @property int         $status
 * @property int         $created_at
 * @property int         $updated_at
 * @property int         $logged_at
 * @property string      $password             write-only password
 * @property UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_NOT_ACTIVE = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_DELETED = 3;

    public const ROLE_USER = 'user';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_ADMINISTRATOR = 'administrator';

    public const EVENT_AFTER_SIGNUP = 'afterSignup';
    public const EVENT_AFTER_LOGIN = 'afterLogin';

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'notifySignup']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'notifyDeletion']);
        parent::init();
    }

    public static function findIdentity($id)
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one()
        ;
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token])
            ->one()
        ;
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return null|array|User
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username])
            ->one()
        ;
    }

    /**
     * Finds user by username or email.
     *
     * @param string $login
     *
     * @return null|array|User
     */
    public static function findByLogin($login)
    {
        return static::find()
            ->active()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one()
        ;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key',
                ],
                'value' => \Yii::$app->getSecurity()->generateRandomString(),
            ],
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token',
                ],
                'value' => function () {
                    return \Yii::$app->getSecurity()->generateRandomString(40);
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status',
                ],
            ]
        );
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
        ];
    }

    /**
     * Returns user statuses list.
     *
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => \Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => \Yii::t('common', 'Active'),
            self::STATUS_DELETED => \Yii::t('common', 'Deleted'),
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('common', 'Username'),
            'email' => \Yii::t('common', 'E-mail'),
            'status' => \Yii::t('common', 'Status'),
            'access_token' => \Yii::t('common', 'API access token'),
            'created_at' => \Yii::t('common', 'Created at'),
            'updated_at' => \Yii::t('common', 'Updated at'),
            'logged_at' => \Yii::t('common', 'Last login'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Creates user profile and application event.
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        $profile = new UserProfile();
        $profile->locale = \Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = \Yii::$app->authManager;
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    public function notifySignup($event)
    {
        $this->refresh();
        \Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at,
            ],
        ]));
    }

    public function notifyDeletion($event)
    {
        \Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'delete',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'deleted_at' => time(),
            ],
        ]));
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }

        return $this->email;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
