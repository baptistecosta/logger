<?php

namespace AppBundle\Command;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Nelmio\Alice\Fixtures;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Load fixtures
 */
class LoadFixturesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:load-fixtures');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!in_array($input->getOption('env'), ['dev', 'test'])) {
            throw new \InvalidArgumentException('You must load fixtures in "test" env, or use the --force (-f) flag');
        }

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $output->write('<comment>Purging database... </comment>');
        $purger = new ORMPurger($entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $purger->purge();
        $output->writeln('<info>OK</info>');

        $output->write('<comment>Loading fixtures... </comment>');
        $references = Fixtures::load(
            __DIR__.'../../../tests/_fixtures/_include.yml',
            $entityManager
        );
        $output->writeln('<info>OK</info>');
    }
}
