<?php

namespace App\Controller\Api\Tenant;

use App\Repository\TenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Contracts\Service\Attribute\Required;

#[AsController]
class TenantController extends AbstractController
{
    #[Required]
    public TenantRepository $tenantRepository;


    public function __invoke(#[MapQueryParameter] ?string $word): JsonResponse
    {
        $renters = $this->tenantRepository->findBy(['title' => $word]);

        if (!$renters) {
            throw $this->createNotFoundException('Tenants not found');
        }

        return $this->json($renters, 200, [], ['groups' => 'tenant:read']);
    }
}