# Symfony 7.2 Application

This project is built using **Symfony 7.2** and is containerized with **Docker**. Follow the instructions below to set up the environment and get the application running.

## Prerequisites

Make sure you have the following installed on your machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

### 1. Clone the Repository

```bash
git clone git@github.com:tadg-keating-webb/nfq-test.git
```

```bash
cd nfq-test
```
### 2. Start the Application

Use Docker Compose to build and start the containers by running the following command:

```bash
docker-compose up -d
```
This will start the containers in detached mode, setting up the following services:

Nginx: The application will be accessible at http://localhost or http://0.0.0.0

PHP-FPM: Symfony will run with PHP 8.1+

MySQL: Database for the application

## 3. Install Dependencies
Once the containers are up and running, you need to install the Symfony dependencies. You can do this by running the following command:

```bash
docker compose exec app composer install
```

## 4. Run Migrations

```bash
docker compose exec app bin/console doctrine:migrations:migrate
```

## Testing
Run the following commands to execute tests using PHPUnit:
```bash
docker-compose exec app php bin/phpunit
```

## Importing Items
```bash
docker-compose exec php php bin/console app:import-items
```

## API Endpoint

### Upload Item Image

This endpoint allows you to upload an image to Cloudify for a specific item and updates its image Url.

**URL**: `/api/upload-item-image/{id}`

**Method**: `POST`

**URL Parameters**:
- `id` (integer): The ID of the item for which the image is being uploaded.

**Request Body**:
- `image` (string): The base64-encoded image data.

**Headers**:
- `Content-Type: application/json`

### Example Request

```bash
curl -X POST "http://0.0.0.0/api/upload-item-image/1" \
     -H "Content-Type: application/json" \
     -d '{
           "image": "iVBORw0KGgoAAAANSUhEUgAA..."
         }'
 ```

 ### Example Response
 ```bash
 {
    "id": 12,
    "name": "Google Pixel 6 Pro",
    "sellIn": 10,
    "quality": 5,
    "imageUrl": "http://res.cloudinary.com/dg0kreplt/image/upload/v1728042748/sample.jpg"
}        
 ```
