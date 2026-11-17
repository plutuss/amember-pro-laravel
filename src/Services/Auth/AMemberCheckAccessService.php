<?php

namespace Plutuss\AMember\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberCheckAccessService extends AMemberClient implements AMemberCheckAccessInterface, AMemberParametersApiInterface
{

    /**
     * @param string $login
     * @param string $pass
     * @param string $ip
     * @return JsonResponse|array|Collection
     */
    public function byLoginPassIp(string $login, string $pass, string $ip): JsonResponse|array|Collection
    {
        return $this->setOption('/check-access/by-login-pass-ip', [
            'login' => $login,
            'pass' => $pass,
            'ip' => $ip,
        ])->sendGet();

    }

    /**
     * @param string $login
     * @param string $pass
     * @return JsonResponse|array|Collection
     */
    public function byLoginPass(string $login, string $pass): JsonResponse|array|Collection
    {
        return $this->setOption('/check-access/by-login-pass', [
            'login' => $login,
            'pass' => $pass,
        ])->sendGet();
    }

    /**
     * @param string $login
     * @return JsonResponse|array|Collection
     */
    public function byUsername(string $login): JsonResponse|array|Collection
    {
        return $this->setOption('/check-access/by-login', [
            'login' => $login,
        ])->sendGet();
    }

    /**
     * @param string $email
     * @return JsonResponse|array|Collection
     */
    public function byEmailAddress(string $email): JsonResponse|array|Collection
    {
        return $this->setOption('/check-access/by-email', [
            'email' => $email,
        ])->sendGet();
    }

    /**
     * @param string $login
     * @return JsonResponse|array|Collection
     */
    public function restorePassword(string $login): JsonResponse|array|Collection
    {
        return $this->setOption('/check-access/send-pass', [
            'login' => $login,
        ])->sendGet();
    }

}
