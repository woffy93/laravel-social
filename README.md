# Social
A simple Laravel app that emulates a social network.
Every User can publish Links composed by title, url and # separated tags (optional).
Users can like links and can follow other users

## Tech Stack
- Laravel 10
- PHP 8.1
- Postgre
- Docker


## About

The app is a standard Laravel MVC with Blade templates + an API that works independently

### API Endpoints

#### Login
- **Method:** POST
- **Endpoint:** `/api/login`
- **Description:** Allows users to log in and obtain an access token.
- **Parameters:**
    - `email` (string, required): The email of the user to be followed.
- **Example Usage:**
  ```bash
  curl -X POST http://localhost:8000/api/follow \
     -H "Authorization: Bearer your_generated_token_here" \
     -H "Content-Type: application/json" \
     -d '{"email": "targetuser@example.com"}'
  
#### Follow
- **Method:** POST
- **Endpoint:** `/api/follow`
- **Description:** allows the authenticated user to follow another user by providing the target's email
- **Parameters:**
    - `email` (string, required): Email of the user to be followed.
- **Example Usage:**
  ```bash
  curl -X POST http://localhost:8000/api/login \
       -H "Content-Type: application/json" \
       -d '{"email": "example@example.com", "password": "password"}'
#### Get followers
- **Method:** GET
- **Endpoint:** `/api/followers`
- **Description:** Returns a paginated list of the authenticated user's followers
- **Parameters:**
    - `page` (integer, optional): The page number to retrieve.
- **Example Usage:**
  ```bash
  curl -X GET http://localhost:8000/api/followers?page=2 \
     -H "Authorization: Bearer your_generated_token_here"
#### Publish a Link
- **Method:** POST
- **Endpoint:** `/api/links`
- **Description:** Allows an authenticated user to publish a link with a title, url, and optional tags
- **Parameters:**
    - `title` (string, required):  The title of the link.
    - `url` (string, required):  The url of the link.
    - `tags` (string (with hashtags), optional): a string of words with hashtags.
- **Example Usage:**
  ```bash
  curl -X POST http://localhost:8000/api/links \
     -H "Authorization: Bearer your_generated_token_here" \
     -H "Content-Type: application/json" \
     -d '{
           "title": "My Link Title",
           "url": "www.test.com",
           "tags": "#tag1#tag2"
         }'
#### Get a Link
- **Method:** GET
- **Endpoint:** `/api/links/{id}`
- **Description:** Retrieves a specific link by its ID.
- **Parameters:**
    - `id` (integer, required): The ID of the link to retrieve.
- **Example Usage:**
  ```bash
  curl -X GET http://localhost:8000/api/links/1 \
     -H "Authorization: Bearer your_generated_token_here"
#### List Links
- **Method:** GET
- **Endpoint:** `/api/favoriteLinks`
- **Description:** Returns a paginated list of all published links.
- **Parameters:**
    - `page` (integer, optional):  The page number to retrieve.
    - `tags` (string (with hashtags), optional): a string of words with hashtags to filter the links. (please escape # with %23)
- **Example Usage:**
  ```bash
  curl -X GET http://localhost:8000/api/links?page=2&tags=%23tag1%23tag2 \
     -H "Authorization: Bearer your_generated_token_here"
#### List Favorite Links
- **Method:** GET
- **Endpoint:** `/api/links`
- **Description:** Returns a paginated list of all links published by the authenticated user's followers.
- **Parameters:**
    - `page` (integer, optional):  The page number to retrieve.
    - `tags` (string (with hashtags), optional): a string of words with hashtags to filter the links. (please escape # with %23)
- **Example Usage:**
  ```bash
  curl -X GET http://localhost:8000/api/favoriteLinks?page=2&tags=%23tag1%23tag2 \
     -H "Authorization: Bearer your_generated_token_here"
#### Like a Link
- **Method:** POST
- **Endpoint:** `/api/links/{id}/like`
- **Description:** Allows an authenticated user to like a specific link.
- **Parameters:**
    - `id` (integer, required):  The ID of the link to like.
- **Example Usage:**
  ```bash
  curl -X POST http://localhost:8000/api/links/1/like \
     -H "Authorization: Bearer your_generated_token_here"

## Setup and running
The app is dockerized, it just requires docker in your machine.

Run the following commands to have an example environment running on localhost:8000

(you will also have MilHog running on localhost:8025)

to build the app:
```
docker compose build social
```
to run the app:
```
docker compose up -d social
```
to run  the migrations and set up the database:
```
docker exec social php artisan migrate
```

to fill the database with fake data:
```
docker exec social php artisan db:seed --class=DatabaseSeeder
```



