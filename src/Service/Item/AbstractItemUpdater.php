<?php

namespace App\Service\Item;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.updater')]
abstract class AbstractItemUpdater
{   
    abstract public function handle(Item $item);
    
    abstract public function updateQuality(Item $item): Item;
    
    protected function decreaseSellIn(Item $item): Item
    {
        $item->setSellIn($item->getSellIn() - 1);
        
        return $item;
    }

    protected function changeQuality(Item $item, Int $amount): Item
    {
        $item->setQuality(max(0, min(50, $item->getQuality() + $amount)));
        
        return $item;
    }
}
