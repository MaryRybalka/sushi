<?php

namespace App\Controller;

use App\Entity\Gunkan;
use App\Form\GunkanType;
use App\Repository\GunkanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gunkan")
 */
class GunkanController extends AbstractController
{
    /**
     * @Route("/", name="gunkan_index", methods={"GET"})
     */
    public function index(GunkanRepository $gunkanRepository): Response
    {
//        return $this->render('gunkan/index.html.twig', [
//            'gunkans' => $gunkanRepository->findAll(),
//        ]);
    }

    /**
     * @Route("/new", name="gunkan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gunkan = new Gunkan();
        $form = $this->createForm(GunkanType::class, $gunkan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gunkan);
            $entityManager->flush();

            return $this->redirectToRoute('gunkan_index');
        }

//        return $this->render('gunkan/new.html.twig', [
//            'gunkan' => $gunkan,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="gunkan_show", methods={"GET"})
     */
    public function show(Gunkan $gunkan): Response
    {
//        return $this->render('gunkan/show.html.twig', [
//            'gunkan' => $gunkan,
//        ]);
    }

    /**
     * @Route("/{id}/edit", name="gunkan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gunkan $gunkan): Response
    {
        $form = $this->createForm(GunkanType::class, $gunkan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gunkan_index');
        }

//        return $this->render('gunkan/edit.html.twig', [
//            'gunkan' => $gunkan,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="gunkan_delete", methods={"POST"})
     */
    public function delete(Request $request, Gunkan $gunkan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gunkan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gunkan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gunkan_index');
    }
}
