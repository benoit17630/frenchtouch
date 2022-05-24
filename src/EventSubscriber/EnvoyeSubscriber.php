<?php

namespace App\EventSubscriber;

use App\Entity\Envoye;
use App\Entity\Stock;
use App\Repository\StockRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EnvoyeSubscriber implements EventSubscriberInterface
{
    private StockRepository $stockRepository;
    private EntityManagerInterface $manager;


    public function __construct(StockRepository $stockRepository, EntityManagerInterface $manager)
    {
        $this->stockRepository = $stockRepository;

        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class=>['setStock'],
            AfterEntityDeletedEvent::class =>['removeStock']
        ];
    }

    public function setStock(BeforeEntityPersistedEvent $event)
    {
        $stock = $this->stockRepository->findLast();

        $entity = $event->getEntityInstance();
        if ($entity instanceof Envoye)
        {
            $now = new \DateTime("now");
            $entity->setCreatedAt($now)->setStock($stock);

            $stockNew = new Stock();
            $stockNew
                ->setCash($stock->getCash() - $entity->getCash())
                ->setMunition($stock->getMunition() - $entity->getMunition())
                ->setMarchandise($stock->getMarchandise() - $entity->getMarchandise())
                ->setMetal($stock->getMetal() - $entity->getMetal())
                ->setDiamant($stock->getDiamant() - $entity->getDiamant());
            $this->manager->persist($stockNew);


        }
        return;
    }

    public function removeStock(AfterEntityDeletedEvent $deletedEvent)
    {
        $entity = $deletedEvent->getEntityInstance();
        if ($entity instanceof Envoye)
        {
            $stock = $this->stockRepository->findLast();

            $stockNew = new Stock();
            $stockNew
                ->setCash( $stock->getCash() + $entity->getCash())
                ->setMunition( $stock->getMunition() + $entity->getMunition())
                ->setMarchandise( $stock->getMarchandise() + $entity->getMarchandise())
                ->setMetal( $stock->getMetal() + $entity->getMetal())
                ->setDiamant( $stock->getDiamant() + $entity->getDiamant())
            ;

            $this->manager->persist($stockNew);
            $this->manager->flush();
        }
        return;
    }
}