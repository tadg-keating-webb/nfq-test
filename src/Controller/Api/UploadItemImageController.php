<?php 

namespace App\Controller\Api;

use App\Repository\ItemRepository;
use App\Service\ImageUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadItemImageController extends AbstractController
{
    public function __construct( 
        private EntityManagerInterface $entityManager,
        private ItemRepository $itemRepository,
        private ImageUploadService $imageUploadService,
    ) {
    }

    #[Route('/api/upload-item-image/{id}', methods: ['POST'])]
    public function __invoke(int $id, Request $request): Response
    {
        $item = $this->itemRepository->find($id);

        if (!$item) {
            throw $this->createNotFoundException('Item not found');
        }
        
        $data = json_decode($request->getContent(), true);

        if (!isset($data['image'])) {
            return new Response('No image provided', Response::HTTP_BAD_REQUEST);
        }

        $base64Image = $data['image'];
        $imageData = base64_decode($base64Image);
    
        $publicDir = $this->getParameter('kernel.project_dir') . '/public';

        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0777, true);
        }

        $imageName = uniqid() . '.png';
        $imagePath = $publicDir . '/' . $imageName;

        file_put_contents($imagePath, $imageData);

        if (!$imageUrl = $this->imageUploadService->uploadImage($imagePath)) {
            return new Response('Invalid base64 image', Response::HTTP_BAD_REQUEST);    
        }

        $item->setImageUrl($imageUrl);

        $this->entityManager->flush();

        return $this->json([
            'id' => $item->getId(),
            'name' => $item->getName(),
            'sellIn' => $item->getSellIn(),
            'quality' => $item->getQuality(),
            'imageUrl' => $item->getImageUrl(),
        ]);
    }
}
