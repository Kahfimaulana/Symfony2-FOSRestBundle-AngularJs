<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 12:36 AM
 */

namespace PasswordBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View;
use PasswordBundle\Form\PasswordType;
use PasswordBundle\Model\PasswordInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Util\Codes;
use PasswordBundle\Exception\InvalidFormException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PasswordController extends FOSRestController{

    public function getPasswordHandler(){
        return $this->container->get('password.handler');
    }
    /**
     * List all Passwords.
     * @Route("/v1/passwords", name="passwordGetAll")
     * @Template()
     * @return Response
     */
    public function getPasswordsAction()
    {
        $passwords = $this->getPasswordHandler()->getAll();

        /*$serializer = $this->container->get('serializer');
        $parsePasswords = $serializer->serialize($passwords, 'json');
        return new Response($parsePasswords);*/

        return $passwords;
    }

    /**
     * Get single Password,
     * @Annotations\View(templateVar="password")
     *
     * @param Request $request the request object
     * @param string $key the password key
     *
     * @return array
     *
     * @throws NotFoundHttpException when password not exist
     */
    public function getPasswordAction($key)
    {
        if (!($password = $this->getPasswordHandler()->get($key))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$key));
        }

        return $password;
    }

    /**
     * Presents the form to use to create a new password.
     *
     * @Annotations\View()
     *
     * @return FormTypeInterface
     */
    public function newPasswordAction()
    {
        return $this->createForm(new PasswordType());
    }

    /**
     * Create a Password from the submitted data.
     * @Route("/v1/passwords", name="passwordPost")
     * @Template()
     *
     * @Annotations\View(
     *  template = "PasswordBundle:Password:newPassword.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST
     * )
     *
     * @return FormTypeInterface|RouteRedirectView
     */
    public function postPasswordAction()
    {
        try {
            $newPassword = $this->getPasswordHandler()->post(
                $this->container->get('request')->request->all()
            );

            $routeOptions = array(
                'key' => $newPassword->getKey(),
                '_format' => $this->container->get('request')->get('_format')
            );

            return $this->routeRedirectView('api_1_get_password', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return array('form' => $exception->getForm());
        }
    }

    /**
     * Update existing Password
     *
     * @Annotations\View(
     *  template = "PasswordBundle:Password:editPassword.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request   $request the request object
     * @param string    $key      the password key
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function putPasswordAction(Request $request, $key)
    {
        try {

            if (!($password = $this->getPasswordHandler()->get($key))) {
                $statusCode = Codes::HTTP_CREATED;
                $password = $this->container->get('password.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $password = $this->container->get('password.handler')->put(
                    $password,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'key' => $password->getKey(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_password', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * @Annotations\View(templateVar="password")
     *
     * @param $key
     * @return array|null|Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deletePasswordAction($key){
        try{
            if (!($password = $this->container->get('password.handler')->get($key))) {
                $statusCode = Codes::HTTP_NOT_FOUND;
            }else{
                $this->container->get('password.handler')->delete($key);
                $statusCode = Codes::HTTP_OK;
            }
        }catch (InvalidFormException $exception){
            return $exception->getForm();
        }

        return $statusCode;
    }
}