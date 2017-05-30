<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $role
 * @property string $access_token
 */
class Usertest extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'role', 'access_token'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['password_reset_token'], 'unique'],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role' => 'Role',
            'access_token' => 'Access Token',
        ];
    }
	
	
	public function fields()
	{
		$fields = parent::fields();
		
		unset($fields['auth_key'], $fields['password_hash'], $fields['created_at'], $fields['updated_at'], $fields['password_reset_token'], $fields['access_token'], $fields['status']);
	
		return $fields;
	}

/*

	public function fields()
{
	
	$fields = array(
        'id' => 'id',
        'email' => 'email',
        'username' => "username"
    );
	
	 
	return $fields;
    
}

 
	public function fields()
{
	
	$fields = array(
        'id',
        'email' => 'email',
        'username' => "username"
    );
	
	unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
	 
	return $fields;
    
}
 */
/* 
public function fields()
{
    $fields = parent::fields();

    // remove fields that contain sensitive information
    unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

    return $fields;
}

 */


    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
   /*  public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
 */
	
	 public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
	
	
    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

	 public function actionTest($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
}
