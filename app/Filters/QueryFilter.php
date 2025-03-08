<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Str;

abstract class QueryFilter
{
    /**
     * @var Request|null
     */
    protected ?Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @var array
     */
    protected array $custom_fields = [];

    /**
     * @param Request|null $request
     */
    public function __construct( ?Request $request = null )
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @param string $table_name
     */
    public function apply( Builder $builder, string $table_name ): void
    {
        $this->builder = $builder->select( $table_name . '.*' );

        foreach ($this->fields() as $field => $value) {
            $method = Str::camel( $field );
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array)$value);
            }
        }
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        if ( $this->request === null ) {
            return $this->custom_fields;
        }

        return $this->custom_fields + array_filter( $this->request->all() );
    }

    /**
     * @param array $custom_fields
     */
    public function setCustomFields( array $custom_fields ): void
    {
        $this->custom_fields = $custom_fields;
    }
}
