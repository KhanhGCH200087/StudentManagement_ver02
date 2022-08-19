<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/subject')]
class SubjectController extends AbstractController
{
    #[Route('/index', name: 'subject_index')]
    public function subjectIndex(SubjectRepository $subjectRepository)
    {
        //$subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        $subjects = $subjectRepository->sortSubjectByIdDesc();
        return $this->render('subject/index.html.twig', 
        [
            'subjects' => $subjects
        ]);
    }

    #[Route('/detail/{id}', name:'subject_detail')]
    public function subjectDetail ($id, SubjectRepository $subjectRepository) 
    {
        $subject = $subjectRepository->find($id);
        if ($subject == null)
        {
            $this ->addFlash('Warning', 'Invalid class $id !');
            return $this->redirectToRoute('subject_index');
        }
        return $this->render('subject/detail.html.twig', 
        [
            'subject'=>$subject
        ]);
    }

    #[Route('/delete/{id}', name: 'subject_delete')]
    public function subjectDelete ($id, ManagerRegistry $managerRegistry)
    {
        $subject = $managerRegistry->getRepository(Subject::class)->find($id);
        if($subject == null){
            $this ->addFlash('Warning', 'Class is not existed');
            return $this->redirectToRoute('subject_index');
        } else {
            $manager = $managerRegistry->getManager();
            $manager -> remove($subject);
            $manager ->flush();
            $this->addFlash('Info', 'Delete class successfully');
        }
        return $this->redirectToRoute('subject_index');
    }

    #[Route('/add', name:'subject_add')]
    public function classroomAdd (Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();
            $this->addFlash('Info', 'New class is added successfully');
            return $this->redirectToRoute('subject_index');
        }
        return $this->renderForm('subject/add.html.twig', 
        [
            'subjectForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'subject_edit')]
    public function subjectEdit ($id, Request $request)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if($subject == null)
        {
            $this->addFlash('Warning', 'Wrong ID');
            return $this->redirectToRoute('subject_index');
        } else {
            $form = $this->createForm(SubjectType::class, $subject);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($subject);
                $manager->flush();
                $this->addFlash('Info', 'Add new successfully');
                return $this->redirectToRoute('subject_index');
            }
            return $this->renderForm('subject/edit.html.twig', 
            [
                'subjectForm' => $form
            ]);
        }
    }
}
