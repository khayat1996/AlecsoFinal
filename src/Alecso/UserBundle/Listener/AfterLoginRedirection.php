<?php
/**
 * Created by PhpStorm.
 * User: Emna
 * Date: 03/04/2019
 * Time: 13:40
 */

namespace Alecso\UserBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AfterLoginRedirection
 *
 * @package AppBundle\AppListener
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request        $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ADMIN', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('alecso_admin_homepage'));
        } else if (in_array('ROLE_PARTENAIRE', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('alecso_evenement_view_partenaire'));
        } else {
            $redirection = new RedirectResponse($this->router->generate('alecso_User_homepage'));
        }

        return $redirection;
    }
}