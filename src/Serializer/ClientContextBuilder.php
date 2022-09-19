<?php

namespace App\Serializer;


use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Company;

final class ClientContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $tokenStorage;

    public function __construct(SerializerContextBuilderInterface $decorated, TokenStorageInterface $tokenStorage)
    {

        $this->decorated = $decorated;
        $this->tokenStorage = $tokenStorage;
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

    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

        $email = $this->getUser()->getEmail();
         if ($email == "gio@mail.fr") {
                if ($normalization)
                    $context['groups'][] = 'client1:read';
                else $context['groups'][] = 'client1:write';

        }
        return $context;
    }

}