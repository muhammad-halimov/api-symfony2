<?php

namespace App\Controller\Api\Member;

use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ControllerHeroes extends AbstractController
{
    public function __construct(private readonly MemberRepository $memberRepository)
    {}

    /**
     * @throws \Exception
     */
    public function __invoke(): JsonResponse
    {

        $members = $this->memberRepository->findBy(['type' => 'Heroes']);

        if (!$members) {
            throw $this->createNotFoundException('Members type not found');
        }

        return $this->json($members, 200, [], ['groups' => 'member:read']);
    }
}