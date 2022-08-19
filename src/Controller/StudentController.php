<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/index', name: 'student_index')]
    public function studentIndex(StudentRepository $studentRepository)
    {
        //$students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        $students = $studentRepository->sortStudentByIdDesc();
        return $this->render('student/index.html.twig', 
        [
            'students' => $students
        ]);
    }

    #[Route('/detail/{id}', name:'student_detail')]
    public function studentDetail ($id, StudentRepository $studentRepository) 
    {
        $student = $studentRepository->find($id);
        if ($student == null)
        {
            $this ->addFlash('Warning', 'Invalid class $id !');
            return $this->redirectToRoute('student_index');
        }
        return $this->render('student/detail.html.twig', 
        [
            'student'=>$student
        ]);
    }

    #[Route('/delete/{id}', name: 'student_delete')]
    public function studentDelete ($id, ManagerRegistry $managerRegistry)
    {
        $student = $managerRegistry->getRepository(Student::class)->find($id);
        if($student == null){
            $this ->addFlash('Warning', 'Class is not existed');
            return $this->redirectToRoute('student_index');
        } else {
            $manager = $managerRegistry->getManager();
            $manager -> remove($student);
            $manager ->flush();
            $this->addFlash('Info', 'Delete class successfully');
        }
        return $this->redirectToRoute('student_index');
    }

    #[Route('/add', name:'student_add')]
    public function classroomAdd (Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('Info', 'New class is added successfully');
            return $this->redirectToRoute('student_index');
        }
        return $this->renderForm('student/add.html.twig', 
        [
            'studentForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'student_edit')]
    public function studentEdit ($id, Request $request)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if($student == null)
        {
            $this->addFlash('Warning', 'Wrong ID');
            return $this->redirectToRoute('student_index');
        } else {
            $form = $this->createForm(StudentType::class, $student);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($student);
                $manager->flush();
                $this->addFlash('Info', 'Add new successfully');
                return $this->redirectToRoute('student_index');
            }
            return $this->renderForm('student/edit.html.twig', 
            [
                'studentForm' => $form
            ]);
        }
    }
}
