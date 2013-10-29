<?php

namespace San\EmailBundle\Controller;

use San\EmailBundle\Entity\EmailSend;
use San\EmailBundle\Form\Type\EmailSendType;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends CRUDController
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

        $emailSend = new EmailSend();
        $emailSend->setEmail($object);
        $form = $this->createForm(new EmailSendType(), $emailSend);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($emailSend);
                $em->flush();

                return $this->redirect($this->get('san.admin.email_send')->generateUrl('list'));
            }
        }

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'send',
            'form'   => $form->createView(),
            'object' => $emailSend,
        ));
    }
}
