<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Fields\Picture;

/**
 * @method PictureExtra imgClass($value = true)
 * @method PictureExtra imgStyle($value = true)
 */
class PictureExtra extends Picture
{
    /**
     * @var string
     */
    protected $view = 'platform.fields.picture-extra';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'value'          => null,
        'target'         => 'url',
        'url'            => null,
        'maxFileSize'    => null,
        'acceptedFiles'  => 'image/*',
        'imgClass'       => 'picture-preview img-fluid mb-2 border',
        'imgStyle'       => '',
        'isCenter'       => 'text-center',
    ];
}
