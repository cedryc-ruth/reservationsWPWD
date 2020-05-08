<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserRoleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRoles = [
            [
                'user_login'=>'bob',
                'role'=>'admin',
            ],
            [
                'user_login'=>'fred',
                'role'=>'member',
            ],
            [
                'user_login'=>'judith',
                'role'=>'affiliate',
            ],
        ];
        
        foreach($userRoles as $record) {
            $user = $this->getReference($record['user_login']);
            $role = $this->getReference($record['role']);
            
            $user->addRole($role);
                    
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            UserFixtures::class,  
            RoleFixtures::class,  
        ];
    }

}
