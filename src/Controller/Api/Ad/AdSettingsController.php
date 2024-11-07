<?php

namespace App\Controller\Api\Ad;

use App\Repository\AdSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AdSettingsController extends AbstractController
{
    public function __construct(private readonly AdSettingRepository $adSettingRepository)
    {}

    /**
     * @throws \Exception
     */
    public function __invoke(): JsonResponse
    {

        $adSettings = $this->adSettingRepository->findAll();

        if (!$adSettings) {
            throw $this->createNotFoundException('AdSettings not found');
        }

        return $this->json($adSettings, 200, [], ['groups' => 'ads:read']);
    }
}