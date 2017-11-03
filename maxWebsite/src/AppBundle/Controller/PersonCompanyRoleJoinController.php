<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PersonCompanyRoleJoin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Personcompanyrolejoin controller.
 *
 * @Route("personcompanyrolejoin")
 */
class PersonCompanyRoleJoinController extends Controller
{
    /**
     * Lists all personCompanyRoleJoin entities.
     *
     * @Route("/", name="personcompanyrolejoin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $personCompanyRoleJoins = $em->getRepository('AppBundle:PersonCompanyRoleJoin')->findAll();

        return $this->render('personcompanyrolejoin/index.html.twig', array(
            'personCompanyRoleJoins' => $personCompanyRoleJoins,
        ));
    }

    /**
     * Creates a new personCompanyRoleJoin entity.
     *
     * @Route("/new", name="personcompanyrolejoin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $personCompanyRoleJoin = new Personcompanyrolejoin();
        $form = $this->createForm('AppBundle\Form\PersonCompanyRoleJoinType', $personCompanyRoleJoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personCompanyRoleJoin);
            $em->flush();

            return $this->redirectToRoute('personcompanyrolejoin_show', array('id' => $personCompanyRoleJoin->getId()));
        }

        return $this->render('personcompanyrolejoin/new.html.twig', array(
            'personCompanyRoleJoin' => $personCompanyRoleJoin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a personCompanyRoleJoin entity.
     *
     * @Route("/{id}", name="personcompanyrolejoin_show")
     * @Method("GET")
     */
    public function showAction(PersonCompanyRoleJoin $personCompanyRoleJoin)
    {
        $deleteForm = $this->createDeleteForm($personCompanyRoleJoin);

        return $this->render('personcompanyrolejoin/show.html.twig', array(
            'personCompanyRoleJoin' => $personCompanyRoleJoin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing personCompanyRoleJoin entity.
     *
     * @Route("/{id}/edit", name="personcompanyrolejoin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PersonCompanyRoleJoin $personCompanyRoleJoin)
    {
        $deleteForm = $this->createDeleteForm($personCompanyRoleJoin);
        $editForm = $this->createForm('AppBundle\Form\PersonCompanyRoleJoinType', $personCompanyRoleJoin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personcompanyrolejoin_edit', array('id' => $personCompanyRoleJoin->getId()));
        }

        return $this->render('personcompanyrolejoin/edit.html.twig', array(
            'personCompanyRoleJoin' => $personCompanyRoleJoin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a personCompanyRoleJoin entity.
     *
     * @Route("/{id}", name="personcompanyrolejoin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PersonCompanyRoleJoin $personCompanyRoleJoin)
    {
        $form = $this->createDeleteForm($personCompanyRoleJoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personCompanyRoleJoin);
            $em->flush();
        }

        return $this->redirectToRoute('personcompanyrolejoin_index');
    }

    /**
     * Creates a form to delete a personCompanyRoleJoin entity.
     *
     * @param PersonCompanyRoleJoin $personCompanyRoleJoin The personCompanyRoleJoin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PersonCompanyRoleJoin $personCompanyRoleJoin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personcompanyrolejoin_delete', array('id' => $personCompanyRoleJoin->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
