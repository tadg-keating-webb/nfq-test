<?php

namespace App\Service\Item;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'APPLE_IPAD_AIR')]
class AppleIpadAirUpdater extends AbstractItemUpdater {
    
    public function handle(Item $item): Item
    {
        $item = $this->decreaseSellIn($item);
        return $this->updateQuality($item);
    }
    
    public function updateQuality(Item $item): Item
    {
        if ($item->getSellIn() < 0) {
            $item->setQuality(0);
            return $item;
        } 

        if ($item->getSellIn() <= 5) {
            $amount = 3;
        } else if ($item->getSellIn() <= 10) {
            $amount = 2;
        } else {
            $amount = 1;
        }

        return $this->changeQuality($item, $amount);
    }
}
