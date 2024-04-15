<?php
namespace Plutuss\AMember\Contracts;
interface AMemberParametersApiInterface
{

    /**
     * @param string $format
     * @return $this
     */
    public function format(string $format): static;

    /**
     * @param int $count
     * @return $this
     */
    public function count(int $count): static;

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page): static;

    /**
     * @param $sort
     * @return $this
     */
    public function sort($sort): static;

    /**
     * @param string $order
     * @return $this
     */
    public function order(string $order): static;

    /**
     * @param string $fieldName
     * @param string $filter
     * @return $this
     */
    public function filter(string $fieldName, string $filter): static;

    /**
     * @param string $nested
     * @return $this
     */
    public function nested(string $nested): static;
}
