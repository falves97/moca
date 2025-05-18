<?php

namespace App\Controller\Admin;

use App\Entity\DefaultAvatarFile;
use App\Entity\Discipline;
use App\Entity\Lesson;
use App\Entity\Professor;
use App\Entity\Quiz;
use App\Entity\Student;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private AssetMapperInterface $assetMapper)
    {
    }

    public function index(): Response
    {
        return $this->render('@EasyAdmin/layout.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->useCustomIconSet('tabler');
    }

    public function configureDashboard(): Dashboard
    {
        $url = $this->assetMapper->getAsset('img/logo.png')->publicPath;

        return Dashboard::new()
            ->setTitle('<div style="text-align: center;"><img height="120" width="100" src="'.$url.'" alt="logo"></div>')
            ->setFaviconPath('img/icone.png')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'dashboard'),
            MenuItem::linkToCrud('Usuários', 'users', User::class),
            MenuItem::linkToCrud('Professores', 'user', Professor::class),
            MenuItem::linkToCrud('Alunos', 'users-group', Student::class),
            MenuItem::linkToCrud('Disciplinas', 'book', Discipline::class),
            MenuItem::subMenu('Módulos', 'books'),
            MenuItem::linkToCrud('Lições', 'book', Lesson::class),
            MenuItem::linkToCrud('Questionários', 'book', Quiz::class),
            MenuItem::linkToCrud('Avatares', 'library-photo', DefaultAvatarFile::class),
        ];
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getFullName())
            ->addMenuItems([
                MenuItem::linkToUrl('Profile', 'user', $this->generateUrl('admin_user_detail', [
                    'entityId' => $user->getId(),
                ])),
            ]);
    }
}
