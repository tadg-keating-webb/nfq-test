<?php

namespace App\Service\Item;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use WolfShop\Item;

#[AutoconfigureTag('app.updater')]
abstract class AbstractItemUpdater
{
    public function __construct(protected Item $item)
    {
    }
}