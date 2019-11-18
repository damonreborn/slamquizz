<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // User
        $user = new User();
        $user->setUsername('User');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $manager->persist($user);

        // Admin
        $user = new User();
        $user->setUsername('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));
        $manager->persist($user);

        // SuperAdmin
        $user = new User();
        $user->setUsername('SuperAdmin');
        $user->setRoles(['ROLE_SUPERADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'superadmin'
        ));
        $manager->persist($user);

        $manager->flush();
    }
}
