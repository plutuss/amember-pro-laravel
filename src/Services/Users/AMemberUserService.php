<?php

namespace Plutuss\AMember\Services\Users;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberUserService extends AMemberClient implements AMemberUserInterface, AMemberParametersApiInterface
{

    /**
     * @param string $login
     * @param string $pass
     * @param string $email
     * @param array $params
     * @return Collection
     */
    public function addUsers(
        string $login,
        string $pass,
        string $email,
        array  $params = []
    ): Collection
    {
        return $this->setOption('/users', [
            'login' => $login,
            'pass' => $pass,
            'email' => $email,
            ...$params
        ])->sendPost();
    }

    /**
     * @param int $id
     * @param array $fieldsAndValue
     * @return Collection
     */
    public function updateUser(int $id, array $fieldsAndValue): Collection
    {
        return $this->setOption('/users/' . $id, $fieldsAndValue)->sendPut();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function deletingUser(int $id): Collection
    {
        return $this->setOption('/users/' . $id)->sendDelete();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUsers(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/users', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserConsent(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/user-consent', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserGroups(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/user-groups', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserNotes(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/user-notes', $id)
        )->sendGet();
    }

}
