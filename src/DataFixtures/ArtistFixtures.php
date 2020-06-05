<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $artists = [
            ['firstname'=>'Daniel','lastname'=>'Marcelin','agent'=>'bob@sull.com'],
            ['firstname'=>'Philippe','lastname'=>'Laurent'],
            ['firstname'=>'Marius','lastname'=>'Von Mayenburg'],
            ['firstname'=>'Olivier','lastname'=>'Boudon'],
            ['firstname'=>'Anne Marie','lastname'=>'Loop','agent'=>'bob@sull.com'],
            ['firstname'=>'Pietro','lastname'=>'Varasso'],
            ['firstname'=>'Laurent','lastname'=>'Caron','agent'=>'fred@sull.com'],
            ['firstname'=>'Élena','lastname'=>'Perez'],
            ['firstname'=>'Guillaume','lastname'=>'Alexandre','agent'=>'bob@sull.com'],
            ['firstname'=>'Claude','lastname'=>'Semal','agent'=>'fred@sull.com'],
            ['firstname'=>'Laurence','lastname'=>'Warin','agent'=>'fred@sull.com'],
            ['firstname'=>'Pierre','lastname'=>'Wayburn'],
            ['firstname'=>'Gwendoline','lastname'=>'Gauthier','agent'=>'fred@sull.com'],
        ];
        
        foreach($artists as $data) {
            $artist = new Artist();
            $artist->setFirstname($data['firstname']);
            $artist->setLastname($data['lastname']);
            
            if(!empty($data['agent'])) {
                $artist->setAgent($this->getReference($data['agent']));
            }

            $this->addReference($data['firstname'].'-'.$data['lastname'], $artist);
            
            $manager->persist($artist);
        }
        
        $manager->flush();
    }
    
    public function getDependencies() {
        return [
            AgentFixtures::class,
        ];
    }
}
