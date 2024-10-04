<?php 

namespace App\Service\Item;

use App\Entity\Item as Item;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'LEGENDARY')]
class LegendaryItemUpdater extends AbstractItemUpdater
{
    public function handle(Item $item): Item
    {
        return $this->updateQuality($item);   
    }

    public function updateQuality(Item $item): Item
    {
        $item->setQuality(80);

        return $item;
    }
}
