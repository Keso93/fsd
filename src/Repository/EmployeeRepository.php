<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    const ALIAS = "a";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }
    public function findEmployeeById($id){

        return $this->createQueryBuilder(self::ALIAS)
            ->where(self::ALIAS. '.id=' . $id)
            ->getQuery()->getResult();
    }

    public function findAllEmployees(){
        return $this->createQueryBuilder(self::ALIAS)
            ->getQuery()->getResult();
    }

    public function findCustomEmployees($filter){
        return $this->createQueryBuilder(self::ALIAS)
            ->where(self::ALIAS. '.active=' . $filter)
            ->getQuery()->getResult();
    }

    public function saveEmployee(Employee $employee){
        $this->_em->persist($employee);
        $this->_em->flush();
        return $employee;
    }
    public function mergeEmployee(Employee $employee)
    {
        $this->_em->merge($employee);
        $this->_em->flush();

        return $employee;
    }

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
