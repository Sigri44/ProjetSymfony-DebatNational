<?php

namespace App\Command;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FixturesCommand extends Command
{
    protected static $defaultName = 'app:fixtures';
    protected $em = null;

    public function __construct(EntityManagerInterface $em, ?string $name = null)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Load dummy data in our database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Bienvenue sur la fixtures !');

        $io->text("Now loading fixtures...");

        $faker = \Faker\Factory::create('fr_FR');

        $conn = $this->em->getConnection();
        $conn->query('TRUNCATE question');

        for ($i=0; $i<10; $i++) {
            $question = new Question();
            $question->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $question->setDescription($faker->realText(600));
            $question->setStatus($faker->randomElement(['debating','voting','closed']));
            $question->setCreationDate($faker->dateTimeBetween('- 1 year', 'now'));
            $question->setSupports($faker->numberBetween(0,20000000));

            $this->em->persist($question);
        }

        $this->em->flush();
    }
}
