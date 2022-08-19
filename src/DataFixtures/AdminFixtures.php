<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 1; $i++){
            $admin = new Admin;
            $admin ->setUser("Admin$i")
                    ->setPass("Admin");
        }
        
        $manager->flush();
    }
}
