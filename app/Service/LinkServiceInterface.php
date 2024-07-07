<?php

namespace App\Service;

use App\Models\User;

interface LinkServiceInterface
{
    public function storeLink(string $title, string $url, User $author, string $hashtags = "");

    public function getLinkById($id);
    public function getAllLinks(string $tagFilter=null, int $itemsPerPage=10);
    public function getFavoriteLinkCollection(User $user, string $tagFilter=null, int $itemsPerPage=10);

}
