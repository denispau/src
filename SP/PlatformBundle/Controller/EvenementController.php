<?php
// src/SP/PlatformBundle/Controller/EvenementController.php

namespace SP\PlatformBundle\Controller;

use SP\PlatformBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends Controller
{
  public function addAction(Request $request)
  {
    // Cr�ation de l'entit� Evenement
    $evenement = new Evenement();

    // Cr�ation du formulaire
    $form = $this->get('form.factory')->create(new EvenementType(), $evenement);
   
    // On v�rifie que les valeurs entr�es sont correctes
    if ($form->handleRequest($request)->isValid())
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Ev�nement bien enregistr�.');

        //On redirige vers la page de visualisation de l'�v�nement nouvellement cr��
        return $this->redirect($this->generateUrl('sp_platform_view', array('id' => $evenement->getId())));

    }

    return $this->render('SPPlatformBundle:Evenement:add.html.twig',array('form' => $form->createView()));
  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On r�cup�re l'�v�nement $id
    $evenement = $em->getRepository('SPPlatformBundle:Evenement')->find($id);

    if (null === $evenement) {
      throw new NotFoundHttpException("L'�v�nement d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new EvenementEditType(), $evenement);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait d�j� notre �v�nement
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Ev�nement bien modifi�.');

      return $this->redirect($this->generateUrl('sp_platform_view', array('id' => $evenement->getId())));
    }

    return $this->render('SPPlatformBundle:Evenement:edit.html.twig', array(
      'form'   => $form->createView(),
      'evenement' => $evenement // Je passe �galement l'�v�nement � la vue si jamais il veut l'afficher
    ));
  }

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On r�cup�re l'�v�nement $id
    $evenement = $em->getRepository('SPPlatformBundle:Evenement')->find($id);

    if (null === $evenement) {
      throw new NotFoundHttpException("L'�v�nement d'id ".$id." n'existe pas.");
    }

    // On cr�e un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de prot�ger la suppression d'�v�nement contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($evenement);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'�v�nement a bien �t� supprim�.");

      return $this->redirect($this->generateUrl('sp_platform_home'));
    }

    // Si la requ�te est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('SPPlatformBundle:Evenement:delete.html.twig', array(
      'evenement' => $evenement,
      'form'   => $form->createView()
    ));
  }
}