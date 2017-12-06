<?php
namespace AdminBundle\Command;

use SiteBundle\Entity\Detalii;
use SiteBundle\Repository\DetaliiRepository;
use Symfony\Bundle\FrameworkBundle\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class PrizeCommand extends ContainerAwareCommand
{
    /** @var  OutputInterface */
    private $output;

    public function configure()
    {
        $this->setName('admin:prize')
            ->setDescription('Acest cron extrageri castigatorii in functie de premiul setat')
            ->addOption('prize', 'p', InputOption::VALUE_REQUIRED, 'Id-ul premiului')
            ->setHelp(
                <<<EOF
Cronul <info>%command.name%</info> Va extrage un castigator random.

Example:
<info>
    <info>%command.full_name%</info> -p '1'
    Comanda de mai sus va extrage un castigator pentru premiul zilnic.
</info>
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Start cron!</comment>');
        $this->output = $output;

        $premiu = $input->getOption('prize');
        $premii = array('1','2','3');

        if (in_array($premiu,$premii)) {

            /** @var EntityManager $em */
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');

            /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
            $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

            /** @var Detalii $inscriere */
            $inscriere = $detaliiRepository->findBy(array('premiu'=> 0));

            $randomKey = array_rand($inscriere);

            /** @var Detalii $castigator */
            $castigator = $inscriere[$randomKey];

            $output->writeln('<comment>Si castigatorul este..</comment>');

            print ucfirst($castigator->getPrenume()).' '.ucfirst($castigator->getNume()). PHP_EOL;

            switch($premiu){
                case '1': $output->writeln('<comment>Pentru premiul pe ora</comment>'); break;
                case '2': $output->writeln('<comment>Pentru premiul pe saptamana</comment>'); break;
                case '3': $output->writeln('<comment>Pentru premiul final</comment>'); break;
            }

            if (!is_null($castigator)) {
                $castigator->setPremiu($premiu);
                $castigator->setModificat(new \DateTime(date('d-m-Y H:i:s')));

                $em->flush();
            }

            $output->writeln('<comment>Done!</comment>');
        } else {
            $output->writeln('<comment>There was an error!</comment>');
        }
    }

}