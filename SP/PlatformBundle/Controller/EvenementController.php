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
    // Création de l'entité Evenement
    $evenement = new Evenement();

    // Création du formulaire
    $form = $this->get('form.factory')->create(new EvenementType(), $evenement);
   
    // On vérifie que les valeurs entrées sont correctes
    if ($form->handleRequest($request)->isValid())
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

        //On redirige vers la page de visualisation de l'événement nouvellement créé
        return $this->redirect($this->generateUrl('sp_platform_view', array('id' => $evenement->getId())));

    }

    return $this->render('SPPlatformBundle:Evenement:add.html.twig',array('form' => $form->createView()));
  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'événement $id
    $evenement = $em->getRepository('SPPlatformBundle:Evenement')->find($id);

    if (null === $evenement) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new EvenementEditType(), $evenement);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre événement
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Evénement bien modifié.');

      return $this->redirect($this->generateUrl('sp_platform_view', array('id' => $evenement->getId())));
    }

    return $this->render('SPPlatformBundle:Evenement:edit.html.twig', array(
      'form'   => $form->createView(),
      'evenement' => $evenement // Je passe également l'événement à la vue si jamais il veut l'afficher
    ));
  }

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'événement $id
    $evenement = $em->getRepository('SPPlatformBundle:Evenement')->find($id);

    if (null === $evenement) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'événement contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($evenement);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'événement a bien été supprimé.");

      return $this->redirect($this->generateUrl('sp_platform_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('SPPlatformBundle:Evenement:delete.html.twig', array(
      'evenement' => $evenement,
      'form'   => $form->createView()
    ));
  }
}