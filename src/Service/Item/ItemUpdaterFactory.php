<?php

namespace App\Service\Item;

use App\Enum\ItemEnum;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ItemUpdaterFactory
{   
    public function __construct(
        #[AutowireIterator('app.updater', indexAttribute: 'key')]
        private iterable $updaters,
    ) {
    }

    public function create(string $itemName): AbstractItemUpdater
    {
        $handlers = $this->updaters instanceof \Traversable ? iterator_to_array($this->updaters) : $this->updaters;

        $itemName = ItemEnum::tryFrom($itemName);
            
        if ($itemName === null) {
            $itemName = ItemEnum::NORMAL;
        }
        
        return $handlers[$itemName->name];
    }
}
