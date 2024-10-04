<?php

namespace App\Tests\Service\Item;

use App\Service\Item\ImprovingItemUpdater;
use PHPUnit\Framework\TestCase;
use WolfShop\Item;

class ImprovingItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item('Improving Item', 10, 20);
        $updater = new ImprovingItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(21, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item('Improving Item', -1, 20);
        $updater = new ImprovingItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(22, $updatedItem->quality);
        $this->assertEquals(-1, $updatedItem->sellIn);
    }

    public function testUpdateQualityQualityNeverAbove50()
    {
        $item = new Item('Improving Item', 10, 50);
        $updater = new ImprovingItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(50, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }
}
