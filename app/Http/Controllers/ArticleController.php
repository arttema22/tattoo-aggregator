<?php

namespace App\Http\Controllers;

use App\DTO\Article\ArticleDTO;
use App\Filters\ArticleFilter;
use App\Filters\CategoryFilter;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Services\ArticleService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class ArticleController extends BasePublicController
{
    /**
     * @var ArticleService
     */
    private ArticleService $article_service;


    /**
     * @var int
     */
    private int $count_per_page;

    /**
     * ArticleController constructor.
     * @param ArticleService $articlesService
     */
    public function __construct(
        ArticleService $articlesService,
    )
    {
        parent::__construct();

        $this->article_service  = $articlesService;
        $this->count_per_page = config( 'article.count_per_page', 15 );
    }

    public function index( ArticleFilter $article_filter, CategoryFilter $category_filter )
    {
        $article_filter->setCustomFields( [ 'lastPublished' => true ] );

        return view(
            'page.blog',
            [
                'title'      => 'Блог | ' . config('app.name', 'Laravel'),
                'articles'   => $this->article_service->search( $article_filter, $this->count_per_page ),
                'categories' => $this->category_service->search( $category_filter )
            ]
        );
    }

    public function getByCategory( ArticleFilter $article_filter, CategoryFilter $category_filter, string $category_alias )
    {
        $article_filter->setCustomFields( [
            'lastPublished' => true,
            'category'      => $category_alias
        ] );

        return view(
            'page.blog',
            [
                'articles'   => $this->article_service->search( $article_filter, $this->count_per_page ),
                'categories' => $this->category_service->search( $category_filter )
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param CreateArticleRequest $request
     * @return JsonResponse
     */
    public function store( CreateArticleRequest $request ): JsonResponse
    {
        $article = $this->article_service->create( ArticleDTO::fromRequest( $request ) );
        if ( $article === null ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        return response()->json( [ 'article' => $article->toArray() ] );
    }

    public function show( ArticleFilter $filter, int $id )
    {
        $filter->setCustomFields( [ 'id' => $id ] );
        $article = $this->article_service->get( $filter );
        return view(
            'page.article',
            [
                'title'   => $article->title . ' | ' . config('app.name', 'Laravel'),
                'article' => $article
            ]
        );
    }

    public function showByAlias( ArticleFilter $filter, string $alias )
    {
        $filter->setCustomFields( [ 'alias' => $alias ] );
        $article = $this->article_service->get( $filter );
        if ($article === null) {
            abort( 404 );
        }

        return view(
            'page.article',
            [
                'title'   => $article->title . ' | ' . config('app.name', 'Laravel'),
                'article' => $article
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param UpdateArticleRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update( UpdateArticleRequest $request, $id ): JsonResponse
    {
        $article = $this->article_service->update( $id, ArticleDTO::fromRequest( $request ) );
        if ( $article === null ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        return response()->json( [ 'article' => $article->toArray() ] );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy( int $id ): JsonResponse
    {
        if ( $this->article_service->delete( $id ) === false ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        return response()->json( [ 'status' => 'ok' ] );
    }

    /**
     * @param ArticleFilter $filter
     * @return JsonResponse
     */
    public function search( ArticleFilter $filter ): JsonResponse
    {
        $articles = $this->article_service->search( $filter );

        return response()->json( [ 'articles' => $articles->toArray() ] );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function publish( $id ): JsonResponse
    {
        $article = $this->article_service->publish( $id );
        if ( $article === null ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        return response()->json( [ 'article' => $article->toArray() ] );
    }
}
