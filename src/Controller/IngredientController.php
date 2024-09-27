<?php

namespace App\Controller;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ingredient;
use App\Form\IngredientType;
class IngredientController extends AbstractController
{
    //this controller shows all ingredients
    #[Route('/ingredient', name: 'ingredient.index' , methods: ['GET'])]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator ,Request $request): Response
    {
        $ingredients = $paginator->paginate(
        $repository->findAll(),
        $request->query->getInt('page', 1), /*page number*/
        10 
    );
        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients'=>$ingredients
        ]);
    }


    //this controller add a new ingredient
    #[Route('/ingredient/nouveau', name:'ingredient.new', methods: ['GET','POST'])]
    public function new
    (Request $request,
    EntityManagerInterface $manager
    ): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $ingredient = $form ->getData();
           $manager->persist($ingredient);
           $manager->flush();

           $this->addFlash('success','votre ingredient a ete créer avec succees !!');
            return $this->redirectToRoute('ingredient.index');
            
        }
        return $this->render('pages/ingredient/new.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    //this controller edits a ingredient
    #[Route('/ingredient/edition/{id}', name:'ingredient.edit', methods: ['GET','POST'])]
    public function edit(IngredientRepository $repository , int $id,Request $request , EntityManagerInterface $manager): Response 
    {
        $ingredient = $repository->findOneBy(["id"=>$id]);
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $ingredient = $form ->getData();
           $manager->persist($ingredient);
           $manager->flush();

           $this->addFlash('success','votre ingredient a ete modifié avec succees !!');
            return $this->redirectToRoute('ingredient.index');
            
        }
        
        return $this->render(   'pages/ingredient/edit.html.twig',[
            'form' => $form->createView(),
        ]);

    }
    #[Route('/ingredient/suppression/{id}', name: 'ingredient.delete', methods: ['GET'])]
public function delete(IngredientRepository $repository, int $id, EntityManagerInterface $manager): Response
{
    // Fetch the Ingredient entity using the repository and the id
    $ingredient = $repository->findOneBy(["id" => $id]);

    // Remove the ingredient from the database
    $manager->remove($ingredient);
    $manager->flush();

    // Add a success message and redirect
    $this->addFlash('success', 'Ingredient supprimé avec succes');
    return $this->redirectToRoute('ingredient.index');
}

    
}
