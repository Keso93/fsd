<?php


namespace App\Controller;

use App\Manager\TitleManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\VarDumper\VarDumper;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TitleController extends AbstractController
{

    /**
     * @var TitleManager
     */
    private $titleManager;


    public function __construct(TitleManager $titleManager)
    {
        $this->titleManager = $titleManager;
    }

    /**
     * @Route("/json_show_titles", name="json_show_titles")
     */
    public function showTitles()
    {
        $titles = $this->titleManager->findAll();
        return new JsonResponse(['titles'=>$titles]);
    }


}