<?php

namespace App\Controller\Admin;

use App\Entity\DefaultAvatarFile;
use App\Entity\Discipline;
use App\Entity\Lesson;
use App\Entity\Module;
use App\Entity\Professor;
use App\Entity\Quiz;
use App\Entity\QuizResponse;
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

        $kpis = [
            'total_students' => 28,
            'engagement_rate' => 84.4,
            'completed_activities' => 129,
            'satisfaction' => 8.9,
        ];

        $engagementLabels = ['Abril', 'Maio', 'junho'];
        $engagementData = [97.7, 81.5, 66.7];

        $activitiesLabels = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6'];
        $activitiesData = [27, 22, 19, 25, 19, 17];

        $motivationLabels = ['Significado Épico', 'Empoderamento', 'Influência Social', 'Imprevisibilidade e Curiosidade', 'Evitar Perda','Escassez e Impaciência', 'Posse','Desenvolvimento e realização'];
        $motivationData = [28.9, 26.7, 36.7, 28.9, 22.2, 35.6, 38.9, 62.2];

        return $this->render('admin/dashboard.html.twig', [
            'kpis' => $kpis,
            'engagement_labels' => $engagementLabels,
            'engagement_data' => $engagementData,
            'activities_labels' => $activitiesLabels,
            'activities_data' => $activitiesData,
            'motivation_labels' => $motivationLabels,
            'motivation_data' => $motivationData,
        ]);
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
            MenuItem::linkToCrud('Módulos', 'book', Module::class),
            MenuItem::linkToCrud('Lições', 'book', Lesson::class),
            MenuItem::linkToCrud('Questionários', 'book', Quiz::class),
            MenuItem::linkToCrud('Avatares', 'library-photo', DefaultAvatarFile::class),
            MenuItem::linkToCrud('Respostas', 'check', QuizResponse::class),
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
