<?php

namespace App\Controller;

use App\Entity\Lists;
use App\Form\ListsType;
use App\Repository\ListsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @Route("/lists")
 */
class ListsController extends AbstractController
{
    /**
     * @Route("/", name="lists_index", methods={"GET"})
     */
    public function index(ListsRepository $listsRepository): Response
    {

        return $this->render('lists/index.html.twig', [
            'lists' => $listsRepository->findAll()
            ]);

    }


    /**
     * @Route("/new", name="lists_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $list = new Lists();
        $list->setAuthorId($this->getUser());
        $form = $this->createForm(ListsType::class, $list);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($list);
            $entityManager->flush();

            return $this->redirectToRoute('lists_index');
        }

        return $this->render('lists/new.html.twig', [
            'list' => $list,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lists_show", methods={"GET"})
     */
    public function show(Lists $list): Response
    {

        return $this->render('lists/show.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lists_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lists $list): Response
    {
        $form = $this->createForm(ListsType::class, $list);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lists_index', [
                'id' => $list->getId(),
            ]);
        }

        return $this->render('lists/edit.html.twig', [
            'list' => $list,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lists_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lists $list): Response
    {
        if ($this->isCsrfTokenValid('delete'.$list->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($list);
            $entityManager->flush();
        }

    return $this->redirectToRoute('lists_index');
    }
}
