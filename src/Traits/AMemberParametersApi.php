<?php

namespace Plutuss\AMember\Traits;

trait AMemberParametersApi
{
    /**
     * @var string
     */
    private string $format = 'json';
    /**
     * @var int
     */
    private int $count = 20;
    /**
     * @var int
     */
    private int $page = 0;
    /**
     * @var string
     */
    private string $sort;
    /**
     * @var string
     */
    private string $order = 'asc';
    /**
     * @var array|null
     */
    private ?array $filter = null;
    /**
     * @var array|null
     */
    private ?array $nested = null;


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
                '_filter' => $this->filter ?? null,
                '_nested' => $this->nested ?? null,
            ]
        );

        $this->params = collect($params)->map(function (null|string|array $item) {
            if (isset($item) && !empty ($item)) {
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
     * @param array $filter
     * @return $this
     * @example filter(['user_id' => 1])
     *
     */
    public function filter(array $filter): static
    {
        if (is_array($this->filter)) {
            $this->filter = array_merge($filter, $this->filter);
            return $this;
        }

        $this->filter = $filter;
        return $this;
    }

    /**
     * @param array $nested
     * @return $this
     * @example nested(['invoices','access'])
     *
     */
    public function nested(array $nested): static
    {
        if (is_array($this->nested)) {
            $this->nested = array_merge($nested, $this->nested);
            return $this;
        }

        $this->nested = $nested;
        return $this;
    }

}
