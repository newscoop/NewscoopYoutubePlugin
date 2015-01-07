<?php

namespace Newscoop\YoutubePluginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

/**
 * Route("/youtube")
 */ 
class YoutubeController extends Controller
{
    /**
     * @Route("/youtube/{playlistId}")
     */
    public function indexAction($playlistId)
    {
        $templatesService = $this->container->get('newscoop.templates.service');
        $smarty = $templatesService->getSmarty();
        $templateDir = array_shift($smarty->getTemplateDir());
        $templateFile = __DIR__ . "/../Resources/views/Youtube/index.html.tpl";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $response->setContent($templatesService->fetchTemplate(
            $templateFile,
            array('playlistId' => $playlistId)
        ));
        return $response;
    }
}
