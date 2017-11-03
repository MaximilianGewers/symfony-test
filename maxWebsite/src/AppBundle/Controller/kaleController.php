<?php

namespace AppBundle\Controller;

use AppBundle\Entity\kale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Kale controller.
 *
 * @Route("kale")
 */
class kaleController extends Controller
{
    /**
     * Lists all kale entities.
     *
     * @Route("/", name="kale_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $kales = $em->getRepository('AppBundle:kale')->findAll();

        return $this->render('kale/index.html.twig', array(
            'kales' => $kales,
        ));
    }

    /**
     * Creates a new kale entity.
     *
     * @Route("/new", name="kale_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $kale = new Kale();
        $form = $this->createForm('AppBundle\Form\kaleType', $kale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kale);
            $em->flush();

            return $this->redirectToRoute('kale_show', array('id' => $kale->getId()));
        }

        return $this->render('kale/new.html.twig', array(
            'kale' => $kale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a kale entity.
     *
     * @Route("/{id}", name="kale_show")
     * @Method("GET")
     */
    public function showAction(kale $kale)
    {
        $deleteForm = $this->createDeleteForm($kale);

        return $this->render('kale/show.html.twig', array(
            'kale' => $kale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing kale entity.
     *
     * @Route("/{id}/edit", name="kale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, kale $kale)
    {
        $deleteForm = $this->createDeleteForm($kale);
        $editForm = $this->createForm('AppBundle\Form\kaleType', $kale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kale_edit', array('id' => $kale->getId()));
        }

        return $this->render('kale/edit.html.twig', array(
            'kale' => $kale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a kale entity.
     *
     * @Route("/{id}", name="kale_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, kale $kale)
    {
        $form = $this->createDeleteForm($kale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kale);
            $em->flush();
        }

        return $this->redirectToRoute('kale_index');
    }

    /**
     * Creates a form to delete a kale entity.
     *
     * @param kale $kale The kale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(kale $kale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kale_delete', array('id' => $kale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
