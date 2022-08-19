<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i<=1;$i++){
            $student = new Student;
            $student->setName("Student $i")
                    ->setAge(rand(10, 18))
                    ->setGender("Male")
                    ->setImage("https://blog.topcv.vn/wp-content/uploads/2021/07/4may-tro-giang2.jpg")
                    ->setEmail("student$i@gmail.com")
                    ->setPass("Student");

        $manager->flush();
    }
}
}