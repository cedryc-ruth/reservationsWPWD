<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Location;
use Cocur\Slugify\Slugify;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $locations = [
            [
                'slug' => null,
                'designation' => 'Espace Delvaux / La vénerie',
                'address' => '3 rue Gratès',
                'locality' => 'Watermael-Boitsfort',
                'website' => 'https://www.lavenerie.be',
                'phone' => '+32 (0)2/663.85.50',
            ],
            [
                'slug' => null,
                'designation' => 'Dexia Art Center',
                'address' => '50 rue de l\'Ecuyer',
                'locality' => 'Bruxelles',
                'website' => null,
                'phone' => null,
            ],
            [
                'slug' => null,
                'designation' => 'La Samaritaine',
                'address' => '16 rue de la samaritaine',
                'locality' => 'Bruxelles',
                'website' => 'https://www.lasamaritaine.be',
                'phone' => null,
            ],
            [
                'slug' => null,
                'designation' => 'Espace Magh',
                'address' => '17 rue du Poinçon',
                'locality' => 'Bruxelles',
                'website' => 'http://www.espacemagh.be',
                'phone' => null,
            ],
        ];
        
        foreach($locations as $data) {
            $slugify = new Slugify();
            $location_slug = $slugify->slugify($data['designation']);
            
            $location = new Location();
            $location->setSlug($location_slug);
            $location->setDesignation($data['designation']);
            $location->setAddress($data['address']);
            $location->setLocality($this->getReference($data['locality']));
            $location->setWebsite($data['website']);
            $location->setPhone($data['phone']);
                        
            $manager->persist($location);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            LocalityFixtures::class,
        ];
    }
}
