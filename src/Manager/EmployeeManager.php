<?php


namespace App\Manager;


use App\Entity\Employee;
use App\Entity\Title;
use App\Repository\EmployeeRepository;
use App\Repository\TitleRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;
use App\Utils\Validation\EntityValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeManager
{
    private $employeeRepository;
    /**
     * @var EntityValidator
     */
    private $validator;

    public function __construct(EmployeeRepository $employeeRepository, EntityValidator $validator)
    {
        $this->employeeRepository = $employeeRepository;
        $this->validator = $validator;
    }

    public function find($id)
    {
        return $this->employeeRepository->findEmployeeById($id);
    }

    public function findAll()
    {
        return $this->employeeRepository->findAllEmployees();
    }

    public function findCustom($filter)
    {
        return $this->employeeRepository->findCustomEmployees($filter);
    }

    public function persist($employee)
    {
        return ($result = $this->validator->validate($employee)) === true ? $this->employeeRepository->saveEmployee($employee) : $result;
    }

    public function merge($employee)
    {
        return ($result = $this->validator->validate($employee)) === true ? $this->employeeRepository->mergeEmployee($employee) : $result;
    }

}