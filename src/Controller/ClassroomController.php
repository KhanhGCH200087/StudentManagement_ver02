<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// #[IsGranted('ROLE_ADMIN')]
#[Route('/classroom')]
class ClassroomController extends AbstractController
{
    #[Route('/index', name: 'classroom_index')]
    public function classroomIndex(ClassroomRepository $classroomRepository)
    {
        //$classrooms = $this->getDoctrine()->getRepository(Classroom::class)->findAll();
        $classrooms = $classroomRepository->sortClassByIdDesc();
        return $this->render('classroom/index.html.twig', 
        [
            'classrooms' => $classrooms
        ]);
    }

    #[Route('/detail/{id}', name:'classroom_detail')]
    public function classroomDetail ($id, ClassroomRepository $classroomRepository) 
    {
        $classroom = $classroomRepository->find($id);
        if ($classroom == null)
        {
            $this ->addFlash('Warning', 'Invalid class $id !');
            return $this->redirectToRoute('classroom_index');
        }
        return $this->render('classroom/detail.html.twig', 
        [
            'classroom'=>$classroom
        ]);
    }

    #[Route('/delete/{id}', name: 'classroom_delete')]
    public function classroomDelete ($id, ManagerRegistry $managerRegistry)
    {
        $classroom = $managerRegistry->getRepository(Classroom::class)->find($id);
        if($classroom == null){
            $this ->addFlash('Warning', 'Class is not existed');
            return $this->redirectToRoute('classroom_index');
        } else {
            $manager = $managerRegistry->getManager();
            $manager -> remove($classroom);
            $manager ->flush();
            $this->addFlash('Info', 'Delete class successfully');
        }
        return $this->redirectToRoute('classroom_index');
    }

    #[Route('/add', name:'classroom_add')]
    public function classroomAdd (Request $request, ManagerRegistry $managerRegistry)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $managerRegistry->getManager();
            $manager->persist($classroom);
            $manager->flush();
            $this->addFlash('Info', 'New class is added successfully');
            return $this->redirectToRoute('classroom_index');
        }
        return $this->renderForm('classroom/add.html.twig', 
        [
            'classroomForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'classroom_edit')]
    public function classroomEdit ($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $classroom = $managerRegistry->getRepository(Classroom::class)->find($id);
        if($classroom == null)
        {
            $this->addFlash('Warning', 'Wrong ID');
            return $this->redirectToRoute('classroom_index');
        } else {
            $form = $this->createForm(ClassroomType::class, $classroom);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $manager = $managerRegistry->getManager();
                $manager->persist($classroom);
                $manager->flush();
                $this->addFlash('Info', 'Add new successfully');
                return $this->redirectToRoute('classroom_index');
            }
            return $this->renderForm('classroom/edit.html.twig', 
            [
                'classroomForm' => $form
            ]);
        }
    }
}
