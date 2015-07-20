<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 12:36 AM
 */

namespace PasswordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PasswordBundle\Model\PasswordInterface;

/**
 * Password
 *
 * @ORM\Table(name="passwords")
 * @ORM\Entity
 */
class Password implements PasswordInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Password
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
