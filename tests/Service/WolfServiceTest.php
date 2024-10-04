<?php

namespace App\Tests\Service;

use App\DataFixtures\AppFixtures;
use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Service\Item\AppleIpadAirUpdater;
use App\Service\Item\ConjuredItemUpdater;
use App\Service\Item\ImprovingItemUpdater;
use App\Service\Item\ItemUpdaterFactory;
use App\Service\Item\LegendaryItemUpdater;
use App\Service\Item\NormalItemUpdater;
use App\Service\WolfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WolfServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ItemRepository $itemRepository;
    private ItemUpdaterFactory $itemUpdaterFactory;
    private WolfService $wolfService;
        
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // Create schema
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
        
        // Load fixtures
        $fixture = new AppFixtures();
        $fixture->load($this->entityManager);

        $this->itemRepository = $this->entityManager->getRepository(Item::class);

        // Create the actual updaters
        $updaters = [
            'LEGENDARY' => new LegendaryItemUpdater(),
            'NORMAL' => new NormalItemUpdater(),
            'IMPROVING' => new ImprovingItemUpdater(),
            'APPLE_IPAD_AIR' => new AppleIpadAirUpdater(),
            'CONJURED' => new ConjuredItemUpdater(),
        ];

        // Create the actual factory
        $this->itemUpdaterFactory = new ItemUpdaterFactory($updaters);

        // Inject the mocks and the actual factory into the WolfService
        $this->wolfService = new WolfService($this->entityManager, $this->itemRepository, $this->itemUpdaterFactory);
    }

    public function testLegendaryItemUpdate()
    {
        // Fetch the legendary item before update
        $legendaryItem = $this->itemRepository->findOneBy(['name' => 'Samsung Galaxy S23']);
        $initialQuality = $legendaryItem->getQuality();
        $initialSellIn = $legendaryItem->getSellIn();

        // Perform the update
        $this->wolfService->updateItems();

        // Fetch the legendary item after update
        $updatedLegendaryItem = $this->itemRepository->findOneBy(['name' => 'Samsung Galaxy S23']);

        // Assert that the legendary item's quality and sellIn remain unchanged
        $this->assertEquals($initialQuality, $updatedLegendaryItem->getQuality());
        $this->assertEquals($initialSellIn, $updatedLegendaryItem->getSellIn());
    }

    public function testNormalItemUpdate()
    {
        // Fetch the normal item before update
        $normalItem = $this->itemRepository->findOneBy(['name' => 'Nokia 3310']);
        if (!$normalItem) {
            throw new \Exception('Normal item not found in the database.');
        }
        $initialQuality = $normalItem->getQuality();
        $initialSellIn = $normalItem->getSellIn();

        // Perform the update
        $this->wolfService->updateItems();

        // Fetch the normal item after update
        $updatedNormalItem = $this->itemRepository->findOneBy(['name' => 'Nokia 3310']);

        // Assert that the normal item's quality and sellIn are updated correctly
        $expectedQuality = $initialSellIn > 0 ? $initialQuality - 1 : $initialQuality - 2;
        $this->assertEquals($expectedQuality, $updatedNormalItem->getQuality());
        $this->assertEquals($initialSellIn - 1, $updatedNormalItem->getSellIn());
    }

    public function testImprovingItem()
    {
        // Fetch the improving item before update
        $improvingItem = $this->itemRepository->findOneBy(['name' => 'Apple AirPods']);
        if (!$improvingItem) {
            throw new \Exception('Improving item not found in the database.');
        }
        $initialQuality = $improvingItem->getQuality();
        $initialSellIn = $improvingItem->getSellIn();

        // Perform the update
        $this->wolfService->updateItems();

        // Fetch the improving item after update
        $updatedImprovingItem = $this->itemRepository->findOneBy(['name' => 'Apple AirPods']);

        // Assert that the improving item's quality and sellIn are updated correctly
        $expectedQuality = $initialSellIn > 0 ? $initialQuality + 1 : $initialQuality + 2;
        $this->assertEquals($expectedQuality, $updatedImprovingItem->getQuality());
        $this->assertEquals($initialSellIn - 1, $updatedImprovingItem->getSellIn());  
    }

    public function testConjuredItemUpdate()
    {
        // Fetch the conjured item before update
        $conjuredItem = $this->itemRepository->findOneBy(['name' => 'Xiaomi Redmi Note 13']);
        
        if (!$conjuredItem) {
            throw new \Exception('Conjured item not found in the database.');
        }
        
        $initialQuality = $conjuredItem->getQuality();
        $initialSellIn = $conjuredItem->getSellIn();

        // Perform the update
        $this->wolfService->updateItems();

        // Fetch the conjured item after update
        $updatedConjuredItem = $this->itemRepository->findOneBy(['name' => 'Xiaomi Redmi Note 13']);

        // Assert that the conjured item's quality and sellIn are updated correctly
        $expectedQuality = $initialSellIn > 0 ? $initialQuality - 2 : $initialQuality - 4;
        $this->assertEquals($expectedQuality, $updatedConjuredItem->getQuality());
        $this->assertEquals($initialSellIn - 1, $updatedConjuredItem->getSellIn());
    }

    public function testIpadProItemUpdate()
    {
        // Fetch the Apple iPad Air item before update
        $ipadAirItem = $this->itemRepository->findOneBy(['name' => 'Apple iPad Air']);
        if (!$ipadAirItem) {
            throw new \Exception('Apple iPad Air item not found in the database.');
        }
        $initialQuality = $ipadAirItem->getQuality();
        $initialSellIn = $ipadAirItem->getSellIn();

        // Perform the update
        $this->wolfService->updateItems();

        // Fetch the Apple iPad Air item after update
        $updatedIpadAirItem = $this->itemRepository->findOneBy(['name' => 'Apple iPad Air']);

        // Assert that the Apple iPad Air item's quality and sellIn are updated correctly
        $expectedQuality = $initialSellIn > 0 ? $initialQuality + 1 : $initialQuality + 2;
        $this->assertEquals($expectedQuality, $updatedIpadAirItem->getQuality());
        $this->assertEquals($initialSellIn - 1, $updatedIpadAirItem->getSellIn());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Restore exception handler to suppress warnings
        restore_exception_handler();

        // Optionally, clear the entity manager to avoid memory leaks between tests
        if ($this->entityManager) {
            $this->entityManager->close();
        }
    }
}
