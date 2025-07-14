<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;

class HashService
{
    private UserPasswordHasherInterface $hasher;
    private UserRepository $userRepo;

    public function __construct(UserPasswordHasherInterface $hasher ,UserRepository $userRepo)
    {
        $this->hasher = $hasher;
        $this->userRepo = $userRepo;
    }

    public function hashPassword(User $user, string $plainPassword): string
    {
        return $this->hasher->hashPassword($user, $plainPassword);
    }

    public function isEmailUnique(string $email):bool
    {
        return null === $this->userRepo->findOneBy(['email' => $email]);
    }
}
