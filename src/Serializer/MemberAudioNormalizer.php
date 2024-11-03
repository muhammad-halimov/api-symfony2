<?php

namespace App\Serializer;

use App\Entity\MemberAudio;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

readonly class MemberAudioNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private StorageInterface    $storage
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /* @var MemberAudio $object */
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['audio'] = $this->storage->resolveUri($object, 'audioFile');
        $data['title'] = $object->getTitle() !== null ? $object->getTitle() : '';

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof MemberAudio;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MemberAudio::class => true,
        ];
    }
}