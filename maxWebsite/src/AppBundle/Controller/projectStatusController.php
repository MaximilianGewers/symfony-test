<?php

namespace AppBundle\Controller;

use AppBundle\Entity\projectStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Projectstatus controller.
 *
 * @Route("projectstatus")
 */
class projectStatusController extends Controller
{
    /**
     * Lists all projectStatus entities.
     *
     * @Route("/", name="projectstatus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projectStatuses = $em->getRepository('AppBundle:projectStatus')->findAll();

        return $this->render('projectstatus/index.html.twig', array(
            'projectStatuses' => $projectStatuses,
        ));
    }

    /**
     * Creates a new projectStatus entity.
     *
     * @Route("/new", name="projectstatus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $projectStatus = new Projectstatus();
        $form = $this->createForm('AppBundle\Form\projectStatusType', $projectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projectStatus);
            $em->flush();

            return $this->redirectToRoute('projectstatus_show', array('id' => $projectStatus->getId()));
        }

        return $this->render('projectstatus/new.html.twig', array(
            'projectStatus' => $projectStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a projectStatus entity.
     *
     * @Route("/{id}", name="projectstatus_show")
     * @Method("GET")
     */
    public function showAction(projectStatus $projectStatus)
    {
        $deleteForm = $this->createDeleteForm($projectStatus);

        return $this->render('projectstatus/show.html.twig', array(
            'projectStatus' => $projectStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing projectStatus entity.
     *
     * @Route("/{id}/edit", name="projectstatus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, projectStatus $projectStatus)
    {
        $deleteForm = $this->createDeleteForm($projectStatus);
        $editForm = $this->createForm('AppBundle\Form\projectStatusType', $projectStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projectstatus_edit', array('id' => $projectStatus->getId()));
        }

        return $this->render('projectstatus/edit.html.twig', array(
            'projectStatus' => $projectStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a projectStatus entity.
     *
     * @Route("/{id}", name="projectstatus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, projectStatus $projectStatus)
    {
        $form = $this->createDeleteForm($projectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($projectStatus);
            $em->flush();
        }

        return $this->redirectToRoute('projectstatus_index');
    }

    /**
     * Creates a form to delete a projectStatus entity.
     *
     * @param projectStatus $projectStatus The projectStatus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(projectStatus $projectStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projectstatus_delete', array('id' => $projectStatus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
