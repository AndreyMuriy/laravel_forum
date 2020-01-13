<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Зарегистрированные фильтры для операции
     *
     * @var array
     */
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Применение фильров для билдера
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Получение массива фильтров для входящего запроса
     *
     * @return mixed
     */
    public function getFilters()
    {
        return $this->intersect();
    }

    /**
     * Получение массива пересечения запрашиваемых и существующих фильтров
     *
     * @return array
     */
    protected function intersect(): ?array
    {
        $intersect = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($intersect);
    }
}
