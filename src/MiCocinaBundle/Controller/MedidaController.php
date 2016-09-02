<?php

namespace MiCocinaBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Debug;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MiCocinaBundle\Entity\Medida;
use MiCocinaBundle\Form\MedidaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Medida controller.
 *
 * @Route("/medidas")
 */
class MedidaController extends Controller
{
    /**
     * Lists all Medida entities.
     *
     * @Route("/", name="medidas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT m FROM MiCocinaBundle:Medida m ORDER BY m.id";
        $medidas = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $medidas = $paginator->paginate(
            $medidas, /* fuente de los datos*/
            $request->query->get('page', 1)/*número de página*/,
            20/*límite de resultados por página*/
        );

        $medida = new Medida();

        /*
        $defaultData = array('message'=>'Type your message here');
        $form = $this->createFormBuilder($defaultData,array(
            'attr'=>array('id'=>'form-all', 'novalidate'=>'novalidate'),
            'action'=>$this->generateUrl('medidas_view') ,
            'method'=>'POST'
        ))
            ->add('isAttending', ChoiceType::class, array(
                'choices'  => array(
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ),
                // *this line is important*
                'choices_as_values' => true,
                'mapped'=> false,
                'expanded'=>true,
                'multiple'=>true,
            ))
            ->getForm();
*/

        $defaultData = array('message' => 'Type your message here' );

        $deleteForm = $this->createDeleteForm($medida);
        $editForm = $this->createForm(MedidaType::class, $medida, array(
            'attr'=>array('id'=>'form-medida', 'class'=>'form-horizontal', 'novalidate'=>'novalidate'),
            'action'=>$this->generateUrl('medidas_edit', array('id'=>':ID')) ,
            'method'=>'POST'
        ));

        return $this->render('MiCocinaBundle:medida:index.html.twig', array(
            'medidas' => $medidas,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new Medida entity.
     *
     * @Route("/new", name="medidas_new", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     * @Method("GET")
     */
    public function newAction(Request $request)
    {
        $medida = new Medida();

        $form = $this->createForm(MedidaType::class, $medida, array(
            'attr'=>array('id'=>'form-medida', 'class'=>'form-horizontal', 'novalidate'=>'novalidate'),
            'action'=>$this->generateUrl('medidas_create') ,
            'method'=>'POST'
        ));

        return new JsonResponse( array(
            'form' => $this->renderView('MiCocinaBundle:template:formulario.html.twig', array(
                'edit_form' => $form->createView()))), 200
        );
    }

    /**
     * Creates a view Medida entity.
     *
     * @Route("/view", name="medidas_view")
     * @Method("POST")
     */
    public function viewAction(Request $request)
    {
        \Doctrine\Common\Util\Debug::dump($request->get('deleteMedidas'));
        exit;
    }
    /**
     * Creates a new Medida entity.
     *
     * @Route("/create", name="medidas_create", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     * @Method("POST")
     */
    public function createAction(Request $request){

        $medida = new Medida();
        $form = $this->createForm(MedidaType::class, $medida);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medida);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Success!',
                'id' => $medida->getId(),
                'nombre'=>$medida->getNombre(),
                'cantidad'=>$medida->getCantidad())
                , 200);
        }

        return new JsonResponse(
            array(
                'message' => 'Error',
                'form' => $this->renderView('MiCocinaBundle:template:formulario.html.twig',
                array('entity' => $medida,'edit_form' => $form->createView(),))),
            400
        );
    }

    /**
     * Displays a form to edit an existing Medida entity.
     *
     * @Route("/{id}/edit", name="medidas_edit", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     * @Method("GET")
     */
    public function editAction(Request $request, Medida $medida)
    {
        $editForm = $this->createForm(MedidaType::class, $medida, array(
            'attr'=>array('id'=>'form-medida', 'class'=>'form-horizontal', 'novalidate'=>'novalidate'),
            'action' => $this->generateUrl('medidas_update', array('id'=>$medida->getId())),
            'method' => 'POST'
        ));

        return $this->render('MiCocinaBundle:template:formulario.html.twig', array(
            'medida' => $medida,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Medida entity.
     *
     * @Route("/{id}/update", name="medidas_update", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     * @Method("POST")
     */
    public function updateAction(Request $request, Medida $medida)
    {
        $editForm = $this->createForm(MedidaType::class, $medida, array(
            'attr'=>array('id'=>'form-medida', 'class'=>'form-horizontal', 'novalidate'=>'novalidate'),
            'action' => $this->generateUrl('medidas_edit', array('id'=>$medida->getId())),
            'method' => 'POST'
        ));
        $editForm->handleRequest($request);

        if($editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($medida);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Success!',
                'id' => $medida->getId(),
                'nombre'=>$medida->getNombre(),
                'cantidad'=>$medida->getCantidad()), 200);
        }

        return new JsonResponse(
            array(
                'message' => 'Error',
                'form' => $this->renderView('MiCocinaBundle:template:formulario.html.twig',
                    array('entity' => $medida,'edit_form' => $editForm->createView(),))),
            400
        );
    }

    /**
     * Deletes a Medida entity.
     *
     * @Route("/{id}", name="medidas_delete", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     * @Method({"DELETE", "POST"})
     */
    public function deleteAction(Request $request, Medida $medida)
    {
        $form = $this->createDeleteForm($medida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medida);
            $em->flush();

            return new JsonResponse(array('message' => 'Success!'), 200);
        }

    }

    /**
     * Creates a form to delete a Medida entity.
     *
     * @param Medida $medida The Medida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medida $medida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medidas_delete', array('id' =>':ID' )))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
