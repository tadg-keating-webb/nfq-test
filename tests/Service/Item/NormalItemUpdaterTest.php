<?php

namespace App\Tests\Service\Item;

use App\Service\Item\NormalItemUpdater;
use PHPUnit\Framework\TestCase;
use WolfShop\Item;

class NormalItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item('Normal Item', 10, 20);
        $updater = new NormalItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(19, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item('Normal Item', -1, 20);
        $updater = new NormalItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(18, $updatedItem->quality);
        $this->assertEquals(-1, $updatedItem->sellIn);
    }

    public function testUpdateQualityQualityNeverNegative()
    {
        $item = new Item('Normal Item', 10, 0);
        $updater = new NormalItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualityQualityNeverAbove50()
    {
        $item = new Item('Normal Item', 10, 50);
        $updater = new NormalItemUpdater($item);

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(49, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }
}