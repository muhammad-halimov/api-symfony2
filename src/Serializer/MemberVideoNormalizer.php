<?php

namespace App\Serializer;

use App\Entity\MemberVideo;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

readonly class MemberVideoNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private StorageInterface    $storage
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /* @var MemberVideo $object */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['video'] = $this->storage->resolveUri($object, 'videoFile');
        $data['title'] = $object->getTitle() !== null ? $object->getTitle() : '';

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof MemberVideo;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MemberVideo::class => true,
        ];
    }
}