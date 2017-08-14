<?php
namespace Test\Integration\NonFunctional\Authentication;

use DbSystel\Test\AbstractControllerTest;
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

}