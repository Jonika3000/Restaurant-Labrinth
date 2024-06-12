<?php

namespace App\EventSubscriber;

use App\Service\MenuBuilderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $menuBuilder;

    public function __construct(Environment $twig, MenuBuilderService $menuBuilder)
    {
        $this->twig = $twig;
        $this->menuBuilder = $menuBuilder;
    }

    public function onControllerEvent(ControllerEvent $event): void
    {
        $this->twig->addGlobal('menuItems', $this->menuBuilder->buildMenu());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
