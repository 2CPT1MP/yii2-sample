<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property ?string id
 * @property ?string full_name
 * @property ?string username
 * @property ?string password
 * @property ?string auth_key
 * @property ?string access_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Changes associated table name
     *
     * @return string Changed table name
     */
    public static function tableName(): string
    {
        return 'user';
    }
/*
    public function rules(): array
    {
        return [
            [['full_name', 'username', 'password'], 'required'],
            [['username', 'password'], 'string', 'min' => 4, 'max' => 16]
        ];
    }*/


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?ActiveRecord
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * {@inheritdoc}
     * @return ?ActiveRecord
     */
    public static function findIdentityByAccessToken($token, $type = null): ?ActiveRecord
    {
       return self::find()->where(['access_token' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return ?ActiveRecord
     */
    public static function findByUsername(string $username): ?ActiveRecord
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
