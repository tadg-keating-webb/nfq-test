<?php 

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use WolfShop\Item;

#[AsTaggedItem(index: 'NORMAL')]
class NormalItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): void
    {   
        // dd($this->item);
    }

    public function updateQuality(Item $item): Item
    {
        $amount = $item->sellIn < 0 ? -2 : -1;
        return $this->changeQuality($item, $amount);
    }
}
