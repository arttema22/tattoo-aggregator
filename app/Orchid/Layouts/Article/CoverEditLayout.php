<?php

namespace App\Orchid\Layouts\Article;

use App\Orchid\Fields\PictureExtra;
use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class CoverEditLayout extends Rows
{
    /**
     * @var string|null
     */
    protected $title;

    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            PictureExtra::make( 'article.banner.url' )
                ->vertical()
        ];
    }
}
