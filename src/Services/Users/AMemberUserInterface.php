<?php

namespace Plutuss\AMember\Services\Users;

use Illuminate\Support\Collection;

interface AMemberUserInterface
{
    /**
     * @param string $login
     * @param string $pass
     * @param string $email
     * @param array $params
     * @return Collection
     */
    public function addUsers(string $login, string $pass, string $email, array $params = []): Collection;

    /**
     * @param int $id
     * @param array $fieldsAndValue
     * @return Collection
     */
    public function updateUser(int $id, array $fieldsAndValue): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function deletingUser(int $id): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUsers(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserConsent(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserGroups(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getUserNotes(?int $id = null): Collection;
}
