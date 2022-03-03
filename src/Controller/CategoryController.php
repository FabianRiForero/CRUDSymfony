<?php

namespace App\Controller;

use App\Entity\Category;
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

        $category->setName('Jabones');
        $category->setActive(true);
        $category->setCreatedAt(new \DateTimeImmutable('now'));
        $category->setUpdatedAt(new \DateTimeImmutable('now'));

        //entity manager
        $em = $this->getDoctrine()->getManager();

        $em->persist($category);
        $em->flush();

        //return a response
        return $this->redirect($this->generateUrl('category.index'));
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
