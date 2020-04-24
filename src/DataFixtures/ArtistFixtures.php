<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $artists = [
            [  
                'firstname' => 'Daniel',
                'lastname' => 'Marcelin',
            ],
            [  
                'firstname' => 'Philippe',
                'lastname' => 'Laurent',
            ],
            [  
                'firstname' => 'Marius',
                'lastname' => 'Von Mayenburg',
            ],
        ];
        
        foreach($artists as $data) {
            $artist = new Artist();
            $artist->setFirstname($data['firstname']);
            $artist->setLastname($data['lastname']);

            $manager->persist($artist);
        }
        
        $manager->flush();
    }
}
