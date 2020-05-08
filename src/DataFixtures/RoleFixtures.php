<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roles = [
            ['role'=>'admin'],
            ['role'=>'member'],
            ['role'=>'affiliate'],
        ];
        
        foreach($roles as $data) {
            $role = new Role();
            $role->setRole($data['role']);
            
            $this->addReference($data['role'],$role);
            
            $manager->persist($role);
        }

        $manager->flush();
    }
}
