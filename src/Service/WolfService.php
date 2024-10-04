<?php 

namespace App\Service;

use App\Repository\ItemRepository;
use App\Service\Item\ItemUpdaterFactory;
use Doctrine\ORM\EntityManagerInterface;

class WolfService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ItemRepository $itemRepository,
        private ItemUpdaterFactory $itemUpdaterFactory,
    ) {
    }

    public function updateItems()
    {
        $items = $this->itemRepository->findAll();
        
        foreach ($items as $item) {
            $updater = $this->itemUpdaterFactory->create($item->getName());

            $item = $updater->handle($item);
        }

        $this->entityManager->flush();
    }
}
