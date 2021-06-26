<?php

namespace App\Controller;

use App\Entity\Sashimi;
use App\Form\SashimiType;
use App\Repository\SashimiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sashimi")
 */
class SashimiController extends AbstractController
{
    /**
     * @Route("/", name="sashimi_index", methods={"GET"})
     */
    public function index(SashimiRepository $sashimiRepository): Response
    {
//        return $this->render('sashimi/index.html.twig', [
//            'sashimis' => $sashimiRepository->findAll(),
//        ]);
    }

    /**
     * @Route("/new", name="sashimi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sashimi = new Sashimi();
        $form = $this->createForm(SashimiType::class, $sashimi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sashimi);
            $entityManager->flush();

            return $this->redirectToRoute('sashimi_index');
        }

//        return $this->render('sashimi/new.html.twig', [
//            'sashimi' => $sashimi,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="sashimi_show", methods={"GET"})
     */
    public function show(Sashimi $sashimi): Response
    {
//        return $this->render('sashimi/show.html.twig', [
//            'sashimi' => $sashimi,
//        ]);
    }

    /**
     * @Route("/{id}/edit", name="sashimi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sashimi $sashimi): Response
    {
        $form = $this->createForm(SashimiType::class, $sashimi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sashimi_index');
        }

//        return $this->render('sashimi/edit.html.twig', [
//            'sashimi' => $sashimi,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="sashimi_delete", methods={"POST"})
     */
    public function delete(Request $request, Sashimi $sashimi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sashimi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sashimi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sashimi_index');
    }
}
