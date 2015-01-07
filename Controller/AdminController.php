<?php

namespace Newscoop\YoutubePluginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends Controller
{
    /**
     * @Route("/admin/youtube")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->container->get('em');
        $preferencesService = $this->container->get('system_preferences_service');
        $apikey = $preferencesService->YoutubeApiKey;
        $baseurl = $preferencesService->YoutubeBaseUrl;
        $fields = $preferencesService->YoutubeFields;

        if ($request->isMethod('POST')) {
            $apikey = $request->request->get('apikey');
            $baseurl = $request->request->get('baseurl');
            $fields = $request->request->get('fields');

            $preferencesService->set('YoutubeApiKey', $apikey);
            $preferencesService->set('YoutubeBaseUrl', $baseurl);
            $preferencesService->set('YoutubeFields', $fields);
        }

        return array(
            'apikey' => $apikey,
            'baseurl' => $baseurl,
            'fields' => $fields
        );

    }
}
