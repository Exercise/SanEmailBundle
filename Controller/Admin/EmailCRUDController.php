<?php

namespace San\EmailBundle\Controller\Admin;

use San\EmailBundle\Document\EmailSend as EmailSendDocument;
use San\EmailBundle\Entity\EmailSend as EmailSendEntity;
use San\EmailBundle\Form\Type\EmailSendType;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EmailCRUDController extends CRUDController
{
    /**
     * @param  Request  $request
     * @param  integer  $id
     * @return Response
     */
    public function sendAction(Request $request, $id)
    {
        $templateKey = 'send';
        if (!($object = $this->admin->getObject($id))) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('SEND', $object)) {
            throw new AccessDeniedException();
        }

        if ($this->container->getParameter('san_email.manager') == 'orm') {
            $emailSend = new EmailSendEntity();
            $om = $this->getDoctrine()->getManager();
        } else {
            $om = $this->get('doctrine.odm.mongodb.document_manager');
            $emailSend = new EmailSendDocument();
        }

        $emailSend
            ->setTitle($object->getTitle())
            ->setSubject($object->getSubject())
            ->setText($object->getText())
            ->setHtml($object->getHtml())
        ;
        $form = $this->createForm(new EmailSendType(), $emailSend);
        if ($request->isMethod('POST')) {
            $emailSend->setIsTest((bool) $request->request->get('btn_test'));
            $form->handleRequest($request);
            if ($form->isValid()) {
                $om->persist($emailSend);
                $om->flush();

                return $this->redirect($this->get('san.admin.email_send')->generateUrl('list'));
            }
        }

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'send',
            'form'   => $form->createView(),
            'object' => $emailSend,
            'email'  => $object
        ));
    }
}
