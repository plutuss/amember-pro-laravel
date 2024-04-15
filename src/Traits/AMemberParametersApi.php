<?php

namespace Plutuss\AMember\Traits;

trait AMemberParametersApi
{
    private string $format = 'json';
    private int $count = 20;
    private int $page = 0;
    private string $sort;
    private string $order = 'asc';
    private string $filter;
    private string $field_name = '';
    private string $nested;


    private function initParams(): void
    {

        $params = array_merge(
            $this->params,
            [
                '_format' => $this->format ?? null,
                '_count' => $this->count,
                '_page' => $this->page ?? null,
                '_sort' => $this->sort ?? null,
                '_order' => $this->order ?? null,
                '_filter[' . $this->field_name . ']' => $this->filter ?? null,
                '_nested[]' => $this->nested ?? null,
            ]
        );

        $this->params = collect($params)->map(function (null|string|array $item) {
            if (isset($item) && !empty($item)) {
                return $item;
            }
        })
            ->filter()
            ->toArray();

    }

    /**
     * @param string $format
     * @return $this
     */
    public function format(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function count(int $count): static
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page): static
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param $sort
     * @return $this
     */
    public function sort($sort): static
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @param string $order
     * @return $this
     */
    public function order(string $order): static
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param string $fieldName
     * @param string $filter
     * @return $this
     */
    public function filter(string $fieldName, string $filter): static
    {
        $this->field_name = $fieldName;
        $this->filter = $filter;
        return $this;
    }

    /**
     * @param string $nested
     * @return $this
     */
    public function nested(string $nested): static
    {
        $this->nested = $nested;
        return $this;
    }

}
