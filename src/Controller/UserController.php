<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        session_start();
        //$_SESSION['user'] = null;
        //$_SESSION['user_id'] = null;
        //$_SESSION['user_name'] = null;
    }

    public function registerUser(Request $data): ?Response
    {
        $user = new User(
            null, 
            $data->get('first_name'),
            $data->get('last_name'),
            $data->get('email'),
            empty($data->get('phone')) ? null : $data->get('phone'),
            null,
        );

        if ($this->userRepository->findByEmail($data->get('email')) != null) {
            $mess = 'The user with this email already exists';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);  
        } 

        $userId = $this->userRepository->store($user);

        $file = $this->downloadImage($userId);

        if ($file != null){
            $user->setAvatarPath($file);
            $this->userRepository->store($user);
        }

        $_SESSION['user'] = 'user';
        $_SESSION['user_name'] = $user->getFirstName();
        $_SESSION['user_id'] = $user->getId();

        return $this->redirectToRoute('catalog', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

    public function updateUser(int $userId, Request $data): Response
    {
        $user = $this->userRepository->findById($userId);
        if ($userId != $_SESSION['user_id']) {
            $mess = 'Вы не можете редактировать профиль этого пользователя';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);     
        }
        if (!$user)
        {
            $mess = 'Пользователя с этим ID не существует';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);     
        }

        if ($data->isMethod('post')) {
            $userWithEmail = $this->userRepository->findByEmail($data->get('email'));
            if (($userWithEmail != null) && ($userWithEmail != $user)) {
                $mess = 'The user with this email already exists';
                return $this->redirectToRoute('error_page', ['mess' => $mess]);  
            } 
            $user = $this->updateUsersData($data);
        }

        return $this->render('update_user.html.twig', [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'avatarPath' => $user->getAvatarPath(),
            'userName' => $_SESSION['user_name'],
            'userId' => $_SESSION['user_id'], 
        ]);
    }

    private function updateUsersData(Request $data): User{
        $id = (int)$data->get('user_id');
        $user = $this->userRepository->findById($id);

        if ($user != null) {
            $user->setFirstName($data->get('first_name'));
            $user->setLastName($data->get('last_name'));
            $user->setEmail(empty($data->get('email')) ? null : $data->get('email'));
            $user->setPhone(empty($data->get('phone')) ? null : $data->get('phone'));
        } else {
            header('Location: ' . '/error_page.php', true, 303);
        }

        $file = $this->downloadImage($id);

        if ($file != null){
            $user->setAvatarPath($file);
        }
        
        $this->userRepository->store($user); 
        return $user;
    }

    private function downloadImage(int $id): ?string 
    {
        $uploadfile = __DIR__ . '/../../public/uploads/avatar';
        $file = null;

        if ($_FILES['avatar_path']['error'] == 0) {
            $extension = $this->getAvatarExtension($_FILES['avatar_path']['type']);
            if ($extension == null) {
                return $this->redirectToRoute('error_page');
            } 
            if (move_uploaded_file($_FILES['avatar_path']['tmp_name'], $uploadfile . $id . '.' . $extension)) {
                $file = 'avatar' . $id . '.' . $extension;   
            }
        }
        return $file;
    }

    public function deleteUser(int $userId): Response
    {
        $user = $this->userRepository->findById($userId);
        if (!$user)
        {   
            $mess = 'Пользователя с этим ID не существует';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);    
        }
        $this->userRepository->delete($user);
        $_SESSION['user'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['user_name'] = null;
        if ($user->getAvatarPath() != null) {
            $this->deleteImage($user);
        }  
        return $this->redirectToRoute('catalog', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id'], ]);
    }

    private function deleteImage(User $user): void
    {
        $avatarPath = $user->getAvatarPath();
        $filePath = __DIR__ . '/../../public/uploads/' . $avatarPath;
        if (file_exists($filePath)) 
        {
            unlink($filePath);
            echo "File Successfully Delete."; 
        } else {
            echo "File does not exists"; 
        }
    }

    private function getAvatarExtension(string $mimeType): ?string
    {
        $supportedMimeTypes = [
            'image/jpeg' => 'jpeg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];
        return $supportedMimeTypes[$mimeType] ?? null;
    }

    public function viewUser(int $userId): Response
    {
        $user = $this->userRepository->findById($userId);
        if (!$user)
        {
            $mess = 'There is not user with this ID';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);       
        }

        return $this->render('user.html.twig', [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'avatarPath' => $user->getAvatarPath(),
            'userName' => $_SESSION['user_name'],
            'userId' => $_SESSION['user_id'], 
        ]);
    }

    public function loginApi(Request $data): Response {
        $user = $this->userRepository->findByEmail($data->get('email'));
        if ($user != null) {
            $_SESSION['user'] = 'user';
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_name'] = $user->getFirstName();
            return $this->redirectToRoute('catalog');
        } else {
            $mess = 'Неверный email';
            return $this->redirectToRoute('error_page', ['mess' => $mess]);  
        }
    }

    public function logout(): Response {
        $_SESSION['user'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['user_name'] = null;
        return $this->redirectToRoute('catalog', ['userName' => $_SESSION['user_name'], 'userId' => $_SESSION['user_id']]);
    }

}