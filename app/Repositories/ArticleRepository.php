<?php

namespace App\Repositories;

use App\DTO\Article\ArticleDTO;
use App\Models\Article;

class ArticleRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return Article::class;
    }

    /**
     * @param ArticleDTO $dto
     * @return Article|null
     */
    public function store( ArticleDTO $dto ): ?Article
    {
        $article = new Article();
        $article->user_id     = $dto->user_id;
        $article->title       = $dto->title;
        $article->description = $dto->description;
        $article->content     = $dto->content;
        $article->alias       = $dto->alias;

        return $article->save() ? $article : null;
    }
}
