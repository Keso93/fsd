<?php

namespace App\Utils\Validation;

use App\Entity\BaseEntityInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidator
{
    /** @var ValidatorInterface  */
    private $validator;

    /**
     * EntityValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param BaseEntityInterface $entity
     *
     * @return bool|array
     */
    public function validate(BaseEntityInterface $entity){

        $errors = $this->validator->validate($entity);

        if (count($errors) > 0){
            $errorMessages = [];
            /** @var ConstraintViolation $error */
            foreach ($errors as $error){
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $errorMessages;
        }

        return true;
    }

}