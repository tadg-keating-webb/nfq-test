<?php

namespace App\Tests\Service\Item;

use App\Entity\Item;
use App\Service\Item\ImprovingItemUpdater;
use PHPUnit\Framework\TestCase;

class ImprovingItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item();
        $item->setName('Improving Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        $updater = new ImprovingItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(21, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item();
        $item->setName('Improving Item');
        $item->setSellIn(-1);
        $item->setQuality(20);

        $updater = new ImprovingItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(22, $updatedItem->getQuality());
        $this->assertEquals(-1, $updatedItem->getSellIn());
    }

    public function testUpdateQualityQualityNeverAbove50()
    {
        $item = new Item();
        $item->setName('Improving Item');
        $item->setSellIn(10);
        $item->setQuality(50);

        $updater = new ImprovingItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(50, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }
}
