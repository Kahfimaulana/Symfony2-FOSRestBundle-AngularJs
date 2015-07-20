<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 1:49 AM
 */
namespace PasswordBundle\Tests\Fixtures\Entity;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PasswordBundle\Entity\Password;

class LoadPasswordData implements  FixtureInterface{

    static public $passwords = array();

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $password = new Password();

        $password->setKey('testKey');
        $password->setUsername('testUsername');
        $password->setPassword('testPassword');

        $manager->persist($password);
        $manager->flush();

        self::$passwords[] = $password;
    }
}
?>