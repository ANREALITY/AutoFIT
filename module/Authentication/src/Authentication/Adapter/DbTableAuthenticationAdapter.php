<?php
namespace Authentication\Adapter;

use Authorization\Acl\Acl;
use Base\DataObject\User;
use Zend\Authentication\Result;

class DbTableAuthenticationAdapter extends AbstractAuthenticationAdapter
{

    /**
     * In this naïve implementation we simply reply on the data received from the user.
     * The logic is:
     * If the user asserts to be Foo, the user is Foo.
     * We are using this this approach only as a temporary intermediate step to an SSO&OAuth driven implementation.
     * @todo Extend this behavior, when switching to SSO.
     *
     * {@inheritDoc}
     * @see AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $user = $this->userService->findOneByUsername($this->username);
        if (! $user) {
            $user = new User();
            $user->setRole(Acl::DEFAULT_ROLE);
            $user->setUsername($this->username);
            $user = $this->userService->saveOne($user);
        }
        $relatedUser = $this->userService->findRelatedUser($this->username);
        $identity = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'role' => $user->getRole(),
            'alternativeIdentityUsername' => ! empty($relatedUser) ? $relatedUser->getUsername() : null,
        ];
        $this->setIdentity($identity);
        $authResult = new Result(Result::SUCCESS, $identity);
        return $authResult;
    }

}
