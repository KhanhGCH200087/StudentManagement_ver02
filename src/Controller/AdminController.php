<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/index', name: 'admin_index')]
    public function adminIndex(AdminRepository $adminRepository)
    {
        //$admins = $this->getDoctrine()->getRepository(Admin::class)->findAll();
        $admins = $adminRepository -> sortAdminByIdDesc();
        return $this->render('admin/index.html.twig', 
        [
            'admins' => $admins
        ]);
    }

    #[Route('/detail/{id}', name:'admin_detail')]
    public function adminDetail ($id, AdminRepository $adminRepository) 
    {
        $admin = $adminRepository->find($id);
        if ($admin == null)
        {
            $this ->addFlash('Warning', 'Invalid admin $id !');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/detail.html.twig', 
        [
            'admin'=>$admin
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_delete')]
    public function adminDelete ($id, ManagerRegistry $managerRegistry)
    {
        $admin = $managerRegistry->getRepository(Admin::class)->find($id);
        if($admin == null){
            $this ->addFlash('Warning', 'Admin is not existed');
            return $this->redirectToRoute('admin_index');
        } else {
            $manager = $managerRegistry->getManager();
            $manager -> remove($admin);
            $manager ->flush();
            $this->addFlash('Info', 'Delete admin successfully');
        }
        return $this->redirectToRoute('admin_index');
    }

    #[Route('/add', name:'admin_add')]
    public function adminAdd (Request $request)
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($admin);
            $manager->flush();
            $this->addFlash('Info', 'New admin is added successfully');
            return $this->redirectToRoute('admin_index');
        }
        return $this->renderForm('admin/add.html.twig', 
        [
            'adminForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_edit')]
    public function adminEdit ($id, Request $request)
    {
        $admin = $this->getDoctrine()->getRepository(Admin::class)->find($id);
        if($admin == null)
        {
            $this->addFlash('Warning', 'Wrong ID');
            return $this->redirectToRoute('admin_index');
        } else {
            $form = $this->createForm(AdminType::class, $admin);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($admin);
                $manager->flush();
                $this->addFlash('Info', 'Add new successfully');
                return $this->redirectToRoute('admin_index');
            }
            return $this->renderForm('admin/edit.html.twig', 
            [
                'adminForm' => $form
            ]);
        }
    }
}
