<?php

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use WolfShop\Item;

#[AutoconfigureTag('app.updater')]
abstract class AbstractItemUpdater
{   
    abstract public function handle(Item $item);
    
    abstract public function updateQuality(Item $item): Item;
    
    protected function decreaseSellIn(Item $item): Item
    {
        $item->sellIn--;
        
        return $item;
    }

    protected function changeQuality(Item $item, Int $amount): Item
    {
        $item->quality = max(0, min(50, $item->quality + $amount));
        
        return $item;
    }
}
