<?php

namespace App\Service;

use App\Entity\Item;
use App\Service\Item\ItemUpdaterFactory;
use Doctrine\ORM\EntityManagerInterface;
use WolfShop\Item as WolfShopItem;

class ItemManagerService
{
    public function __construct(
        private ItemUpdaterFactory $itemUpdaterFactory, 
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function updateItem(WolfShopItem $item): void
    {
        $existingItem = $this->findItemByName($item->name);

        if ($existingItem) {
            $updater = $this->itemUpdaterFactory->create($item->name);

            $item = $updater->updateQuality($item);

            $existingItem->setQuality($item->quality);
        } else {
            $newItemEntity = new Item();
            $newItemEntity->setName($item->name);
            $newItemEntity->setSellIn($item->sellIn);
            $newItemEntity->setQuality($item->quality);

            $this->entityManager->persist($newItemEntity);
        }

        $this->entityManager->flush();
    }

    private function findItemByName(string $name): ?Item
    {
        return $this->entityManager->getRepository(Item::class)->findOneBy(['name' => $name]);
    }
}
