<?php 
namespace App\Controller;

use App\Entity\User;
use App\Entity\Books;
use App\Entity\Borrows;
use App\Repository\AuthorsRepository;
use App\Repository\BooksRepository;
use App\Repository\BorrowsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BooksController extends AbstractController
{
    #[Route('/livres', name: 'livres')]
    #[IsGranted('ROLE_USER')]
    public function index(BooksRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $books = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10 
        );

        $authorsCollection = [];

        foreach ($books as $book) {
            $authors = $book->getAuthors();
            $temp = '';
            foreach ($authors as $author) {
                $temp .= $author->getName() . ',';
            }
            $authorsCollection[$book->getId()] = $temp;
            $temp = '';
        }
        return $this->render('Pages/Livres/index.html.twig', [
            'books' => $books,
            'authors' => $authorsCollection
        ]);
    }

    #[Route('/emprunts', name: 'show.borrows')]
    #[IsGranted('ROLE_USER')]
    public function seeMyBorrows(): Response
    {
        $borrows = [];
        $user = $this->getUser();
        if( $user instanceof User) {
            $borrows = $user->getBorrows();
        }
        return $this->render('Pages/Livres/showBorrows.html.twig', [
            'borrows' => $borrows,
            'user' => $user
        ]);
    }



    #[Route('/borrow/{bookId}', name: 'make.borrow')]
    #[IsGranted('ROLE_USER')]
    public function makeBorrow(BooksRepository $repository, EntityManagerInterface $entityManager, $bookId): Response
    {

        $user = $this->getUser();
        

        if ($user instanceof User) {
            $borrows = $user->getBorrows();
        }
    
        $book = $repository->find($bookId);

        foreach ($borrows as $borrow) {
            if ($borrow->getBook() === $book->getTitle()) {
                return $this->redirectToRoute('show.borrows');
            }
        }

        if($book->getStock() > 0) {
            $borrow = new Borrows();
            $borrow->setBook($book->getTitle());
            if ($user instanceof User){
                $user->addBorrow($borrow);
                $book->setStock($book->getStock() - 1);
                $entityManager->persist($borrow);
            }
            
            
            
            $entityManager->flush();
        }
        return $this->redirectToRoute('show.borrows');
    }

    #[Route('/rendre/{borrowId}', name: 'return.borrow')]

    public function returnBook(EntityManagerInterface $entityManager, BorrowsRepository $repository,BooksRepository $bookRepo, $borrowId): Response
    {
        $borrow = $repository->find($borrowId);
        $temp = $borrow->getBook();

        $book = $bookRepo->searchByTitle($temp);

        $book[0]->setStock($book[0]->getStock() + 1);


        $user = $this->getUser();

        if ($user instanceof User) {
            $user->removeBorrow($borrow);
        }
        

        $entityManager->remove($borrow);
        $entityManager->flush();

        return $this->redirectToRoute('show.borrows');
    }

    #[Route('/authors/{authorName}', name: 'show.author')]
    public function displayAuthors($authorName, AuthorsRepository $repository): Response
    {
        $authorName = trim($authorName);
        $author = $repository->searchByName($authorName);

;
        $books = $author[0]->getBooks();
    
        return $this->render('Pages/Livres/author.html.twig',[
            'author' => $author,
            'books' => $books
        ]);

    }
}

?>