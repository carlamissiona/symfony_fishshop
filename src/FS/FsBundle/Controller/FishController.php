<?php

namespace FS\FsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FS\FsBundle\Entity\Fish;
use FS\FsBundle\Form\FishType;

/**
 * Fish controller.
 *
 */
class FishController extends Controller
{

    /**
     * Lists all Fish entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FsBundle:Fish')->findAll();

        return $this->render('FsBundle:Fish:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Fish entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Fish();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fish_show', array('id' => $entity->getId())));
        }

        return $this->render('FsBundle:Fish:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Fish entity.
     *
     * @param Fish $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fish $entity)
    {
        $form = $this->createForm(new FishType(), $entity, array(
            'action' => $this->generateUrl('fish_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fish entity.
     *
     */
    public function newAction()
    {
        $entity = new Fish();
        $form   = $this->createCreateForm($entity);

        return $this->render('FsBundle:Fish:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fish entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:Fish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fish entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FsBundle:Fish:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fish entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:Fish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fish entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FsBundle:Fish:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fish entity.
    *
    * @param Fish $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fish $entity)
    {
        $form = $this->createForm(new FishType(), $entity, array(
            'action' => $this->generateUrl('fish_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Fish entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FsBundle:Fish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fish entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fish_edit', array('id' => $id)));
        }

        return $this->render('FsBundle:Fish:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fish entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FsBundle:Fish')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fish entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fish'));
    }

    /**
     * Creates a form to delete a Fish entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fish_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
