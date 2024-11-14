<?php

namespace App\Controller\Api\Ad;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Contracts\Service\Attribute\Required;

#[AsController]

class AdSettingsController extends AbstractController
{
    #[Required]
    public AdRepository $adRepository;


    public function __invoke(): JsonResponse
    {
        $advertisements = new ArrayCollection($this->adRepository->findAll());
        $properties = new ArrayCollection();

        if ($advertisements->isEmpty())
            throw $this->createNotFoundException('Adsettings not found');


        for ($i = 0; $i < $advertisements->count(); $i++) {
            $propertiesInAdvertisement = $advertisements->get($i)->getOptions();

            for ($j = 0; $j < $propertiesInAdvertisement->count(); $j++)
                $properties->add($propertiesInAdvertisement->get($j));
        }

        $properties = $properties->toArray();

        usort($properties, function($item1, $item2) {
            return $item1->getShowOrder() <=> $item2->getShowOrder();
        });

        return $this->json($properties, 200, [], ['groups' => 'ads:read']);
    }
}