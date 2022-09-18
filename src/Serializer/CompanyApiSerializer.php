<?php

namespace App\Serializer;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\NormalizationAwareInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class CompanyApiSerializer implements \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface, NormalizerAwareInterface,
        ContextAwareDenormalizerInterface,DenormalizerAwareInterface
{

    use NormalizerAwareTrait;
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_NORMALIZER = 'CompanyApiNormalizerAlreadyCalled';
    private const ALREADY_CALLED_DENORMALIZER = 'CompanyApiDenormalizerAlreadyCalled';
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        $alreadyCalled = $context[self::ALREADY_CALLED_NORMALIZER] ?? false;
        return $data instanceof Company && $alreadyCalled == false;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {

        if ($this->userHasPermissions($object)) {
            $context['groups'][] = 'client1:read';
        }
        $context[self::ALREADY_CALLED_NORMALIZER] = true;

        return $this->normalizer->normalize($object, $format, $context);
    }



    private function userHasPermissions($object): bool
    {
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();

        if ($user->getId() == 2)
            return true;
        else return false;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        $alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return $data instanceof Company && $alreadyCalled == false;
    }


    public function denormalize($data, string $type, string $format = null, array $context = [])
    {

        if ($this->userHasPermissions($data)) {
            $context['groups'][] = 'client1:write';
        }
        $context[self::ALREADY_CALLED_DENORMALIZER] = true;

        return $this->denormalizer->denormalize($data, $format, $context);
    }
}