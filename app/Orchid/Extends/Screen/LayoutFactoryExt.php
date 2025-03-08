<?php

namespace App\Orchid\Extends\Screen;

use App\Orchid\Extends\Screen\Layouts\BlockExt;
use Illuminate\Support\Arr;
use Orchid\Screen\LayoutFactory;

class LayoutFactoryExt extends LayoutFactory
{
    public static function blockExt($layouts): BlockExt
    {
        return new class(Arr::wrap($layouts)) extends BlockExt {
        };
    }
}
