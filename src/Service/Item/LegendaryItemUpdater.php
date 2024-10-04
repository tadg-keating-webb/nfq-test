<?php 

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use WolfShop\Item;

// #[AsTaggedItem(index: 'LEGENDARY')]
#[AsTaggedItem(index: 'APPLE_IPAD_AIR')]
class LegendaryItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): void
    {

    }

    public function updateQuality(Item $item): Item
    {
        $item->quality = 80;
        return $item;
    }
}
