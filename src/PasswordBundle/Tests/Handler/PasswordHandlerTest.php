<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 6:05 PM
 */

namespace PasswordBundle\Tests\Handler;

use PasswordBundle\Entity\Password;
use PasswordBundle\Handler\Impl\PasswordHandlerImpl;


class PasswordHandlerTest extends \PHPUnit_Framework_TestCase{
    const PAGE_CLASS = 'PasswordBundle\Tests\Handler\DummyPage';

    /** @var PasswordHandlerImpl */
    protected $passwordHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }

        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::PAGE_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::PAGE_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::PAGE_CLASS));


    }

    public function testGet()
    {
        $id = 1;
        $password = $this->getPassword();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($password));

        $this->passwordHandler = $this->createPasswordHandler($this->om, static::PAGE_CLASS,  $this->formFactory);

        $this->passwordHandler->get($id);
    }

    protected function createPasswordHandler($objectManager, $pageClass, $formFactory)
    {
        return new PasswordHandlerImpl($objectManager, $pageClass, $formFactory);
    }

    protected function getPassword()
    {
        $pageClass = static::PAGE_CLASS;

        return new $pageClass();
    }
}

class DummyPage extends Password
{
}