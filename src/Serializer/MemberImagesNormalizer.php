<?php

namespace App\Serializer;

use App\Entity\MemberImages;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

readonly class MemberImagesNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private StorageInterface    $storage
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /* @var MemberImages $object */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['image'] = $this->storage->resolveUri($object, 'imageFile');
        $data['title'] = $object->getTitle() !== null ? $object->getTitle() : '';

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof MemberImages;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MemberImages::class => true,
        ];
    }
}