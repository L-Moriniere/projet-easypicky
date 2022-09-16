<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class PatchCompanyController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private $companyRepository;
    private $tokenStorage;
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager, CompanyRepository $companyRepository, TokenStorageInterface $tokenStorage)
    {
        $this->companyRepository = $companyRepository;
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }


    public function __invoke($data)
    {
        if ($this->getUser()->getCompany()->getId() == $data->getId()) {
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            return new JsonResponse("Company " . $data->getName() . " modifiée avec succès") ;
        }
        else return new JsonResponse("Vous n'avez pas les droits") ;
    }


    public function getUser(): ?User
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return null;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return null;
        }

        return $user;
    }

}