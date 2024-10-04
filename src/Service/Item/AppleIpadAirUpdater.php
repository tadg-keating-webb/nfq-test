<?php

namespace App\Service\Item;

use WolfShop\Item;

class AppleIpadAirUpdater extends AbstractItemUpdater {
    
    public function handle(Item $item): void
    {

    }
    
    public function updateQuality(Item $item): Item
    {
        if ($item->sellIn < 0) {
            $item->quality = 0; // Concert is over
            return $item;
        } 

        if ($item->sellIn <= 5) {
            $amount = 3;
        } else if ($item->sellIn <= 10) {
            $amount = 2;
        } else {
            $amount = 1;
        }

        return $this->changeQuality($item, $amount);
    }
}