<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 2:31 PM
 */

namespace PasswordBundle\Handler;

use PasswordBundle\Model\PasswordInterface;

interface PasswordHandlerInterface {

    /**
     * Get All Passwords
     *
     * @return array
     */
    public function getAll();

    /**
     * Get Password
     * @param $key
     * @return PasswordInterface
     */
    public function get($key);

    /**
     * Create new Password
     *
     * @param array $params
     * @return PasswordInterface
     */
    public function post(array $params);

    /**
     * Update Password
     *
     * @param PasswordInterface $passwordInterface
     * @param array $params
     * @return PasswordInterface
     */
    public function put(PasswordInterface $passwordInterface, array $params);

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);
} 