<?php

namespace App\Twig\Components;

use App\Entity\Address;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveResponder;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent]
final class NewClientForm
{
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $nom = '';

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $prenom = '';

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $nationaleId = '';

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $addressLine1 = '';

    #[LiveProp(writable: true)]
    public ?string $addressLine2 = null;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $city = '';

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $country = 'France';

    #[LiveProp(writable: true)]
    public ?string $additionalInfo = null;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $postalCode = '13';

    #[LiveAction]
    public function saveClient(EntityManagerInterface $entityManager, LiveResponder $liveResponder): void
    {
        $this->validate();

        $client = new Client();
        $client->setNom($this->nom);
        $client->setPrenom($this->prenom);
        $client->setNationaleId($this->nationaleId);
        $client->setAddress(
            (new Address())
                ->setAddressLine1($this->addressLine1)
                ->setAddressLine2($this->addressLine2)
                ->setCity($this->city)
                ->setCountry($this->country)
                ->setAdditionalInfo($this->additionalInfo)
                ->setPostalCode($this->postalCode)
        );

        $entityManager->persist($client);
        $entityManager->flush();

        $this->dispatchBrowserEvent('modal:close');
        $this->emit('client:created', [
            'client' => $client->getId(),
        ]);

        $this->resetFields();
        $this->resetValidation();
    }

    public function resetFields(): void
    {
        $this->nom = '';
        $this->prenom = '';
        $this->nationaleId = '';
        $this->addressLine1 = '';
        $this->addressLine2 = null;
        $this->city = '';
        $this->country = 'France';
        $this->additionalInfo = null;
        $this->postalCode = '13';
    }
}
