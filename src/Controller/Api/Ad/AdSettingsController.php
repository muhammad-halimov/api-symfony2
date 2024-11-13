<?php

namespace App\Controller\Api\Ad;

use App\Repository\AdSettingRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AdSettingsController extends AbstractController
{
    public function __construct(private readonly AdSettingRepository $adSettingRepository)
    {}

    /**
     * @throws Exception
     */
    public function __invoke(): JsonResponse
    {
        // Получаем все настройки рекламы
        $adSettings = $this->adSettingRepository->findAll();

        // Проверяем, найдены ли настройки
        if (!$adSettings) {
            throw $this->createNotFoundException('AdSettings not found');
        }

        // Сортируем настройки по полю showOrder
        usort($adSettings, function($a, $b) {
            return $a->getShowOrder() <=> $b->getShowOrder(); // Используем оператор "космического корабля"
        });

        // Возвращаем настройки в формате JSON
        return $this->json($adSettings, 200, [], ['groups' => 'ads:read']);
    }
}
