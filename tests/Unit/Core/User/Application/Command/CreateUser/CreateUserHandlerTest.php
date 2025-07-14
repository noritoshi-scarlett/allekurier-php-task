<?php

namespace App\Tests\Unit\Core\User\Application\Command\CreateUser;

use App\Core\User\Application\Command\CreateUser\CreateUserCommand;
use App\Core\User\Application\Command\CreateUser\CreateUserHandler;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;

    private CreateUserHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateUserHandler(
            $this->userRepository = $this->createMock(
                UserRepositoryInterface::class
            )
        );

    }

    public function test_handle_success(): void
    {
        $user = new User('test@test.pl');

        $this->userRepository->expects(self::once())
            ->method('save')
            ->with($user);

        $this->userRepository->expects(self::once())
            ->method('flush');

        $this->handler->__invoke((new CreateUserCommand('test@test.pl')));
    }
}
