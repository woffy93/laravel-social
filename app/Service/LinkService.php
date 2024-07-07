<?php

namespace App\Service;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\NewLinkNotification;

class LinkService implements LinkServiceInterface
{
    public function storeLink(string $title, string $url, User $author, string $hashtags = "")
    {
        $link = new Link();
        $link->title = $title;
        $link->url = $url;
        $link->user_id = $author->id;
        $link->save();

        foreach ($this->parseHashtags($hashtags) as $tagName) {
            if (!empty($tagName)) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $link->tags()->attach($tag->id);
            }
        }

        $this->notifyFollowersOfLinkCreation($author, $link);
        return $link;
    }

    private function parseHashtags($tagString)
    {
        $hashtags = [];
        preg_match_all("/(#\w+)/u", $tagString, $matches);
        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);
        }
        return $hashtags;
    }

    public function getAllLinks(string $tagFilter = null, int $itemsPerPage = 10)
    {
        $links = Link::orderBy('created_at', 'desc')
            ->with('user') //eager load user
            ->with('tags'); //eager load tags

        if ($tagFilter) {
            return $links->whereHas('tags', function ($query) use ($tagFilter) {
                $query->whereIn('name', $this->parseHashtags($tagFilter));
            })->paginate($itemsPerPage);
        }
        return $links->paginate($itemsPerPage);
    }

    public function getFavoriteLinkCollection(User $user, string $tagFilter = null, int $itemsPerPage = 10)
    {
        $favoriteUsersIds = $user->followingEntities()
            ->whereFollowableType(User::class)
            ->get('followable_id')
            ->values()
            ->toArray();

        $links = Link::whereIn('user_id', $favoriteUsersIds)
            ->with('user')
            ->orderBy('created_at', 'desc');
        if ($tagFilter) {
            return $links->whereHas('tags', function ($query) use ($tagFilter) {
                $query->whereIn('name', $this->parseHashtags($tagFilter));
            })
                ->paginate($itemsPerPage);
        }
        return $links->paginate($itemsPerPage);
    }

    public function getLinkById($id)
    {
        return Link::find($id);
    }

    /**
     * @param User $author
     * @param Link $link
     * @return void
     */
    private function notifyFollowersOfLinkCreation(User $author, Link $link): void
    {
        $followers = $author->followers()->whereFollowerType(User::class)->cursor();
        foreach ($followers as $follower) {
            $follower->follower->notify(new NewLinkNotification($link, $author->name));
        }
    }
}
