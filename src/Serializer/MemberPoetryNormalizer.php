<?php

namespace App\Serializer;

use App\Entity\MemberPoetry;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

readonly class MemberPoetryNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /* @var MemberPoetry $object */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['title'] = $object->getTitle() !== null ? $object->getTitle() : '';
        $data['description'] = $object->getDescription() !== null ? $object->getDescription() : '';
        $data['text'] = $object->getText() !== null ? $object->getText() : '';

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof MemberPoetry;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MemberPoetry::class => true,
        ];
    }
}