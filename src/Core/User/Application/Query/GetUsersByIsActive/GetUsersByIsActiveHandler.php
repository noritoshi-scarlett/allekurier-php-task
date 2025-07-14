<?php

namespace App\Core\User\Application\Query\GetUsersByIsActive;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersByIsActiveHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUsersByIsActiveQuery $query): array
    {
        $users = $this->userRepository->getByIsActive($query->isActive);

        return array_map(function (User $user) {
            return new UserDTO(
                $user->getEmail(),
                $user->isActive()
            );
        }, $users);
    }
}
