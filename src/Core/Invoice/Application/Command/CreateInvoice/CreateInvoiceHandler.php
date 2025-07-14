<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Exception\UserNotActivatedException;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     * @throws UserNotActivatedException
     */
    public function __invoke(CreateInvoiceCommand $command): void
    {
        $this->invoiceRepository->save(new Invoice(
            $this->getActiveUserByEmail($command->email),
            $command->amount)
        );
        $this->invoiceRepository->flush();
    }

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     * @throws UserNotActivatedException
     */
    private function getActiveUserByEmail(string $email): User
    {
        $user = $this->userRepository->getByEmail($email);
        if (!$user->isActive()) {
            throw new UserNotActivatedException('Użytkownik nie został aktywowany.');
        }
        return $user;
    }
}
