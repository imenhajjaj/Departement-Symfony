<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Departement;
use App\Form\DepartementType;
use App\Form\EmployeType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class IndexController extends AbstractController
{ 
  
     /**
        * @Route("/employe/save")
        */
       public function save() {
         $entityManager = $this->getDoctrine()->getManager();
  
         $employe = new Employe();
         $employe->setNom('imen');
         $employe->setSalaire(1500);
         $employe-> setBornAt(new \DateTime);
         $employe->setEmail('imen.hajja@gmail.com');

         $entityManager->persist($employe);
         $entityManager->flush();
  
         return new Response('employe enregisté avec id'.$employe->getId());
       }
  
     /**
     * @Route("/employe/new", name="new_employe")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
      $employe = new Employe();
    
      $form = $this->createForm(EmployeType::class, $employe);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $employe = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($employe);
        $entityManager->flush();

        return $this->redirectToRoute('employe_list');
      }
      return $this->render('employe/new.html.twig',['form' => $form->createView()]);
  }

    
    
 /**
     * @Route("/employe/{id}", name="employe_show")
     */
    public function show($id) {
        $employe = $this->getDoctrine()->getRepository(Employe::class)->find($id);
  
        return $this->render('employe/show.html.twig', array('employe' => $employe));
      }
 
 /**
     * @Route("/employe/delete/{id}",name="delete_employe")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $employe = $this->getDoctrine()->getRepository(Employe::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($employe);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('employe_list');
      }



    
		/**
		 * @Route("/employe/edit/{id}", name="edit_employe")
		 * Method({"GET","POST"})
		*/
		public function edit( Request $request ,$id)
		{
			$employe = new Employe();
			$employe = $this->getDoctrine()->getRepository(Employe::class)->find($id);

			$form = $this->createForm(EmployeType::class,$employe);

			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {

				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->flush();

				return $this->redirectToRoute('employe_list');
			}
			return $this->render('employe/edit.html.twig',['form' => $form->createView()]);
		}


    /**
     * @Route("/departement/newdep", name="new_departement")
     * Method({"GET", "POST"})
     */
    public function newCategory(Request $request) {
        $departement = new Departement();
      
        $form = $this->createForm(DepartementType::class,$departement);
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $employe = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($departement);
          $entityManager->flush();
        }
        return $this->render('employe/newdep.html.twig',['form' => $form->createView()]);
    }
    /**
    *@Route("/", name="employe_list")
   */
    public function home()
    {
      
      $employe= $this->getDoctrine()->getRepository(Employe::class)->findAll();
      return  $this->render('employe/index.html.twig',['employe' => $employe]);  
    }
  
    

}
