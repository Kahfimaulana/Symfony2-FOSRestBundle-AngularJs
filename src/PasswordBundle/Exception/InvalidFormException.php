<?php
/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 8:51 PM
 */

namespace PasswordBundle\Exception;


use RuntimeException;

class InvalidFormException extends RuntimeException{
    protected $form;

    public function __construct($message, $form = null)
    {
        parent::__construct($message);
        $this->form = $form;
    }

    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
} 