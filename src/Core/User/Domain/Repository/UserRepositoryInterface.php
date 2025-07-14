<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\User;
use Doctrine\ORM\NonUniqueResultException;

interface UserRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    public function save(User $user): void;

    public function flush(): void;
}
