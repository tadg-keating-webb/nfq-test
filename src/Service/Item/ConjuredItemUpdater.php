<?php 

namespace App\Service\Item;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'CONJURED')]
class ConjuredItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): Item
    {
        $item = $this->decreaseSellIn($item);
        return $this->updateQuality($item);
    }

    public function updateQuality(Item $item): Item
    {
        $amount = $item->getSellIn() < 0 ? -4 : -2;
        
        $this->changeQuality($item, $amount);

        return $item;
    }
}
