<?php

use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;
use App\Models\Article;
use App\Models\City;
use App\Models\Contact;
use App\Models\FilterPage;

return [
    [
        'route' => 'index',
        'param' => null,
        'freq'  => 'daily',
        'model' => null,
        'enum'  => null,
        'priority' => 1.0,
    ],
    /*[
        'route' => 'search',
        'param' => 'type',
        'freq'  => 'daily',
        'model' => null,
        'enum'  => SpecializationTypeNames::class,
        'priority' => 0.8,
    ],*/
    [
        'route' => 'article.all',
        'param' => null,
        'freq'  => 'daily',
        'model' => null,
        'enum'  => null,
        'priority' => 0.5,
    ],
    [
        'route' => 'article.get',
        'param' => 'alias',
        'freq'  => 'monthly',
        'model' => Article::class,
        'enum'  => null,
        'priority' => 0.5,
    ],
    [
        'route' => 'catalog.index',
        'param' => null,
        'freq'  => 'daily',
        'model' => null,
        'enum'  => null,
        'priority' => 0.8,
    ],
    [
        'route' => 'catalog.city',
        'param' => 'alias',
        'freq'  => 'daily',
        'model' => City::class,
        'enum'  => null,
        'priority' => 0.5,
    ],
    [
        'route' => 'salon.index',
        'param' => 'alias',
        'freq'  => 'monthly',
        'model' => Contact::class,
        'enum'  => null,
        'priority' => 0.5,
    ],
    [
        'route' => 'search.tattoo',
        'param' => 'slug',
        'freq'  => 'daily',
        'model' => FilterPage::class,
        'enum'  => null,
        'priority' => 0.5,
        'filter'=> [ 'type', '=', SpecializationTypes::TATTOO ]
    ],
    [
        'route' => 'search.piercing',
        'param' => 'slug',
        'freq'  => 'daily',
        'model' => FilterPage::class,
        'enum'  => null,
        'priority' => 0.5,
        'filter'=> [ 'type', '=', SpecializationTypes::PIERCING ]
    ],
    [
        'route' => 'search.tatuaje',
        'param' => 'slug',
        'freq'  => 'daily',
        'model' => FilterPage::class,
        'enum'  => null,
        'priority' => 0.5,
        'filter'=> [ 'type', '=', SpecializationTypes::TATUAJE ]
    ],
];
