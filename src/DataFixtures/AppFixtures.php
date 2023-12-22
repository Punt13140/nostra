<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Client;
use App\Entity\ObjectType;
use App\Entity\Order;
use App\Entity\WeightDetail;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $occas = new ObjectType('Objets d\'occasion achetés à des particuliers');
        $fabricants = new ObjectType('Objets achetés aux fabricants');
        $others = new ObjectType('Autres achats');
        $tiers = new ObjectType('Objets confiés par des tiers');
        $manager->persist($occas);
        $manager->persist($fabricants);
        $manager->persist($others);
        $manager->persist($tiers);

        for ($i = 0; $i < 20; $i++) {
            $client = new Client();
            $client->setNom($faker->lastName);
            $client->setPrenom($faker->firstName);
            $client->setNationaleId($faker->uuid);

            $address = new Address();
            $address->setAddressLine1($faker->streetAddress);
            $address->setCity($faker->city);
            $address->setCountry('France');
            $address->setPostalCode($faker->postcode);
            $client->setAddress($address);

            $manager->persist($client);

            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                $order = new Order();
                $order->setOrderedBy($client);
                $order->setOrderedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));
                $order->setDesignation('Boucle + bague + ...');
                $order->setItemCount($faker->numberBetween(1, 10));

                $detail = new WeightDetail();
                $detail->setType($occas);
                $detail->setGold($faker->numberBetween(1, 150));
                $detail->setSilver($faker->numberBetween(1, 100));

                $order->addWeightDetail($detail);

                $manager->persist($order);
            }
        }

        $manager->flush();
    }
}
