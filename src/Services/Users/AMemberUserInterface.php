<?php

namespace Plutuss\AMember\Services\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberUserInterface
{
    /**
     * @param string $login
     * @param string $pass
     * @param string $email
     * @param array $params
     * @return JsonResponse|array|Collection
     */
    public function addUsers(string $login, string $pass, string $email, array $params = []): JsonResponse|array|Collection;

    /**
     * @param int $id
     * @param array $fieldsAndValue
     * @return JsonResponse|array|Collection
     */
    public function updateUser(int $id, array $fieldsAndValue): JsonResponse|array|Collection;

    /**
     * @param int $id
     * @return JsonResponse|array|Collection
     */
    public function deletingUser(int $id): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getUsers(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getUserConsent(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getUserGroups(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getUserNotes(?int $id = null): JsonResponse|array|Collection;
}
