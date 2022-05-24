<?php

namespace App\EventSubscriber;

use App\Entity\Don;

use App\Entity\Stock;
use App\Repository\StockRepository;

use DateTime;
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
            $taxe = $entity->getUser()->getTaxe() / 100;

            $now = new DateTime('now');
            $entity->setCreatedAt($now);
            $entityCash= $entity->getCash() - $entity->getCash() * $taxe;
            $entityMuni= $entity->getMunition() - $entity->getMunition() * $taxe;
            $entityMarchandise= $entity->getMarchandise() - $entity->getMarchandise() *$taxe ;
            $entityMetal = $entity->getMetal() - $entity->getMetal() * $taxe;
            $entityDiam=$entity->getDiamant() - $entity->getDiamant() * $taxe ;


            $entity->setStock($stock);
            $stockNew = new Stock();
            $stockNew
                ->setCash($entityCash + $stock->getCash())
                ->setMunition($entityMuni + $stock->getMunition())
                ->setMarchandise($entityMarchandise + $stock->getMarchandise())
                ->setMetal($entityMetal + $stock->getMetal())
                ->setDiamant( $entityDiam + $stock->getDiamant() )
            ;

            $this->manager->persist($stockNew);
        }
        return;

    }

    public function removeDon(AfterEntityDeletedEvent $deletedEvent)
    {

        $entity = $deletedEvent->getEntityInstance();
        if ($entity instanceof Don)
        {
            $taxe = $entity->getUser()->getTaxe() / 100;
            $stockTaxeCash= $entity->getCash() - $entity->getCash() * $taxe;

            $stockTaxeMunition = $entity->getMunition() - $entity->getMunition() * $taxe;
            $stockTaxeMarchandise =$entity->getMarchandise() - $entity->getMarchandise() * $taxe;
            $stockTaxeMetal = $entity->getMetal() - $entity->getMetal() * $taxe;
            $stockTaxeDiamant = $entity->getDiamant() - $entity->getDiamant() * $taxe;
            $stock = $this->stockRepository->findLast();
            $stockNew = new Stock();
            $stockNew
                ->setCash( $stock->getCash() - $stockTaxeCash)
                ->setMunition( $stock->getMunition() - $stockTaxeMunition)
                ->setMarchandise( $stock->getMarchandise() - $stockTaxeMarchandise)
                ->setMetal( $stock->getMetal() - $stockTaxeMetal)
                ->setDiamant( $stock->getDiamant() -  $stockTaxeDiamant)
            ;

            $this->manager->persist($stockNew);
            $this->manager->flush();

        }
        return;

    }


}