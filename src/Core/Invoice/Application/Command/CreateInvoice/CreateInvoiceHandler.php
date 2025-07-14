<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Exception\UserNotActivatedException;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
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
            $this->userRepository->getByEmail($command->email),
            $command->amount
        ));
        $this->invoiceRepository->flush();
    }
}
