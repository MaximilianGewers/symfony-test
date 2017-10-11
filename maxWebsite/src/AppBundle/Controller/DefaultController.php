<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Projectx;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("test", name="test")
     */
    public function testPage()
    {
        return $this->render('default/test.html.twig');
    }

    /**
     * @Route("projects/create", name="createProject")
     */
    public function createProjectController(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add("ProjectName", TextType::class)
            ->add("ProjectDescription", TextareaType::class)
            ->add("Submit", SubmitType::class, [
            "label" => "Submit now",
            "attr" => [
                "class" => "btn btn-success"
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $toAdd = new Projectx();
            $toAdd->setProjectName($data['ProjectName']);
            $toAdd->setDescription($data['ProjectDescription']);

            $em->persist($toAdd);
            $em->flush();

            return $this->redirectToRoute("projectList");
        }

        $projects = $em->getRepository('AppBundle:Projectx')->findAll();

        dump($projects);
        return $this->render("default/form.html.twig", [
            "my_form" => $form->createView(),
            "list" => $projects
            ]);
    }

    /**
     * @Route("projects", name="projectList")
     */
    public function viewProjectController(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:Projectx')->findAll();

        dump($projects);
        return $this->render("default/list.html.twig", [
            "list" => $projects
            ]);
    }

    /**
     * @Route("projects/{slug}", name=" ")
     */
    public function EditProjectController($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:Projectx')->findOneBy(array('id' => $slug));

        dump($projects);
        return $this->render("default/listOne.html.twig", [
            "list" => $projects
            ]);
    }
}
