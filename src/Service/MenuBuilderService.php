<?php

// src/Service/MenuBuilderService.php
namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MenuBuilderService
{
    private $router;
    private $translator;

    public function __construct( UrlGeneratorInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function buildMenu()
    {
        $menuItems = [
            [
                'label' => $this->translator->trans('Home'),
                'uri' => $this->router->generate('app_home_page'),
            ],
            [
                'label' => $this->translator->trans('Menu'),
                'uri' => $this->router->generate('app_category'),
            ],
            [
                'label' => $this->translator->trans('Events'),
                'uri' => $this->router->generate('app_event'),
            ]
        ];

        return $menuItems;
    }

    public function buildFooter()
    {
        $menuFooter = [
            [
                'icon' => 'fa-brands fa-instagram text-2xl text-white cursor-pointer',
                'uri' => 'instagram.com',
            ],
            [
                'icon' => 'fa-brands fa-facebook text-2xl text-white cursor-pointer',
                'uri' => 'facebook.com'
            ],
            [
                'icon' => 'fa-brands fa-twitter text-2xl text-white cursor-pointer',
                'uri' => 'x.com',
            ]
        ];

        return $menuFooter;
    }
}
