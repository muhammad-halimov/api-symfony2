<?php

namespace App\Controller\Api\History;

use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ControllerHistory extends AbstractController
{
    public function __construct(private readonly HistoryRepository $historyRepository)
    {}

    /**
     * @throws \Exception
     */
    public function __invoke(): JsonResponse
    {

        $history = $this->historyRepository->findBy(['type' => 'History']);

        if (!$history) {
            throw $this->createNotFoundException('History type not found');
        }

        return $this->json($history, 200, [], ['groups' => 'history:read']);
    }
}