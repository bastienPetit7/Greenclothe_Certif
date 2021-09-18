<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $search = new Search; 
        $form = $this->createForm(SearchType::class, $search); 

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $products = $productRepository->findWithSearch($search);
        } else {
            
            $products = $productRepository->findAll();
        }


        return $this->render('product/index.html.twig', [
            'products' => $products, 
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataImage = $form->get('image')->getData(); 

            if($dataImage)
            {
                $originalFileName = pathinfo($dataImage->getClientOriginalName(), PATHINFO_FILENAME); 
                $safeFileName = $slugger->slug($originalFileName); 
                $newFileName = $safeFileName. '-' . uniqid() . '.' . $dataImage->guessExtension(); 

                $dataImage->move(
                    $this->getParameter('app_images_directory_products'),
                    $newFileName
                ); 

                $product -> setImage('/assets/ressources/img/uploads/products/'. $newFileName);

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="product_show", methods={"GET"})
     */
    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBySlug($slug); 

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
