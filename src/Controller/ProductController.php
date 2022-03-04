<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request,FileUploader $fileUploader)
    {
        // Create a new Product
        $product = new Product();

        $product->setCreatedAt(new \DateTimeImmutable('now'));
        $product->setUpdatedAt(new \DateTimeImmutable('now'));
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        $form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //entity manager
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request->files->get('product')['image'];
            if($file){
                $filename = $fileUploader->uploadFile($file);

                $product->setImage($filename);
                $em->persist($product);
                $em->flush();
            } else {
                $product->setImage('default-product.svg');
                $em->persist($product);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('product.index'));
        }

        //return a response
        return $this->render('product/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id,ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request,FileUploader $fileUploader,$id,ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        $product->setCreatedAt(new \DateTimeImmutable('now'));
        $product->setUpdatedAt(new \DateTimeImmutable('now'));
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        $form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //entity manager
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request->files->get('product')['image'];
            if($file){
                $filename = $fileUploader->uploadFile($file);

                $product->setImage($filename);
                $em->persist($product);
                $em->flush();
            }
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('product.index'));
        }

        return $this->render('product/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/destroy/{id}", name="destroy")
     */
    public function destroy($id,ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($product);
        $em->flush();

        $this->addFlash('success','Producto eliminado con Exito');

        return $this->redirect($this->generateUrl('product.index'));
    }
}
