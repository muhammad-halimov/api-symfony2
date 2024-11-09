<?php

namespace App\Serializer;

use App\Entity\Updates;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

readonly class UpdatesNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private StorageInterface    $storage
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /* @var Updates $object */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['target'] = $this->storage->resolveUri($object, 'targetFile');

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Updates;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Updates::class => true,
        ];
    }
}