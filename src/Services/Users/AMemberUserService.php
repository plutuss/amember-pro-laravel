<?php

namespace Plutuss\AMember\Services\Users;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function addUsers(
        string $login,
        string $pass,
        string $email,
        array  $params = []
    ): JsonResponse|array|Collection
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
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function updateUser(int $id, array $fieldsAndValue): JsonResponse|array|Collection
    {
        return $this->setOption('/users/' . $id, $fieldsAndValue)->sendPut();
    }

    /**
     * @param int $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function deletingUser(int $id): JsonResponse|array|Collection
    {
        return $this->setOption('/users/' . $id)->sendDelete();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getUsers(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/users', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getUserConsent(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/user-consent', $id)
        )->sendGet();
    }


    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getUserGroups(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/user-groups', $id)
        )->sendGet();
    }


    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getUserNotes(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/user-notes', $id)
        )->sendGet();
    }

}
