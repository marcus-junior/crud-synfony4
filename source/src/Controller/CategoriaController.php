<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use http\Env\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriaController extends Controller
{
    /**
     * @Route("/categoria", name="categoria")
     */
    public function index()
    {
        $categorias = $this->getDoctrine()->getRepository(Categoria::class)->findAll();

        return $this->render(
            'categoria/index.html.twig',[
                'categorias' => $categorias
            ]);

        /** return json
         * return $this->json(['categorias' => $categorias],200);
         */
    }

    /**
     * @Route("/categoria/new", name="categoria_new")
     */
    public function new(\Symfony\Component\HttpFoundation\Request $request)
    {
        $form = $this->createForm(CategoriaType::class, new Categoria());
        $form->add('Adicionar', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $categoria = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('categoria');
        }

        return $this->render('categoria/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/categoria/edit/{id}", name="categoria_edit")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function edit(\Symfony\Component\HttpFoundation\Request $request, $id)
    {

        $categoria = $this->getDoctrine()->getRepository(Categoria::class)->find($id);
        if(is_null($categoria))
            throw new \Exception("A categoria não foi encontrada para edição");

        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->add('Salvar Alteração', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $categoria = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('categoria');
        }

        return $this->render('categoria/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categoria/delete/{id}", name="categoria_delete")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $categoria = $this->getDoctrine()->getRepository(Categoria::class)->find($id);
        if(is_null($categoria))
            throw new \Exception("A categoria não foi encontrada para deleção");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categoria);
        $entityManager->flush();

        return $this->redirectToRoute('categoria');
    }
}
