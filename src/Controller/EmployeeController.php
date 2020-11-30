<?php


namespace App\Controller;

use App\Entity\BaseEntityInterface;
use App\Entity\Employee;
use App\Manager\EmployeeManager;
use App\Manager\TitleManager;
use App\Twig\GenderExtension;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeeController extends AbstractController
{

    private $employeeManager;

    public function __construct(EmployeeManager $employeeManager)
    {
        $this->employeeManager = $employeeManager;
    }

    /**
     * @Route("/addemployee", name="addemployee")
     */
    public function addEmployee()
    {
        return $this->render('Employee/addEmployee.html.twig');
    }

    /**
     * @Route("/json/addemployee", name="json_add_employee")
     */
    public function jsonAddEmployee(Employee $FSDConverter)
    {
        $result = $this->employeeManager->persist($FSDConverter);
        return new JsonResponse($result instanceof BaseEntityInterface ? $this->formatResponse($result) : $this->formatCustomResponse($result));
    }

    /**
     * @Route("/json/editemployee", name="json_edit_employee")
     */
    public function jsonEditEmployee(Employee $FSDConverter)
    {
        $result = $this->employeeManager->merge($FSDConverter);
        return new JsonResponse($result instanceof BaseEntityInterface ? $this->formatResponse($result) : $this->formatCustomResponse($result));
    }

    /**
     * @Route("/showemployees", name="show_employees")
     */
    public function showEmployees()
    {
        return $this->render('Employee/showEmployees.html.twig');
    }

    /**
     * @Route("/json/showemployees", name="json_show_all_employees")
     */
    public function showAllEmployees(SerializerInterface $serializer)
    {
        $employees = $this->employeeManager->findAll();
        return new JsonResponse($serializer->serialize($employees, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]), 200, [], true);

    }

    /**
     * @Route("/json/showcustomemployees", name="json_show_custom_employees")
     */
    public function showCustomEmployees(Request $request, SerializerInterface $serializer)
    {
        $employees = $this->employeeManager->findCustom($request->getContent());

        return new JsonResponse($serializer->serialize($employees, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]), 200, [], true);
    }

    /**
     * @Route("/employee/edit/{id}", name="edit_employee", methods={"GET"})
     */
    public function findEmployeeCustom(Request $request)
    {
        $employee = $this->employeeManager->find($request->get('id'));
        return $this->render('Employee/editEmployee.html.twig', ['employee' => $employee[0]]);
    }

    public function formatResponse(BaseEntityInterface $entity)
    {
        if($entity->getId()){
            return [
                'code' => 200,
                'status' => 'saved',
                'id' => $entity->getId(),
            ];
        } else {
            return [
                'code' => 500,
                'status' => 'error',
            ];
        }
    }

    public function formatCustomResponse($data, $code = 400){
        return [
            'code' => $code,
            'data' => $data,
        ];
    }

}