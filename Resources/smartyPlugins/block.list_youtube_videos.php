<?php
/**
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * List Yourtube Videos block
 *
 * @param array $params
 * @param string $content
 * @param Smarty_Internal_Template $template
 * @param bool $repeat
 * @return string
 */
function smarty_block_list_youtube_videos(array $params, $content, &$smarty, &$repeat)
{
    if (empty($params['playlistId'])) {
        return;
    }

    if (empty($params['maxResults'])) {
        $maxResults = "";
    } else {
        $maxResults = "&maxResults=" . $params['maxResults'];
    }

    if (empty($params['pageToken'])) {
        $pageToken = "";
    } else {
        $pageToken = "&pageToken=" . $params['pageToken'];
    }

    $container = \Zend_Registry::get('container');
    $cacheService = $container->get('newscoop.cache');
    $preferencesService = $this->container->get('system_preferences_service');
    $apikey = $preferencesService->YoutubeApiKey;
    $baseUrl = $preferencesService->YoutubeBaseUrl;
    $fields = $preferencesService->YoutubeFields;
    $playlistId = $params['playlistId'];
    $cacheKey = $cacheService->getCacheKey("youtube_videos_found_" . $playlistId . "_" . $maxResults . "_" . $pageToken);

    if (!isset($content)) {
        // load the list
        $url = $baseUrl . "playlistItems?part=snippet&playlistId=" . $playlistId . "&fields=" . $fields . $maxResults . $pageToken ."&key=" . $apiKey;

        $client = new \Zend_Http_Client($url);
        $client->setMethod(Zend_Http_Client::GET);
        $results = json_decode($client->request()->getBody(), true);
        $smarty->assign('nextPageToken', $results['nextPageToken']); 
        $smarty->assign('totalResults', $results['pageInfo']['totalResults']); 
        $cacheService->save($cacheKey, json_encode($results['items']));
    }

    $videos = json_decode($cacheService->fetch($cacheKey), true);

    if (!empty($videos)) {
        // load the current record
        $video = array_shift($videos);
        $smarty->assign('video', $video['snippet']);
        $cacheService->save($cacheKey, json_encode($videos));
        $repeat = true;
    } else {
        $repeat = false;
    } 

    return $content;
}

