<?php

namespace App\Tests\Service\Item;

use App\Entity\Item;
use App\Service\Item\AppleIpadAirUpdater;
use PHPUnit\Framework\TestCase;

class AppleIpadAirUpdaterTest extends TestCase
{
    public function testUpdateQualityConcertOver()
    {
        $item = new Item();
        $item->setName('Apple iPad Air');
        $item->setSellIn(-1);
        $item->setQuality(10);

        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->getQuality());
    }

    public function testUpdateQualitySellInLessThanOrEqualTo5()
    {
        $item = new Item();
        $item->setName('Apple iPad Air');
        $item->setSellIn(5);
        $item->setQuality(10);

        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(13, $updatedItem->getQuality());
    }

    public function testUpdateQualitySellInLessThanOrEqualTo10()
    {
        $item = new Item();
        $item->setName('Apple iPad Air');
        $item->setSellIn(10);
        $item->setQuality(10);

        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(12, $updatedItem->getQuality());
    }

    public function testUpdateQualitySellInGreaterThan10()
    {
        $item = new Item();
        $item->setName('Apple iPad Air');
        $item->setSellIn(11);
        $item->setQuality(10);

        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(11, $updatedItem->getQuality());
    }
}
