<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'login'=>'bob',
                'password'=>'epfc',
                'firstname'=>'Bob',
                'lastname'=>'Sull',
                'email'=>'bob@sull.com',
                'langue'=>'fr',
            ],
            [
                'login'=>'fred',
                'password'=>'epfc',
                'firstname'=>'Fred',
                'lastname'=>'Astair',
                'email'=>'fred@sull.com',
                'langue'=>'en',
            ],
            [
                'login'=>'judith',
                'password'=>'epfc',
                'firstname'=>'Judith',
                'lastname'=>'Larson',
                'email'=>'jud@lars.com',
                'langue'=>'fr',
            ],
        ];
        
        foreach ($users as $record) {
            $user = new User();
            
            $user->setLogin($record['login']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $record['password']
            ));
            $user->setFirstname($record['firstname']);
            $user->setLastname($record['lastname']);
            $user->setEmail($record['email']);
            $user->setLangue($record['langue']);
            
            $this->addReference($record['login'],$user);
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
