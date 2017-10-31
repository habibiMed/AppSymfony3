<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AdminBundle:Post')->findBy([], [ 'datePublish' =>'desc'], 4,null );


        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);
    }
   
     /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
          $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AdminBundle:Post')->findAll();


        return $this->render('default/blog.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/blog/{id}", name="show_blog")
     */
    public function show($id)
    {
          $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AdminBundle:Post')->find($id);


        return $this->render('default/show.html.twig', [
            'post' => $post,
        ]);
    }

     /**
     * @Route("/contact", name="contact")
     * @Method({"GET" , "POST"})
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder()
                     ->add('from')
                     ->add('subject')
                     ->add('body',TextareaType::class)
                     ->add('send', SubmitType::class)
                     ->getForm();

        $form->handleRequest($request);
                     
          if ($form->isSubmitted())
         {
            $data = $form->getData();
            $message = (new \Swift_Message($data['subject']))
                       ->setFrom($data['from'])
                       ->setTo('habibi.med91@gmail.com')
                       ->setBody($data['body'], 'text/plain');
            $mailer->send($message);           
         }            

        return $this->render('default/contact.html.twig',
            [
              "form" => $form->createView()
            ]);
    }

}
