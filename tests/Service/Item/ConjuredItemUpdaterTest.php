<?php

namespace App\Tests\Service\Item;

use App\Entity\Item;
use App\Service\Item\ConjuredItemUpdater;
use PHPUnit\Framework\TestCase;

class ConjuredItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item();
        $item->setName('Conjured Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        $updater = new ConjuredItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(18, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item();
        $item->setName('Conjured Item');
        $item->setSellIn(-1);
        $item->setQuality(20);

        $updater = new ConjuredItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(16, $updatedItem->getQuality());
        $this->assertEquals(-1, $updatedItem->getSellIn());
    }

    public function testUpdateQualityNeverNegative()
    {
        $item = new Item();
        $item->setName('Conjured Item');
        $item->setSellIn(10);
        $item->setQuality(1);

        $updater = new ConjuredItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualityNeverAbove50()
    {
        $item = new Item();
        $item->setName('Conjured Item');
        $item->setSellIn(10);
        $item->setQuality(50);

        $updater = new ConjuredItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(48, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }
}
