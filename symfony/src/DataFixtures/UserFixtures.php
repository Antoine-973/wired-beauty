<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordHasherInterface $userPasswordHasher */
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
         $scientist = (new User())
             ->setEmail('scientist@scientist.com')
             ->setRoles(['ROLE_SCIENTIST'])
         ;
         $scientist->setPassword($this->userPasswordHasher->hashPassword($scientist, 'test'));
         $manager->persist($scientist);

         $manager->flush();

         $admin = (new User())
             ->setEmail('admin@wired-technologies.com')
             ->setRoles(['ROLE_ADMIN'])
         ;
         $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'test'));
         $manager->persist($admin);

         $manager->flush();

        $client = (new User())
            ->setEmail('client@client.com')
            ->setRoles(['ROLE_CLIENT'])
        ;
        $client->setPassword($this->userPasswordHasher->hashPassword($client, 'test'));
        $manager->persist($client);

        $manager->flush();

         $tester = (new User())
              ->setEmail('tester@tester.com')
              ->setRoles(['ROLE_TESTER'])
         ;
         $tester->setPassword($this->userPasswordHasher->hashPassword($tester, 'test'));
         $manager->persist($tester);

         $manager->flush();
    }
}
