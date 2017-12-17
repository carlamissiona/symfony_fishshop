<?php

namespace FS\FsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FS\FsBundle\Entity\FishFeeds;
use FS\FsBundle\Form\FishFeedsType;

/**
 * FishFeeds controller.
 *
 */
class FishFeedsController extends Controller
{

    /**
     * Lists all FishFeeds entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FsBundle:FishFeeds')->findAll();

        return $this->render('FsBundle:FishFeeds:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FishFeeds entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FishFeeds();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fishfeeds_show', array('id' => $entity->getId())));
        }

        return $this->render('FsBundle:FishFeeds:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FishFeeds entity.
     *
     * @param FishFeeds $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FishFeeds $entity)
    {
        $form = $this->createForm(new FishFeedsType(), $entity, array(
            'action' => $this->generateUrl('fishfeeds_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FishFeeds entity.
     *
     */
    public function newAction()
    {
        $entity = new FishFeeds();
        $form   = $this->createCreateForm($entity);

        return $this->render('FsBundle:FishFeeds:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FishFeeds entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:FishFeeds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FishFeeds entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FsBundle:FishFeeds:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FishFeeds entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:FishFeeds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FishFeeds entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FsBundle:FishFeeds:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FishFeeds entity.
    *
    * @param FishFeeds $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FishFeeds $entity)
    {
        $form = $this->createForm(new FishFeedsType(), $entity, array(
            'action' => $this->generateUrl('fishfeeds_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FishFeeds entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:FishFeeds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FishFeeds entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fishfeeds_edit', array('id' => $id)));
        }

        return $this->render('FsBundle:FishFeeds:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FishFeeds entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FsBundle:FishFeeds')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FishFeeds entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fishfeeds'));
    }

    /**
     * Creates a form to delete a FishFeeds entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fishfeeds_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
