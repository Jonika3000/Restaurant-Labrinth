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
                'uri' => $this->router->generate('app_login'),
            ],
            [
                'label' => 'About',
                'uri' => $this->router->generate('app_login'),
            ]
        ];

        return $menuItems;
    }
}
