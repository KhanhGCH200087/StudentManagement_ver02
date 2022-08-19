<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i<=1;$i++){
            $teacher = new Teacher;
            $teacher->setName("Teacher $i")
                    ->setAge(rand(30, 40))
                    ->setGender("Male")
                    ->setImage("https://blog.topcv.vn/wp-content/uploads/2021/07/4may-tro-giang2.jpg")
                    ->setEmail("teacher$i@gmail.com")
                    ->setPass("Teacher");
        }
        

        $manager->flush();
    }
}
