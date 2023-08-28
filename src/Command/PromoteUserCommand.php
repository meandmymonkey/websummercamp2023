<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:user:promote', description: 'Promote a user to admin status')]
final class PromoteUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username to promote');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ui = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (!$user instanceof User) {
            $ui->error(sprintf('User "%s" does not exist.', $username));

            return Command::FAILURE;
        }

        if ($user->isAdmin()) {
            $ui->error(sprintf('User "%s" is already an admin.', $username));

            return Command::FAILURE;
        }

        $user->promoteToAdmin();
        $this->entityManager->flush();

        $ui->success(sprintf('Done, user "%s" now has admin permissions.', $username));

        return Command::SUCCESS;
    }

}
