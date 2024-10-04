<?php 

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use WolfShop\Item;

#[AsTaggedItem(index: 'CONJURED')]
class ConjuredItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): void
    {

    }

    public function updateQuality(Item $item): Item
    {
        // Todo: Implement the updateQuality method
        return $item;
    }
}
