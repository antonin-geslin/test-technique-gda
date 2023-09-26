<?php 

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibrarianController extends AbstractController
{
    #[Route('/librarian/home', name: 'librarian.home')]

    #[IsGranted('ROLE_LIBRARIAN')]
    public function index(): Response
    {
        return $this->render('Pages/librarian/home.html.twig');
    }
}


?>