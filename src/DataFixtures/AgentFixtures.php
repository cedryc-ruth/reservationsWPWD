<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Agent;

class AgentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $agents = [
            [
                'name'=>'bob',
                'email'=>'bob@sull.com',
            ],
            [
                'name'=>'fred',
                'email'=>'fred@sull.com',
            ],
        ];
        
        foreach($agents as $data) {
            $agent = new Agent();
            $agent->setName($data['name']);
            $agent->setEmail($data['email']);
            
            $this->addReference($data['email'],$agent);
            
            $manager->persist($agent);
        }

        $manager->flush();
    }
}
