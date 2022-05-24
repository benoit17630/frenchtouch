<?php

namespace App\EventSubscriber;

use App\Entity\Don;

use App\Entity\Stock;
use App\Repository\StockRepository;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DonSubscriber implements EventSubscriberInterface
{
    private StockRepository $stockRepository;
    private EntityManagerInterface $manager;

    public function __construct(StockRepository $stockRepository, EntityManagerInterface $manager)
    {
        $this->stockRepository = $stockRepository;
        $this->manager = $manager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ["setStock"],
            AfterEntityDeletedEvent::class =>['removeDon']

        ];
    }


    public function setStock(BeforeEntityPersistedEvent $event)
    {
        $stock = $this->stockRepository->findLast();

        $entity = $event->getEntityInstance();
        if ($entity instanceof Don)
        {
            $entity->setStock($stock);
            $stockNew = new Stock();
            $stockNew->setCash($entity->getCash() + $stock->getCash());

            $this->manager->persist($stockNew);
        }
        return;

    }

    public function removeDon(AfterEntityDeletedEvent $deletedEvent)
    {
        $stock = $this->stockRepository->findLast();
        $entity = $deletedEvent->getEntityInstance();
        if ($entity instanceof Don)
        {
            $stock = $this->stockRepository->findLast();
            $stockNew = new Stock();
            $stockNew->setCash( $stock->getCash()-$entity->getCash());

            $this->manager->persist($stockNew);
            $this->manager->flush();

        }
        return;

    }


}