<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassroomFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 1; $i++){
            $class = new Classroom;
            $class->setName("Class$i")
                    ->setQuantity(rand(10,20))
                    ->setDescription("This is the test");
                    
        }
        

        $manager->flush();
    }
}
