<?php
namespace Authentication\Controller;

use Authentication\Form\LoginForm;
use Authentication\Service\AuthenticationManager;
use Exception;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Uri\Uri;
use Zend\View\Model\ViewModel;

/**
 * The AuthController is responsible for making the user able to log in and log out.
 */
class AuthController extends AbstractActionController
{

    /** @var AuthenticationService */
    private $authenticationService;
    /** @var AuthenticationManager */
    private $authManager;

    public function __construct(AuthenticationService $authenticationService, AuthenticationManager $authManager)
    {
        $this->authenticationService = $authenticationService;
        $this->authManager = $authManager;
    }

    /**
     * @return Response|ViewModel
     * @throws Exception
     */
    public function loginAction()
    {
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl) > 2048) {
            throw new Exception("Too long redirectUrl argument passed");
        }

        $form = new LoginForm();
        $form->get('redirect_url')->setValue($redirectUrl);

        $isLoginError = false;

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $result = $this->authManager->login($data['username']);
                if ($result->getCode() == Result::SUCCESS) {
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');
                    if (! empty($redirectUrl)) {
                        // Preventing possible redirect attacks (if someone tries to redirect user to another domain).
                        $uri = new Uri($redirectUrl);
                        if (! $uri->isValid() || $uri->getHost() != null) {
                            throw new Exception('Incorrect redirect URL: ' . $redirectUrl);
                        }
                    }
                    if(empty($redirectUrl)) {
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    $isLoginError = true;
                }
            } else {
                $isLoginError = true;
            }
        }

        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function changeIdentityAction()
    {
        $username = $this->authenticationService->getIdentity()['username'];
        $this->authManager->changeIdentity($username);
        return $this->redirect()->toRoute('identity-changed');
    }

    /**
     * @return ViewModel
     * @throws Exception
     */
    public function identityChangedAction()
    {
        return new ViewModel(
            ['currentIdentityUsername' => $this->authenticationService->getIdentity()['username']]
        );
    }

}
