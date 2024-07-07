<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\LinkServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function __construct(
        private LinkServiceInterface $linkService
    )
    {
    }

    public function index(Request $request)
    {
        $links = $this->linkService->getAllLinks($request->tags);
        return response()->json($links);
    }

    public function indexFavorites(Request $request)
    {
        $links = $this->linkService->getAllLinks($request->tags);
        return response()->json($links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string',
            'tags' => 'nullable|string'
        ]);

        $link = $this->linkService->storeLink($request->title, $request->url, Auth::user(), $request->tags);

        return response()->json($link, 201);
    }

    public function show($id)
    {
        $link = $this->linkService->getLinkById($id);

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        return response()->json($link);
    }
}
