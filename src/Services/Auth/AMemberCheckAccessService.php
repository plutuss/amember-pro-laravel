<?php

namespace Plutuss\AMember\Services\Auth;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberCheckAccessService extends AMemberClient implements AMemberCheckAccessInterface, AMemberParametersApiInterface
{

    /**
     * @param string $login
     * @param string $pass
     * @param string $ip
     * @return Collection
     */
    public function byLoginPassIp(string $login, string $pass, string $ip): Collection
    {
        return $this->setOption('/check-access/by-login-pass-ip', [
            'login' => $login,
            'pass' => $pass,
            'ip' => $ip,
        ])->sendPost();

    }

    /**
     * @param string $login
     * @param string $pass
     * @return Collection
     */
    public function byLoginPass(string $login, string $pass): Collection
    {
        return $this->setOption('/check-access/by-login-pass', [
            'login' => $login,
            'pass' => $pass,
        ])->sendPost();
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function byUsername(string $login): Collection
    {
        return $this->setOption('/check-access/by-login', [
            'login' => $login,
        ])->sendPost();
    }

    /**
     * @param string $email
     * @return Collection
     */
    public function byEmailAddress(string $email): Collection
    {
        return $this->setOption('/check-access/by-email', [
            'email' => $email,
        ])->sendPost();
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function restorePassword(string $login): Collection
    {
        return $this->setOption('/check-access/send-pass', [
            'login' => $login,
        ])->sendPost();
    }

}
