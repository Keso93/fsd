<?php


namespace App\Manager;

use App\Repository\TitleRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;

class TitleManager
{
    private $titleRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(TitleRepository $titleRepository, SerializerInterface $serializer)
    {
        $this->titleRepository = $titleRepository;
        $this->serializer = $serializer;
    }

    public function findAll()
    {
        return $this->titleRepository->findAllTitles();
    }

}