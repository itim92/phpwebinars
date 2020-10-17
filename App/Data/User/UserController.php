<?php


namespace App\Data\User;


use App\Controller\AbstractController;
use App\Data\User\Exception\EmptyFieldException;
use App\Data\User\Exception\PasswordMismatchException;
use App\Http\Request;

class UserController extends AbstractController
{

    /**
     * @route("/user/login")
     */
    public function login()
    {
        return $this->redirect('/products/');
    }

    /**
     * @route("/user/register")
     */
    public function register(Request $request, UserRepositoryOld $userRepository, UserService $userService)
    {
        $data = [];
        if ($request->isPost()) {

            try {
                $user = $this->registerAction();
                $user->setPassword(
                    $userService->passwordEncode(
                        $user->getPassword()
                    )
                );

                $userRepository->save($user);

                return $this->redirect('/user/register');
            } catch (EmptyFieldException $e) {
                $data['error'] = [
                    'message' => 'Заполните необходимые поля',
                    'requiredFields' => $e->getEmptyFields(),
                ];
            } catch (PasswordMismatchException $e) {
                $data['error'] = [
                    'message' => 'Пароли не совпадают',
                    'requiredFields' => [
                        'password' => true,
                        'passwordRepeat' => true,
                    ],
                ];
            }
        }

        return $this->render('user/register.form.tpl', $data);
    }

    private function registerAction(): UserModel
    {
        $name = $this->request->getStrFromPost('name');
        $email = $this->request->getStrFromPost('email');
        $password = $this->request->getStrFromPost('password');
        $passwordRepeat = $this->request->getStrFromPost('passwordRepeat');

        $hasEmptyFields = false;
        $emptyFieldsException = new EmptyFieldException();
        if (empty($name)) {
            $emptyFieldsException->addEmptyField('name');
            $hasEmptyFields = true;
        }
        if (empty($email)) {
            $emptyFieldsException->addEmptyField('email');
            $hasEmptyFields = true;
        }
        if (empty($password)) {
            $emptyFieldsException->addEmptyField('password');
            $hasEmptyFields = true;
        }
        if (empty($passwordRepeat)) {
            $emptyFieldsException->addEmptyField('passwordRepeat');
            $hasEmptyFields = true;
        }

        if ($hasEmptyFields) {
            throw $emptyFieldsException;
        }

        if ($password !== $passwordRepeat) {
            throw new PasswordMismatchException();
        }


        $user = new UserModel($name, $email, $password);

        return $user;
    }

}