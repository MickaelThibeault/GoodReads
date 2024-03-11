<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function create(string $email, string $password): void
    {
        $user = $this->userRepository->findOneBy(['contact'=>$email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }

        $user->setRoles(['ROLE_ADMIN']);

        $this->userRepository->save($user, true);
    }
}