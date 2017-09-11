<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 29-8-2017
 * Time: 09:06
 */

class user
{
    private $username;
    private $password;
    private $user_id;

    /**
     * user constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * Let op: De user_id is auto-incremented door de MySQL database ('user');
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }




}