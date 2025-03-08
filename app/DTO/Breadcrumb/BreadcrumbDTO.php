<?php

namespace App\DTO\Breadcrumb;

/**
 * @property string $title
 * @property string $link
 *
 * Class BreadcrumbDTO
 */
class BreadcrumbDTO
{
    /**
     * BreadcrumbDTO constructor.
     * @param string $title
     * @param string $link
     */
    public function __construct(
        public string $title,
        public string $link
    ) {}
}