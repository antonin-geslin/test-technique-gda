<?php 
namespace App\Controller;

use App\Repository\BooksRepository;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'search')]
    #[IsGranted('ROLE_USER')]
    public function recherche(BooksRepository $repository, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $term = $form->getData()['query'];
            $book = $repository->searchByTitle($term);
            $temps = $book[0]->getAuthors();
            $authors = ' ';
            foreach ($temps as $temp){
                $authors .= $temp->getName() . ', ';
            }
            if ($book) {
                return $this->render('Pages/Search/resultSearch.html.twig', [
                    'book' => $book,
                    'authors' => $authors,
                ]);
            }
        }

        return $this->render('Pages/Search/search.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}

?>