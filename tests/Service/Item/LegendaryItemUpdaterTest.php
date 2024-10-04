<?php

namespace App\Tests\Service\Item;

use App\Entity\Item;
use App\Service\Item\LegendaryItemUpdater;
use PHPUnit\Framework\TestCase;

class LegendaryItemUpdaterTest extends TestCase
{
    public function testUpdateQuality()
    {
        $item = new Item();
        $item->setName('Legendary Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        $updater = new LegendaryItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(80, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualityQualityAlways80()
    {
        $item = new Item();
        $item->setName('Legendary Item');
        $item->setSellIn(-1);
        $item->setQuality(50);

        $updater = new LegendaryItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(80, $updatedItem->getQuality());
        $this->assertEquals(-1, $updatedItem->getSellIn());
    }
}
