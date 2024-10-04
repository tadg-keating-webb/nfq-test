<?php

namespace App\Tests\Service\Item;

use App\Service\Item\ConjuredItemUpdater;
use PHPUnit\Framework\TestCase;
use WolfShop\Item;

class ConjuredItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item('Conjured Item', 10, 20);
        $updater = new ConjuredItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(18, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item('Conjured Item', -1, 20);
        $updater = new ConjuredItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(16, $updatedItem->quality);
        $this->assertEquals(-1, $updatedItem->sellIn);
    }

    public function testUpdateQualityNeverNegative()
    {
        $item = new Item('Conjured Item', 10, 1);
        $updater = new ConjuredItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }

    public function testUpdateQualityNeverAbove50()
    {
        $item = new Item('Conjured Item', 10, 50);
        $updater = new ConjuredItemUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(48, $updatedItem->quality);
        $this->assertEquals(10, $updatedItem->sellIn);
    }
}
