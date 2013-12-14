<?php
// src/Sonata/Bundle/DemoBundle/Controller/CRUDController.php

namespace Sonata\Bundle\DemoBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDController extends Controller
{
  public function cloneAction()
  {
    $id = $this->get('request')->get($this->admin->getIdParameter());

    $object = $this->admin->getObject($id);

    if (!$object) {
      throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
    }

    $clonedObject = clone $object;
    $clonedObject->setName($object->getName()." (Clone)");

    $this->admin->create($clonedObject);

    $this->addFlash('sonata_flash_success', 'Cloned successfully');

    return new RedirectResponse($this->admin->generateUrl('list'));
  }
}