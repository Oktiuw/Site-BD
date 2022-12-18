<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedHandler implements \Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        $content="<h1>Vous n'avez pas le droit d'accèder à cette ressource</h1> <a href='/'>Accueil</a>";
        return new Response($content, 403);
    }
}
