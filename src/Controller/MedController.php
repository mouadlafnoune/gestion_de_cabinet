<?php

namespace App\Controller;

use App\Entity\Med;
use App\Form\MedType;
use App\Repository\MedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/med")
 */
class MedController extends AbstractController
{
    /**
     * @Route("/", name="app_med_index", methods={"GET"})
     */
    public function index(MedRepository $medRepository): Response
    {
        return $this->render('med/index.html.twig', [
            'meds' => $medRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_med_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MedRepository $medRepository): Response
    {
        $med = new Med();
        $form = $this->createForm(MedType::class, $med);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medRepository->add($med, true);

            return $this->redirectToRoute('app_med_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('med/new.html.twig', [
            'med' => $med,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_med_show", methods={"GET"})
     */
    public function show(Med $med): Response
    {
        return $this->render('med/show.html.twig', [
            'med' => $med,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_med_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Med $med, MedRepository $medRepository): Response
    {
        $form = $this->createForm(MedType::class, $med);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medRepository->add($med, true);

            return $this->redirectToRoute('app_med_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('med/edit.html.twig', [
            'med' => $med,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_med_delete", methods={"POST"})
     */
    public function delete(Request $request, Med $med, MedRepository $medRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$med->getId(), $request->request->get('_token'))) {
            $medRepository->remove($med, true);
        }

        return $this->redirectToRoute('app_med_index', [], Response::HTTP_SEE_OTHER);
    }
}
