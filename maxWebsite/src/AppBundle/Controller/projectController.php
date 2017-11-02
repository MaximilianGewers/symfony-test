<?php

namespace AppBundle\Controller;

use AppBundle\Entity\project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Project controller.
 *
 * @Route("project")
 */
class projectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/", name="project_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:project')->findAll();

        return $this->render('project/index.html.twig', array(
            'projects' => $projects,
        ));
    }

    /**
     * Creates a new project entity.
     *
     * @Route("/new", name="project_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // Get status
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('AppBundle:projectStatus')->findAll();

        $project = new Project();
        $form = $this->createForm('AppBundle\Form\projectType', $project);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //# Deal with the status
            ////Get the from data
            //$data = $form->getData();
            //$status1 = $data['status'];
            //$project->setStatus($status1); //HERE
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }

        return $this->render('project/new.html.twig', array(
            'project' => $project,
            'status' => $status,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{id}", name="project_show")
     * @Method("GET")
     */
    public function showAction(project $project)
    {
        $deleteForm = $this->createDeleteForm($project);

        return $this->render('project/show.html.twig', array(
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{id}/edit", name="project_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, project $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('AppBundle\Form\projectType', $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', array('id' => $project->getId()));
        }

        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     * @Route("/{id}", name="project_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, project $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param project $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
