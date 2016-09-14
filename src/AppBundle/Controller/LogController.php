<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/logs")
 */
class LogController
{
    /**
     * @Route("", name="log_index")
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        return new JsonResponse(['yo' => 'bebito']);
    }
}
