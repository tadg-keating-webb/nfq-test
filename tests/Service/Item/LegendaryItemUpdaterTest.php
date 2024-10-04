<?php

namespace App\Tests\Service\Item;

use App\Service\Item\LegendaryItemUpdater;
use PHPUnit\Framework\TestCase;
use WolfShop\Item;

class LegendaryItemUpdaterTest extends TestCase
{
    public function testUpdateQuality()
    {
        $item = new Item('Legendary Item', 10, 20);
        $updater = new LegendaryItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(80, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualityQualityAlways80()
    {
        $item = new Item('Legendary Item', -1, 50);
        $updater = new LegendaryItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(80, $updatedItem->quality);
        $this->assertEquals(-1, $updatedItem->sellIn);
    }
}
