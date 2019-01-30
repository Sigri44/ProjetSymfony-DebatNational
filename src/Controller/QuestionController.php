<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Question;
use App\Form\MessageType;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route(
     *    "/questions/ajouter",
     *    name="question_create",
     *    methods={"GET", "POST"}
     *    )
     */
    public function create(Request $request)
    {
        $question = new Question();
        $questionForm = $this->createForm(QuestionType::class, $question);
        $questionForm->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            //crée un message flash à afficher sur la prochaine page
            $this->addFlash('success', 'Merci pour votre participation !');

            //redirige vers la page de détails de cette question
            return $this->redirectToRoute('question_detail', ['id' => $question->getId()]);
        }

        return $this->render('question/create.html.twig', [
            "questionForm" => $questionForm->createView()
        ]);
    }

    // Simplifiable en public function details(Question $question) qui fera le SELECT by Id automatiquement
    /**
     * @Route(
     *     "/questions/{id}",
     *     name="question_detail",
     *     requirements={"id": "\d+"}
     *     )
     */
    public function details(int $id, Request $request)
    {
        $questionRepository = $this->getDoctrine()->getRepository(Question::class);

        $question = $questionRepository->find($id);

        if (!$question) {
            throw $this->createNotFoundException("Cette question n'existe pas !");
        }

        //return $this->render('question/detail.html.twig', compact("question"));

        // Affichage et traitement du formulaire "question_detail"
        // Liste des messages
        $messages = $question->getMessages();

        // Formulaire de dépôt de message
        $messageM = new Message();
        $messageM->setQuestion($question);
        $messageForm = $this->createForm(MessageType::class, $messageM);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($messageM);
            $em->flush();

            $this->addFlash('success', 'Votre message vient d\'être ajouté.');

            return $this->redirectToRoute('question_detail', ['id' => $question->getId()]);
        }

        return $this->render('question/detail.html.twig', [
            "question" => $question,
            "messages" => $messages,
            "messageForm" => $messageForm->createView()
        ]);
    }

    /**
     * @Route("/questions/liste",
     *     name="question_list"),
     *     methods={"GET"}
     */
    public function list()
    {
        //ce repository nous permet de faire des SELECT
        $questionRepository = $this->getDoctrine()->getRepository(Question::class);

        //SELECT * FROM question WHERE status = 'debating' ORDER BY supports DESC LIMIT 1000
        $questions = $questionRepository->findBy(
            ['status' => 'debating'], //where
            ['supports' => 'DESC'], //order by
            1000, //limit
            0 //offset
        );

        return $this->render('question/list.html.twig', array(
            'questions' => $questions,
        ));
    }
}