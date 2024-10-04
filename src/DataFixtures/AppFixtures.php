<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $items = [
            ['name' => 'Apple AirPods', 'sellIn' => 10, 'quality' => 20],
            ['name' => 'Samsung Galaxy S23', 'sellIn' => 5, 'quality' => 80],
            ['name' => 'Apple iPad Air', 'sellIn' => 15, 'quality' => 25],
            ['name' => 'Xiaomi Redmi Note 13', 'sellIn' => 7, 'quality' => 18],
            ['name' => 'Nokia 3310', 'sellIn' => 20, 'quality' => 50],
        ];

        foreach ($items as $itemData) {
            $item = new Item();
            $item->setName($itemData['name']);
            $item->setSellIn($itemData['sellIn']);
            $item->setQuality($itemData['quality']);
            $manager->persist($item);
        }

        $manager->flush();
    }
}