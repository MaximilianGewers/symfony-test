<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Projectx;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use AppBundle\Form\PersonType;

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
     * @Route("projects/{slug}", name="projectEdit")
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

    /**
     * @Route("admin/allUsers", name="ListAllUsers")
     */
    public function AdminAllUsers(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        dump($users);

        return $this->render('default/admin.allUsers.html.twig', array(
            "users" => $users,
        ));
    }

    /**
     * @Route("admin/allUsers/edit/{slug}", name="EditUser")
     */
    public function AdminEditUser(Request $request, $slug)
    {
        #Loading Single person on page
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $slug));
        dump($user);

        #get the person
        $userPerson = $user->getPerson();
        #IF person has a name
        $personNameField = "";
        if (!is_null($userPerson))
        {
        	$personNameField = $userPerson->getName();
        }


        #creating a form for person
        $form = $this->createFormBuilder()
        ->add("userName", TextType::class, [
        "data" => $user->getUserName()
        ])
        ->add("Name", TextType::class, [
        "data" => $personNameField
        ])
        ->add("Submit", SubmitType::class, [
        "label" => "Submit now",
        "attr" => [
            "class" => "btn btn-success"
            ]
        ])
        ->getForm();

        #Handle Request
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $user->setUserName($data['userName']);

            #if person has a name
            if (!is_null($userPerson))
            {
                $userPerson->setName($data['Name']);
                $em->persist($userPerson);
                $em->flush();
            }
            else #person does not exist yet
            {
                $newPerson = new Person();
                $newPerson->setName($data['Name']);
                $user->setPerson($newPerson);
                $em->persist($newPerson);
                $em->flush();
            }


            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("ListAllUsers");
        }

        #how to deal and load person???

        return $this->render('default/admin.allUsers.edit.html.twig', array(
            "form" => $form->createView(),
        ));
    }

}
