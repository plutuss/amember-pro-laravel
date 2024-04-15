<?php

namespace Plutuss\AMember\Services\Auth;

use Illuminate\Support\Collection;

interface AMemberCheckAccessInterface
{
    /**
     * @param string $login
     * @param string $pass
     * @param string $ip
     * @return Collection
     */
    public function byLoginPassIp(string $login, string $pass, string $ip): Collection;

    /**
     * @param string $login
     * @param string $pass
     * @return Collection
     */
    public function byLoginPass(string $login, string $pass): Collection;

    /**
     * @param string $login
     * @return Collection
     */
    public function byUsername(string $login): Collection;

    /**
     * @param string $email
     * @return Collection
     */
    public function byEmailAddress(string $email): Collection;

    /**
     * @param string $login
     * @return Collection
     */
    public function restorePassword(string $login): Collection;
}
