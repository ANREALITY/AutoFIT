<?php
namespace Test\Integration\NonFunctional\Authentication;

use Authorization\Acl\Acl;
use Base\DataObject\User;
use Base\Test\AbstractControllerTest;
use Zend\Authentication\AuthenticationService;

class AuthenticationTest extends AbstractControllerTest
{

    public function testUsernameIsRetrievedFromServerGlobalVar()
    {
        $username = 'foo';
        $_SERVER['AUTH_USER'] = $username;
        $this->dispatch('/');
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $this->getApplicationServiceLocator()->get('AuthenticationService');

        $expectedUserData = $this->retrieveActualData('user', 'username', $username);
        $expectedIdentity = [
            'id' => $expectedUserData['id'],
            'username' => $expectedUserData['username'],
            'role' => $expectedUserData['role'],
        ];

        $this->assertTrue($authenticationService->hasIdentity());
        $this->assertTrue(is_array($authenticationService->getIdentity()));
        $this->assertEquals($expectedIdentity, $authenticationService->getIdentity());
    }

    public function testUserGetsCreatedOnApplicationStart()
    {
        $username = 'foo' . date('YmdHis', time());
        $_SERVER['AUTH_USER'] = $username;
        $this->dispatch('/');

        /** @var User $expectedUser */
        $expectedUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        $this->assertEquals($expectedUser->getUsername(), $username);
        $this->assertEquals($expectedUser->getRole(), Acl::DEFAULT_ROLE);
    }

}