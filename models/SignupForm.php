<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class SignupForm extends Model
{
    public string $full_name = "";
    public string $username = "";
    public string $password = "";
    public string $password_repeat = "";

    /**
     * Rules for register credentials
     * @return array
     */
    public function rules(): array
    {
        return [
            [['full_name', 'username', 'password', 'password_repeat'], 'required'],
            [['username', 'password'], 'string', 'min' => 4, 'max' => 16],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['full_name', 'validateFullname']
        ];
    }

    public function validateFullname(string $attribute, array $params, $validator)
    {
        $hasTwoWords = str_word_count($this->full_name) >= 2;

        if (!$hasTwoWords)
        {
            $this->addError($attribute, 'Full name must have 2 words');
        }
    }

    public function signUp(): bool
    {

        $newUser = new User();
        $newUser->full_name = $this->full_name;
        $newUser->username = $this->username;

        $hashedPassword = Yii::$app->security->generatePasswordHash($this->password);
        $newUser->password = $hashedPassword;

        $randomAccessToken = Yii::$app->security->generateRandomString(32);
        $newUser->access_token = $randomAccessToken;

        $randomAuthKey = Yii::$app->security->generateRandomString(32);
        $newUser->auth_key = $randomAuthKey;

        $foundUser = User::findByUsername($newUser->username);
        $userDoesNotExist = !$foundUser;

        if ($userDoesNotExist)
            return $newUser->save();

        $this->addError('username', 'User already exists');
        return false;
    }

}