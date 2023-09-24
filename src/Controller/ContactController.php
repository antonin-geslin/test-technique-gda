<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class ContactController extends AbstractController 
{
    #[Route('/contact', name: 'app.contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        if ($this->getUser()) {
            $user = $this->getUser();
            $contact->setPseudo($user->getPseudo());
            $contact->setEmail($user->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            
            $manager->persist($contact);
            $manager->flush();

            $email = (new Email())
                    ->from($contact->getEmail())
                    ->to('admin@biblio.com')
                    ->subject($contact->getSubject())
                    ->html($contact->getMessage());
            
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('app.contact');
        }

        return $this->render('Pages/Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
?>