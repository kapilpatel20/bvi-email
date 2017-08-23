<?php

namespace BviEmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BviEmailBundle\Entity\Email;
use BviEmailBundle\Form\EmailForm;
use DateTime;

class EmailController extends Controller {

    public function indexAction(Request $request) {
        
        $lstObj = $this->prepareListObj($request);
        $lstObj->setTemplate('BviEmailBundle:AjaxPagination:ajax_pagination.html.twig');
        
        if ($request->isXmlHttpRequest()) {
            
            $listView          =  $this->renderView('BviEmailBundle:Email:_list.html.twig',array('lstObj' => $lstObj));
            $output['success'] = true;
            $output['listView']= $listView;
            $response = new Response(json_encode($output));
            return $response;
            
        }else{
            return $this->render('BviEmailBundle:Email:index.html.twig',array('lstObj' => $lstObj));
        }
        
    }
    
    //prepare list object
    public function prepareListObj(Request $request) {
        
        $em        = $this->getDoctrine()->getManager();
        $params    = $this->get('request')->request->all();
        
        $qry       = $em->getRepository('BviEmailBundle:Email')->getList($params);

        $itmPerPge = 20;
        // Creating pagnination
        $pagination = $this->get('knp_paginator')->paginate(
                $qry, $this->get('request')->query->get('page', 1), $itmPerPge
        );
        
        return $pagination;
    }
    
    //add email template
    
    public function newAction(Request $request) {
        
        $objMail = new Email();
        $form = $this->createForm(new EmailForm(), $objMail);
        
        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $objMail->setKey();
                $objMail->setCreatedat(new DateTime());
                $user = $this->get('security.context')->getToken()->getUser();
                if (is_object($user)) {
                    $objMail->setCreatedby($user->getId());
                }else{
                    $objMail->setCreatedby(1);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($objMail);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', "Record has been added successfully.");
                return $this->redirect($this->generateUrl('bvi_email_list'));
            }
        }
        
        return $this->render('BviEmailBundle:Email:new.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    //edit mail page
    
    public function editAction(Request $request,$id = '') {
        
        $em = $this->getDoctrine()->getManager();
        $objMail = $em->getRepository('BviEmailBundle:Email')->find($id);
        
        if (!$objMail) {

            $this->get('session')->getFlashBag()->add('failure', "Email template does not exist.");
            return $this->redirect($this->generateUrl('bvi_email_list'));
        }
        $form = $this->createForm(new EmailForm(), $objMail);

        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $objMail->setUpdatedat(new DateTime());
                $user = $this->get('security.context')->getToken()->getUser();
                if (is_object($user)) {
                    $objMail->setUpdatedby($user->getId());
                }
                $em->persist($objMail);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', "Record has been updated successfully.");
                return $this->redirect($this->generateUrl('bvi_email_list'));
            }
        }
        return $this->render('BviEmailBundle:Email:edit.html.twig', array(
                    'form' => $form->createView(),'objMail' => $objMail
        ));
    }
    
    //update status of email template
    
    public function updateStatusAction(Request $request) {
        
        $em     = $this->getDoctrine()->getManager();
        $id     = $request->get('id');
        $objMail = $em->getRepository('BviEmailBundle:Email')->find($id);
        $success= false;
        
        if (is_object($objMail)) {
            
            $status = $objMail->getStatus() == 'Active' ? 'Inactive' : 'Active';
            $objMail->setStatus($status);
            $objMail->setUpdatedat(new DateTime());
            $user = $this->get('security.context')->getToken()->getUser();
            if (is_object($user)) {
                $objMail->setUpdatedby($user->getId());
            }
            $em->persist($objMail);
            $em->flush();
            $success = true;
        }
        
        $output['success'] = $success;
        $output['msg']     = 'Record updated successfully';
        $response          = new Response(json_encode($output));
        return $response;
    }    
    
}    
    