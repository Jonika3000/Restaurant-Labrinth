<?php

namespace App\EventSubscriber;

use App\Entity\Dish;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityDeletedEvent::class => ["deleteImage"],
        ];
    }

    public function deleteImage(AfterEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof Dish || $entity instanceof Event)
        {
            $path = $this->params->get('uploads_full_path').'/'.$entity->getPhoto();
            if(file_exists($path))
            {
                unlink($path);
            }
        }
    }
}
