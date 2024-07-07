<?php

namespace App\Http\Controllers;

use App\Service\LinkServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function __construct(
        private LinkServiceInterface $linkService
    )
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('links.index', ['links' => $this->linkService->getAllLinks($request->tags)]);
    }

    public function indexFavorites(Request $request)
    {
        return view('links.index', ['links' => $this->linkService->getFavoriteLinkCollection($request->user(), $request->tags)]);
    }


    /**
     * Display the form to post a new Link.
     *
     * @return View
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'url' => 'required',
            'tags' => 'max:255',
        ]);
        $this->linkService->storeLink(
            $request->title,
            $request->url,
            $request->user(),
            $request->tags
        );

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('links.show')->with('link', $this->linkService->getLinkById($id));
    }
}
