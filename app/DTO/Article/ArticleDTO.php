<?php

namespace App\DTO\Article;

use App\DTO\BaseDTO;
use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $alias
 * @property int $user_id
 * @property Carbon $published_at
 *
 * Class ArticleDTO
 */
class ArticleDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'title'        => [ 'property' => 'title',        'type' => 'string' ],
            'description'  => [ 'property' => 'description',  'type' => 'string' ],
            'content'      => [ 'property' => 'content',      'type' => 'string' ],
            'alias'        => [ 'property' => 'alias',        'type' => 'string' ],
            'published_at' => [ 'property' => 'published_at', 'type' => 'Carbon', 'type_additional' => 'Y-m-d H:i:s' ],
            'user_id'      => [ 'property' => 'user_id',      'type' => 'int' ],
        ];
    }

    /**
     * @param BaseFormRequest $request
     * @return static
     */
    public static function fromRequest( BaseFormRequest $request ): self
    {
        $dto = parent::fromRequest( $request );
        $dto->user_id = (int)Auth::id();

        return $dto;
    }
}
