<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 1:07 AM
 */

namespace PasswordBundle\Handler\Impl;

use Doctrine\Common\Persistence\ObjectManager;
use PasswordBundle\Exception\InvalidFormException;
use PasswordBundle\Form\PasswordType;
use PasswordBundle\Handler\PasswordHandlerInterface;
use PasswordBundle\Model\PasswordInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class PasswordHandlerImpl implements PasswordHandlerInterface{

    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get All Passwords
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findBy(array());
    }

    /**
     * GET Password
     * @param $key
     * @return PasswordInterface
     */
    public function get($key)
    {
        return $this->repository->find($key);
    }

    /**
     * CREATE new Password
     *
     * @param array $params
     *
     * return PasswordInterface
     */
    public function post(array $params){
        $password = $this->createPassword();

        return $this->processForm($password, $params, 'POST');
    }

    /**
     * EDIT a Password.
     *
     * @param PasswordInterface $passwordInterface
     * @param array             $params
     *
     * @return PasswordInterface
     */
    public function put(PasswordInterface $passwordInterface, array $params)
    {
        return $this->processForm($passwordInterface, $params, 'PUT');
    }

    /**
     * DELETE Password
     * @param $key
     * @return mixed|void
     */
    public function delete($key)
    {
        $password = $this->get($key);

        $this->om->remove($password);
        $this->om->flush();
    }

    /**
     * Processes the form.
     *
     * @param PasswordInterface $passwordInterface
     * @param array             $param
     * @param String            $method
     *
     * @return PasswordInterface
     *
     * @throws \PasswordBundle\Exception\InvalidFormException
     */
    private function processForm(PasswordInterface $passwordInterface, array $param, $method)
    {
        $form = $this->formFactory->create(new PasswordType(), $passwordInterface, array('method' => $method));
        $form->submit($param, 'PATCH' !== $method);

        if ($form->isValid()) {

            $password = $form->getData();
            /*var_dump($password);*/
            $this->om->persist($password);
            $this->om->flush($password);

            return $password;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createPassword(){
        return new $this->entityClass();
    }
} 