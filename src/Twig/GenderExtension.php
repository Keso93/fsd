<?php


namespace App\Twig;


use App\Entity\Employee;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GenderExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('loadGenders', [$this, 'loadGender']),
        ];
    }

    public function loadGender()
    {
        return Employee::getGenders();
    }

}