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

    public function updateItem(WolfShopItem $item): WolfShopItem
    {
        $existingItem = $this->findItemByName($item->name);

        if ($existingItem) {
            $updater = $this->itemUpdaterFactory->create($item->name);

            $existingItem = $updater->updateQuality($existingItem);

            // We just use the item as a container for the updated values
            $item->quality = $existingItem->getQuality();
            $item->sellIn = $existingItem->getSellIn();
        } else {
            $newItemEntity = new Item();
            $newItemEntity->setName($item->name);
            $newItemEntity->setSellIn($item->sellIn);
            $newItemEntity->setQuality($item->quality);

            $this->entityManager->persist($newItemEntity);

            // We just use the item as a container for the updated values
            $item->quality = $newItemEntity->getQuality();
            $item->sellIn = $newItemEntity->getSellIn();
        }

        $this->entityManager->flush();

        return $item;
    }

    private function findItemByName(string $name): ?Item
    {
        return $this->entityManager->getRepository(Item::class)->findOneBy(['name' => $name]);
    }
}
