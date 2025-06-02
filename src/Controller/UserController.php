<?php

namespace App\Controller;

use App\Entity\AvatarFile;
use App\Entity\User;
use App\Form\UserSettingsType;
use App\Repository\DefaultAvatarFileRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/profile/{username}', name: 'app_user_profile', methods: ['GET'])]
    public function profile(string $username, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $username]);

        return $this->render('/user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/settings', name: 'app_user_settings')]
    #[IsGranted('ROLE_STUDENT')]
    public function settings(Request $request, EntityManagerInterface $entityManager, DefaultAvatarFileRepository $defaultAvatarFileRepository, UploaderHelper $uploaderHelper): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $settingsForm = $this->createForm(UserSettingsType::class, $user);
        $avatars = $defaultAvatarFileRepository->findAll();

        try {
            $settingsForm->handleRequest($request);
            if ($settingsForm->isSubmitted() && $settingsForm->isValid()) {
                $avatarPath = $settingsForm->get('defaultAvatar')->getData();
                $deleteAvatar = boolval($settingsForm->get('deleteAvatar')->getData());

                $defaultAvatar = $defaultAvatarFileRepository->findOneBy(['name' => $avatarPath->getName()]);
                if ($avatarPath && $defaultAvatar) {
                    $path = Path::makeAbsolute('public'.$uploaderHelper->asset($defaultAvatar), $this->getParameter('kernel.project_dir'));
                    $replacingFile = new ReplacingFile($path);
                    $avatarFile = new AvatarFile();
                    $avatarFile->setFile($replacingFile);

                    $user->setAvatar($avatarFile);
                } elseif ($deleteAvatar) {
                    $user->setAvatar(null);
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Suas configurações foram atualizadas.');

                return $this->redirectToRoute('app_user_settings');
            }
        } catch (\Exception $exception) {
            $this->addFlash('error', 'Erro ao atualizar o seu perfil.');

            return $this->redirectToRoute('app_user_settings');
        }

        return $this->render('/user/settings.html.twig', [
            'settingsForm' => $settingsForm,
            'avatars' => $avatars,
        ]);
    }
}
