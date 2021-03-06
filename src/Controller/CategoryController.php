<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category.")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        // Create a new category
        $category = new Category();

        $category->setCreatedAt(new \DateTimeImmutable('now'));
        $category->setUpdatedAt(new \DateTimeImmutable('now'));
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl('category.index'));
        }

        //return a response
        return $this->render('category/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Request $request
     * @return Response
     */
    public function show($id,CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        // create the show view
        return $this->render('category/show.html.twig',[
            'category' => $category
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request,$id,CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        $category->setCreatedAt(new \DateTimeImmutable('now'));
        $category->setUpdatedAt(new \DateTimeImmutable('now'));
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl('category.index'));
        }

        //return a response
        return $this->render('category/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/destroy/{id}",name="destroy")
     * @param CategoryRepository $categoryRepository
     * @return RedirectResponse
     */
    public function destroy($id,CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($category);
        $em->flush();

        $this->addFlash('success','La categoria se elimino con exito');

        return $this->redirect($this->generateUrl('category.index'));
    }
}
