<?php 

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use WolfShop\Item;

#[AsTaggedItem(index: 'IMPROVING')]
class ImprovingItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): void
    {

    }

    public function updateQuality(Item $item): Item
    {
        $amount = $item->sellIn < 0 ? 2 : 1;
        
        $this->changeQuality($item, $amount);

        return $item;
    }
}
