<?php

namespace San\EmailBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
// use Symfony\Component\Form\FormView;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EmailCRUDController extends CRUDController
{
    /**
     * return the Response object associated to the edit action
     *
     *
     * @param mixed $id
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return Response
     */
    // public function editAction($id = null)
    // {
    //     // the key used to lookup the template
    //     $templateKey = 'edit';

    //     $id = $this->get('request')->get($this->admin->getIdParameter());

    //     $object = $this->admin->getObject($id);

    //     if (!$object) {
    //         throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
    //     }

    //     if (false === $this->admin->isGranted('EDIT', $object)) {
    //         throw new AccessDeniedException();
    //     }

    //     $this->admin->setSubject($object);

    //     /** @var $form \Symfony\Component\Form\Form */
    //     $form = $this->admin->getForm();
    //     $form->setData($object);

    //     if ($this->getRestMethod() == 'POST') {
    //         $form->bind($this->get('request'));

    //         $isFormValid = $form->isValid();

    //         // persist if the form was valid and if in preview mode the preview was approved
    //         if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
    //             $this->admin->update($object);

    //             if ($this->isXmlHttpRequest()) {
    //                 return $this->renderJson(array(
    //                     'result'    => 'ok',
    //                     'objectId'  => $this->admin->getNormalizedIdentifier($object)
    //                 ));
    //             }

    //             $this->addFlash('sonata_flash_success', 'flash_edit_success');

    //             // redirect to edit mode
    //             return $this->redirectTo($object);
    //         }

    //         // show an error message if the form failed validation
    //         if (!$isFormValid) {
    //             if (!$this->isXmlHttpRequest()) {
    //                 $this->addFlash('sonata_flash_error', 'flash_edit_error');
    //             }
    //         } elseif ($this->isPreviewRequested()) {
    //             // enable the preview template if the form was valid and preview was requested
    //             $templateKey = 'preview';
    //             $this->admin->getShow();
    //         }
    //     }

    //     $view = $form->createView();

    //     // set the theme for the current Admin Form
    //     $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

    //     return $this->render($this->admin->getTemplate($templateKey), array(
    //         'action' => 'edit',
    //         'form'   => $view,
    //         'object' => $object,
    //     ));
    // }
}
