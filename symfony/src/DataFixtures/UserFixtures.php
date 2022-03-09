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
             ->setFirstname('Scientist')
             ->setLastname('Scientist')
             ->setPhone('+33 7 57 13 09 36')
             ->setCompany('SCIENTIST CORP')
         ;
         $scientist->setPassword($this->userPasswordHasher->hashPassword($scientist, 'test'));
         $manager->persist($scientist);

         $manager->flush();

         $admin = (new User())
             ->setEmail('admin@wired-beauty.com')
             ->setRoles(['ROLE_ADMIN'])
             ->setFirstname('Admin')
             ->setLastname('Admin')
             ->setPhone('+33 7 57 13 09 36')
             ->setCompany('Wired Beauty Technologies')
         ;
         $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'test'));
         $manager->persist($admin);

         $manager->flush();

        $client = (new User())
            ->setEmail('client@client.com')
            ->setRoles(['ROLE_CLIENT'])
            ->setFirstname('Client')
            ->setLastname('Client')
            ->setPhone('+33 7 57 13 09 36')
            ->setCompany("L'Oreal")
        ;
        $client->setPassword($this->userPasswordHasher->hashPassword($client, 'test'));
        $manager->persist($client);

        $manager->flush();

         $tester = (new User())
             ->setEmail('tester@tester.com')
             ->setRoles(['ROLE_TESTER'])
             ->setFirstname('Tester')
             ->setLastname('Tester')
             ->setPhone('+33 7 57 13 09 36')
         ;
         $tester->setPassword($this->userPasswordHasher->hashPassword($tester, 'test'));
         $manager->persist($tester);

         $manager->flush();
    }
}
