<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FindJob\IndexController;
use App\Http\Controllers\FindJob\SearchController;
use App\Http\Controllers\FindJob\ShowController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FindJobController extends Controller
{
    protected $indexController;
    protected $searchController;
    protected $showController;

    public function __construct(
        IndexController $indexController,
        SearchController $searchController,
        ShowController $showController
    ) {
        $this->indexController = $indexController;
        $this->searchController = $searchController;
        $this->showController = $showController;
    }

    /**
     * Display a listing of all job posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return $this->indexController->__invoke();
    }

    /**
     * Search job posts
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request): View
    {
        return $this->searchController->__invoke($request);
    }

    /**
     * Display the specified job post
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id): View
    {
        return $this->showController->__invoke($id);
    }
}
