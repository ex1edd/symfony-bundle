<?php

namespace App\Serializer\Normalizer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Normalizer implements NormalizerInterface
{
    private $dateTimeFormat;

    public function __construct()
    {
        $this->dateTimeFormat = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ATOM) :
                ($innerObject instanceof \DateTimeImmutable ? $innerObject->format(\DateTimeImmutable::ATOM) : '');
        };
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $defaultContext = [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH     => true,
            AbstractObjectNormalizer::MAX_DEPTH_HANDLER    => function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                return null;
            },
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return null;
            },
            AbstractNormalizer::CALLBACKS => [
                'expiredAt' => $this->dateTimeFormat,
                'date' => $this->dateTimeFormat,
                'lastVisit' => $this->dateTimeFormat,
                'lastDate' => $this->dateTimeFormat,
                'replaceDate' => $this->dateTimeFormat,
            ]
        ];

        $defaultContext[AbstractObjectNormalizer::GROUPS] = $context['groups'];

        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader (new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer]);

        return $serializer->normalize($object);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return false;//$data instanceof \App\Entity\User;
    }

    public function getSupportedTypes(?string $format): array//For optimization
    {
        return [
            'object' => null,             // Doesn't support any classes or interfaces
            '*' => false,                 // Supports any other types, but the result is not cacheable
            \App\Entity\User::class => true, // Supports \App\Entity\User, AccessToken and result is cacheable
            \App\Entity\AccessToken::class => true,
            \App\Entity\BenchIndex::class => true,
            \App\Entity\HandbookItem::class => true,
            \App\Entity\Handbook::class => true,
            \App\Entity\Organization::class => true,
            \App\Entity\OrganizationBench::class => true,
            \App\Entity\UserOrganization::class => true,
            \App\Entity\Remark::class => true
        ];
    }
}
