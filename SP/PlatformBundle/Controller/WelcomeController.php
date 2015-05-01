<?php
// src/MC/EventBundle/Controller/EvenementController.php

namespace MC\EventBundle\Controller;

use MC\EventBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EvenementController extends Controller
{
    public function indexAction($page)
    {
    // On ne sait pas combien de pages il y a
    // Mais on sait qu'une page doit être supérieure ou égale à  1
    if ($page < 1) {
      // On déclenche une exception NotFoundHttpException, cela va afficher
      // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }
    // Ici, on récupérera la liste des événements, puis on la passera au template
    $listEvenements = array(
      array(
        'nomEvenement'   => 'Soirée post partiels',
        'id'      => 1,
        'nomOrganisateur'  => 'Coopé',
        'descriptif' => 'Nous recherchons un dÃ©veloppeur Symfony2 dÃ©butant sur Lyon. Blablaâ€¦',
        'dateDebut'    => 'lundi'),
      array(
        'nomEvenement'   => 'Blindtest',
        'id'      => 2,
        'nomOrganisateur'  => 'BdA',
        'descriptif' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blablaâ€¦',
        'dateDebut'    => 'mardi'),
      array(
        'nomEvenement'   => 'JT de passation',
        'id'      => 3,
        'nomOrganisateur'  => 'SMS',
        'descriptif' => 'Nous proposons un poste pour webdesigner. Blablaâ€¦',
        'dateDebut'    => 'jeudi')
    );
    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('MCEventBundle:Evenement:index.html.twig', array(
  'listEvenements'=> $listEvenements
  ));
  }

    public function viewAction($id)
    {
    $evenement = array(
      'nomEvenement'   => 'Soirée post partiels',
      'id'      => $id,
      'nomOrganisateur'  => 'Coopé',
      'descriptif' => 'Blablabla...',
      'dateDebut'    => 'lundi'
    );

    return $this->render('MCEventBundle:Evenement:view.html.twig', array(
      'evenement' => $evenement
    ));
  }
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
        return $this->redirect($this->generateUrl('mc_event_view', array('id' => $evenement->getId())));
        // On envoie un mail à l'administrateur général
        $contenu =$this->renderView('MCEventBundle:Evenement:email.txt.twig')
        mail ('louis.annabi@supelec.fr', 'Enregistrement événement ok', $contenu);

    }

    return $this->render('MCEventBundle:Evenement:add.html.twig',array('form' => $form->createView()));
  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'événement $id
    $evenement = $em->getRepository('MCEventBundle:Evenement')->find($id);

    if (null === $evenement) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new EvenementEditType(), $evenement);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre événement
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Evénement bien modifié.');

      return $this->redirect($this->generateUrl('mc_event_view', array('id' => $evenement->getId())));
    }

    return $this->render('MCEventBundle:Evenement:edit.html.twig', array(
      'form'   => $form->createView(),
      'evenement' => $evenement // Je passe également l'événement à la vue si jamais il veut l'afficher
    ));
  }

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'événement $id
    $evenement = $em->getRepository('MCEventBundle:Evenement')->find($id);

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

      return $this->redirect($this->generateUrl('mc_event_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('MCEventBundle:Evenement:delete.html.twig', array(
      'evenement' => $evenement,
      'form'   => $form->createView()
    ));
  }

  public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listEvenements = array(
      array('id' => 2, 'nomEvenement' => 'Soirée Coopé Post Partiels'),
      array('id' => 5, 'nomEvenement' => 'Blindtest'),
      array('id' => 9, 'nomEvenement' => 'JT de passation SMS')
    );

    return $this->render('MCEventBundle:Evenement:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listEvenements' => $listEvenements
    ));
  }
}