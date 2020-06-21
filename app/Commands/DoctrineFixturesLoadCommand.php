<?php


namespace App\Commands;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DoctrineFixturesLoadCommand extends Command
{

    protected function configure()
    {
        $this->setName('doctrine:fixtures:load')
            ->setDescription('Load data fixtures to your database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        $loader = new Loader();
        $loader->loadFromDirectory(app_path('DataFixtures'));
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());

        return 0;
    }
}