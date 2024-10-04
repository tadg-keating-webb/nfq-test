<?php 

namespace App\Service\Item;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'IMPROVING')]
class ImprovingItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): Item
    {
        $item = $this->decreaseSellIn($item);

        return $this->updateQuality($item);
    }

    public function updateQuality(Item $item): Item
    {
        $amount = $item->getSellIn() < 0 ? 2 : 1;
        
        $this->changeQuality($item, $amount);

        return $item;
    }
}
