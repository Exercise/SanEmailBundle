<?php

namespace San\EmailBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;

class EmailSendCRUDController extends CRUDController
{
    /**
     * return the Response object associated to the create action
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();
        if (!($id = $this->get('request')->query->get('id'))) {
            return $this->redirect($this->get('san.admin.email')->generateUrl('list'));
        }

        if ($this->container->getParameter('san_email.manager') == 'orm') {
            $om = $this->getDoctrine()->getManager();
        } else {
            $om = $this->get('doctrine.odm.mongodb.document_manager');
        }

        if (!($email = $om->getRepository('SanEmailBundle:Email')->find($id))) {
            return $this->redirect($this->get('san.admin.email')->generateUrl('list'));
        }

        $object
            ->setTitle($email->getTitle())
            ->setSubject($email->getSubject())
            ->setText($email->getText())
            ->setHtml($email->getHtml())
        ;
        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->admin->create($object);
                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success','flash_create_success');
                if ($this->get('request')->request->get('btn_create_and_send')) {
                    return $this->redirect($this->get('san.admin.email_send')->generateUrl('create', array(
                        'id' => $id
                    )));
                }

                // redirect to edit mode
                return $this->redirect($this->admin->generateUrl('show', array('id' => $object->getId())));
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', 'flash_create_error');
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action'  => 'create',
            'form'    => $view,
            'object'  => $object,
            'emailId' => $id,
        ));
    }
}
