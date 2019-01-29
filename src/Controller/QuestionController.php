<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route(
     *     "/questions/{id}",
     *     name="question_detail",
     *     requirements={"id": "\d+"}
     *     )
     */
    public function details(int $id)
    {
        // Simplifiable en public function details(Question $question) qui fera le SELECT by Id automatiquement
        $questionRepository = $this->getDoctrine()->getRepository(Question::class);

        $question = $questionRepository->find($id);

        if (!$question) {
            throw $this->createNotFoundException("Cette question n'existe pas !");
        }

        return $this->render('question/detail.html.twig',
            compact("question"));
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