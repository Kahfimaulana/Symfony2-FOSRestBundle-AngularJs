<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 1:04 AM
 */
namespace PasswordBundle\Model;

Interface PasswordInterface {

    /**
     * @param $key
     * @return PasswordInterface
     */
    public function setKey($key);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param $username
     * @return PasswordInterface
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param $password
     * @return PasswordInterface
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPassword();
}