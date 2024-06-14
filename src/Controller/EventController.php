<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SiteLocale;
use App\Entity\Translate\EventTranslate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('{_locale}/events', name: 'app_event')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $localeRequest = $request->getLocale();
        $repositoryLocale = $em->getRepository(SiteLocale::class);
        $locale = $repositoryLocale->findOneBy(['name'=>$localeRequest]);
        $repository = $em->getRepository(Event::class);
        $events = $repository->findBy([], ['date' => 'DESC']);

        if ($locale !== "en" && isset($locale))
        {
            $repositoryTranslate = $em->getRepository(EventTranslate::class);
            foreach ($events as $event)
            {
                $eventTranslate = $repositoryTranslate->findBy(['locale' => $locale, 'event'=> $event]);
                if (isset($eventTranslate[0])) {
                    $event->setName($eventTranslate[0]->getName());
                    $event->setText($eventTranslate[0]->getText());
                }
            }
        }
        $uploadsBasePath = $this->getParameter('uploads_base_path');

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'uploads_base_path' => $uploadsBasePath
        ]);
    }

    #[Route('{_locale}/event/{id}', name: 'app_event_show')]
    public function show(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $localeRequest = $request->getLocale();
        $repositoryLocale = $em->getRepository(SiteLocale::class);
        $locale = $repositoryLocale->findOneBy(['name'=>$localeRequest]);

        if ($locale !== "en" && isset($locale))
        {
            $repositoryTranslate = $em->getRepository(EventTranslate::class);
            $eventTranslate = $repositoryTranslate->findOneBy(['locale' => $locale, 'event'=> $event]);
            if ($eventTranslate) {
                $event->setName($eventTranslate->getName());
                $event->setText($eventTranslate->getText());
            }
        }

        $uploadsBasePath = $this->getParameter('uploads_base_path');

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'uploads_base_path' => $uploadsBasePath
        ]);
    }
}
