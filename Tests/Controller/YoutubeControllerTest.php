<?php

namespace Newscoop\YoutubePluginBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class YoutubeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/youtube/Tester');

        $this->assertTrue($crawler->filter('html:contains("Hello Tester")')->count() > 0);
    }
}
