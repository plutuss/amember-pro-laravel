<?php

namespace Plutuss\AMember\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberCheckAccessInterface
{
    /**
     * @param string $login
     * @param string $pass
     * @param string $ip
     * @return JsonResponse|array|Collection
     */
    public function byLoginPassIp(string $login, string $pass, string $ip): JsonResponse|array|Collection;

    /**
     * @param string $login
     * @param string $pass
     * @return JsonResponse|array|Collection
     */
    public function byLoginPass(string $login, string $pass): JsonResponse|array|Collection;

    /**
     * @param string $login
     * @return JsonResponse|array|Collection
     */
    public function byUsername(string $login): JsonResponse|array|Collection;

    /**
     * @param string $email
     * @return JsonResponse|array|Collection
     */
    public function byEmailAddress(string $email): JsonResponse|array|Collection;

    /**
     * @param string $login
     * @return JsonResponse|array|Collection
     */
    public function restorePassword(string $login): JsonResponse|array|Collection;
}
