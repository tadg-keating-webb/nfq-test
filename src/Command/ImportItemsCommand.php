<?php 

namespace App\Command;

use App\Service\ItemManagerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use WolfShop\Item;

#[AsCommand(name: 'app:import-items')]
class ImportItemsCommand extends Command
{
    const DEFAULT_SELL_IN = 10;
    const DEFAULT_QUALITY = 10;

    public function __construct(
        private HttpClientInterface $client, 
        private ItemManagerService $itemManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $response = $this->client->request('GET', 'https://api.restful-api.dev/objects');
            $itemsData = $response->toArray();
        
            foreach ($itemsData as $itemData) {
                // Create an Item instance from the API data
                $item = new Item(
                    $itemData['name'],
                    self::DEFAULT_SELL_IN,
                    self::DEFAULT_QUALITY
                );

                $this->itemManager->updateItem($item);
                
                $output->writeln((string)$item);
            }
        } catch (TransportExceptionInterface $e) {
            $output->writeln('Error fetching items: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Items imported successfully.');

        return Command::SUCCESS;
    }
}
