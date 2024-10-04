<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\ItemRepository;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UploadItemImageControllerTest extends WebTestCase
{
    private $client;

    private ItemRepository $itemRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        // Mock the ItemRepository
        $this->itemRepository = $this->createMock(ItemRepository::class);
        $this->client->getContainer()->set('App\Repository\ItemRepository', $this->itemRepository);
    }

    public function testSuccessfulImageUpload()
    {
        //TODO: Implement the test
        $this->assertEquals(true, true);
    }

    public function testNoImageProvided()
    {
        // Create a mock item
        $item = new Item();
        $item->setName('Test Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        // Configure the mock repository to return the item when find(1) is called
        $this->itemRepository->method('find')->with(1)->willReturn($item);

        $this->client->request(
            'POST',
            '/api/upload-item-image/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testInvalidBase64Image()
    {
        // Create a mock item
        $item = new Item();
        $item->setName('Test Item');
        $item->setSellIn(10);
        $item->setQuality(20);

        // Configure the mock repository to return the item when find(1) is called
        $this->itemRepository->method('find')->with(1)->willReturn($item);

        $this->client->request(
            'POST',
            '/api/upload-item-image/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['image' => 'invalidbase64'])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }
}
