<?php
namespace AdminBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class PrizeService extends CronService
{
    /**
     * @var Registry
     */
    protected $doctrine;
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var Translator
     */
    protected $translator;
    /**
     * @var OutputInterface
     */
    protected $output;

    /** @var  Logger $logger */
    protected $logger;

    /**
     * @param Container $container
     * @param Logger $logger
     */
    public function __construct(Container $container, Logger $logger)
    {
        $this->container = $container;
        $this->logger = $logger;

        $this->doctrine = $this->container->get('doctrine');
        $this->translator = $this->container->get('translator');

        $this->output = null;
    }

    /**
     * @param OutputInterface $output
     */
    private function setOutputInterface(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @return OutputInterface
     */
    private function getOutputInterface()
    {
        return $this->output;
    }

    /**
     * @param string $message
     */
    private function writeln($message, $type = null)
    {
        if ($this->getOutputInterface() != null) {
            if ($type === null) {
                $type = 'info';
            }

            $this->getOutputInterface()->writeln("<{$type}>[" . date("Y-m-d H:i:s") . "]</{$type}> > " . print_r($message, true));
        }
    }

    private function logUsedMemory()
    {
        $usedMemory = round(memory_get_usage(true) / 1048576, 4) . 'M';

        $this->writeln('Used memory ' . $usedMemory);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws EisException
     * @throws \Exception
     */
    public function searchOrdersCronAction(InputInterface $input, OutputInterface $output)
    {
        $this->setOutputInterface($output);

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var CountryCharacteristicsService $countryCharacteristicsService */
        $countryCharacteristicsService = $this->getContainer()->get('eis.order.country_characteristics');
        /** @var CustomerOrderService $customerOrderService */
        $customerOrderService = $this->getContainer()->get("eis.order.customer_order");
        /** @var CustomerOrderRepository $customerOrderRepository */
        $customerOrderRepository = $em->getRepository("EisOrderBundle:CustomerOrder");

        $allegroOrders = $customerOrderRepository->getAllegroStandbyOrders();

        $allocated = array();
        /** @var CustomerOrder $allegroOrder */
        foreach ($allegroOrders as $allegroOrder) {

            $now = new \DateTime();
            $orderDate = $allegroOrder->getCreated();
            $diff = $now->diff($orderDate);
            $hours = $diff->days * 24 + $diff->h;

            $allegroWaitTime = $countryCharacteristicsService->get('ALLEGRO_ORDERS_WAIT_TIME', $allegroOrder->getLocale()->getCountry()->getId());

            if ($hours >= $allegroWaitTime) {
                try {
                    $customerOrderService->allocateToRetail($allegroOrder, "Allegro order after sale form not received.");
                    $allocated[] = $allegroOrder->getId();
                } catch (EisException $e) {
                    $this->writeln($e->getMessage(), "error");
                }
            }
        }
        $this->writeln("Allocated " . count($allocated) . " order(s). [" . implode(",", $allocated) . "]");
        $this->logUsedMemory();
    }
}
