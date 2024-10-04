<?php

namespace App\Service;

use Cloudinary\Api\Exception\BadRequest;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class ImageUploadService
{
    public function uploadImage(string $imagePath): bool|string
    {
        Configuration::instance('CLOUDINARY_URL=cloudinary://647836991622118:lpYs6mUAthjpT1VyhI01mrVRw-g@dg0kreplt');
        
        $upload = new UploadApi();

        try {
            $response = $upload->upload($imagePath, [
                'public_id' => 'sample',
                'use_filename' => true,
                'overwrite' => true]
            );
        } catch (BadRequest $e) {
            return false;
        }

        return $response->offsetGet('url');
    }
}