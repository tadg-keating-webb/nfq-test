<?php

namespace App\Tests\Service\Item;

use App\Service\Item\AppleIpadAirUpdater;
use PHPUnit\Framework\TestCase;
use WolfShop\Item;

class AppleIpadAirUpdaterTest extends TestCase
{
    public function testUpdateQualityConcertOver()
    {
        $item = new Item('Apple iPad Air', -1, 10);
        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(0, $updatedItem->quality);
    }

    public function testUpdateQualitySellInLessThanOrEqualTo5()
    {
        $item = new Item('Apple iPad Air', 5, 10);
        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(13, $updatedItem->quality);
    }

    public function testUpdateQualitySellInLessThanOrEqualTo10()
    {
        $item = new Item('Apple iPad Air', 10, 10);
        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(12, $updatedItem->quality);
    }

    public function testUpdateQualitySellInGreaterThan10()
    {
        $item = new Item('Apple iPad Air', 11, 10);
        $updater = new AppleIpadAirUpdater();

        $updatedItem = $updater->updateQuality($item);

        $this->assertEquals(11, $updatedItem->quality);
    }
}
