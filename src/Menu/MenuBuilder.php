<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\SecurityBundle\Security;

class MenuBuilder
{
    private FactoryInterface $factory;
    private Security $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root', ['childrenAttributes' => ['class' => 'navbar-nav']]);

        $menu->addChild('Home', [
            'route' => 'app_site',
            'attributes' => ['class' => 'nav-item'],
            'linkAttributes' => ['class' => 'nav-link'],
            'labelAttributes' => ['class' => 'nav-link'],
            'extras' => ['icon' => 'tabler:home'],
        ]);

        return $menu;
    }

    public function createUserMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root', ['childrenAttributes' => ['class' => 'nav flex-column']]);
        $firstSection = $menu->addChild('First Section', ['display' => false, 'childrenAttributes' => ['class' => 'nav flex-column']]);
        $firstSection->addChild('Dashboard', ['route' => 'app_dashboard', 'linkAttributes' => ['class' => 'dropdown-item']]);
        $firstSection->addChild('Profile', [
            'route' => 'app_user_profile',
            'routeParameters' => ['username' => $this->security->getUser()->getUsername()],
            'linkAttributes' => ['class' => 'dropdown-item'],
        ]);

        $menu->addChild('Settings', ['route' => 'app_user_settings', 'linkAttributes' => ['class' => 'dropdown-item']]);
        $menu->addChild('Logout', ['route' => 'app_logout', 'linkAttributes' => ['class' => 'dropdown-item']]);

        return $menu;
    }
}
