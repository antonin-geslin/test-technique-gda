<?php 
namespace App\Controller;

use App\Repository\LivresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LivresController extends AbstractController
{
    #[Route('/livres', name: 'livres')]
    #[IsGranted('ROLE_USER')]
    public function index(LivresRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $livres = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10 
        );

        return $this->render('Pages/Livres/index.html.twig', [
            'livres' => $livres
        ]);
    }
}


?>