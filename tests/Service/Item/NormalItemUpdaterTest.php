<?php

namespace App\Tests\Service\Item;

use App\Entity\Item; // Ensure this is the correct namespace for your Item entity
use App\Service\Item\NormalItemUpdater;
use PHPUnit\Framework\TestCase;

class NormalItemUpdaterTest extends TestCase
{
    public function testUpdateQualitySellInGreaterThan0()
    {
        $item = new Item();
        $item->setName('Normal Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        $updater = new NormalItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(19, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualitySellInLessThan0()
    {
        $item = new Item();
        $item->setName('Normal Item');
        $item->setSellIn(-1);
        $item->setQuality(20);

        $updater = new NormalItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(18, $updatedItem->getQuality());
        $this->assertEquals(-1, $updatedItem->getSellIn());
    }

    public function testUpdateQualityQualityNeverNegative()
    {
        $item = new Item();
        $item->setName('Normal Item');
        $item->setSellIn(10);
        $item->setQuality(0);

        $updater = new NormalItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }

    public function testUpdateQualityQualityNeverAbove50()
    {
        $item = new Item();
        $item->setName('Normal Item');
        $item->setSellIn(10);
        $item->setQuality(50);

        $updater = new NormalItemUpdater();
        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(49, $updatedItem->getQuality());
        $this->assertEquals(10, $updatedItem->getSellIn());
    }
}
