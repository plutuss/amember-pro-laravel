<?php

namespace Plutuss\AMember\Traits;

use InvalidArgumentException;

trait AMemberParametersApi
{
    /**
     * @var string
     */
    private string $format = 'json';

    private array $additionalParams = [];
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
            $this->additionalParams,
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

        $this->params = array_filter(
            $params,
            static fn (mixed $value): bool => $value !== null
        );

    }

    /**
     * @param string $format
     * @return $this
     */
    public function format(string $format): static
    {
        if (!in_array($format, ['json', 'xml', 'serialize'], true)) {
            throw new InvalidArgumentException('Format must be json, xml or serialize.');
        }

        $this->format = $format;
        return $this;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function count(int $count): static
    {
        if ($count < 1 || $count > 1000) {
            throw new InvalidArgumentException('Count must be between 1 and 1000.');
        }

        $this->count = $count;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page): static
    {
        if ($page < 0) {
            throw new InvalidArgumentException('Page must be zero or greater.');
        }

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
        if (!in_array($order, ['asc', 'desc'], true)) {
            throw new InvalidArgumentException('Order must be asc or desc.');
        }

        $this->order = $order;
        return $this;
    }

   /**
     * @example filter(['user_id' => 1])
     *
     * @param array $filter
     * @return $this
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
     * @example nested(['invoices','access'])
     *
     * @param array $nested
     * @return $this
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

    /** Additional payload fields; endpoint arguments and fluent options take precedence. */
}
