<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class ControllerGetCompany extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private $companyRepository;
    private $tokenStorage;

    public function __construct(CompanyRepository $companyRepository, TokenStorageInterface $tokenStorage)
    {
        $this->companyRepository = $companyRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function getCompany(Company $company): Company
    {
        $this->companyRepository->handle($company);

        return $company;
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

    public function __invoke(): JsonResponse
    {
        $email = $this->getUser()->getEmail();

        switch ($email){
            case "gio@mail.fr":
                $company = $this->companyRepository->find(1);
                return new JsonResponse([
                    'name' => $company->getName(),
                    'activity_area' => $company->getActivityArea(),
                    'adress' => $company->getAdress(),
                    'cp' => $company->getCp(),
                    'city' => $company->getCity(),
                    'country' => $company->getCountry(),
                ]);
            case "john@mail.fr":
                echo "c'est john";
                $company = $this->companyRepository->find(2);
                return new JsonResponse([
                    'name' => $company->getName(),
                    'activity_area' => $company->getActivityArea()
                ]);
            default:
                echo "Vous n'avez pas accès";
                return [];
                break;


        }

    }
}