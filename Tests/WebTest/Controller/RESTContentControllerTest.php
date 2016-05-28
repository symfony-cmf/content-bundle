<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Tests\WebTest\Controller;

use Symfony\Cmf\Component\Testing\Functional\BaseTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class RESTContentControllerTest extends BaseTestCase
{
    public function setUp()
    {
        $this->db('PHPCR')->loadFixtures(array(
            'Symfony\Cmf\Bundle\ContentBundle\Tests\Resources\DataFixtures\Phpcr\LoadContentData',
        ));
        $this->client = $this->createClient();
    }

    public function testGET()
    {
        $this->client->request('GET', '/content-1', array(), array(), array('HTTP_ACCEPT'=> 'application/json'));
        $res = $this->client->getResponse();
        $this->assertEquals(200, $res->getStatusCode());
    }

    public function testPUT()
    {
        $this->client->request(
            'PUT',
            '/content-1',
            array(),
            array(),
            array('HTTP_ACCEPT'=> 'application/json', 'CONTENT_TYPE' => 'application/json'),
            file_get_contents(__DIR__ . '/../../Resources/Fixtures/json/put.json')
        );
        $res = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $res->getStatusCode());
    }

    public function testPATCH()
    {
        $this->client->request(
            'PATCH',
            '/content-1',
            array(),
            array(),
            array('HTTP_ACCEPT'=> 'application/json', 'CONTENT_TYPE' => 'application/json')
        );
        $res = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $res->getStatusCode());
    }

    public function testDELETE()
    {
        $this->client->request(
            'DELETE',
            '/content-1',
            array(),
            array(),
            array('HTTP_ACCEPT'=> 'application/json')
        );
        $res = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $res->getStatusCode());
    }

    public function testPOST()
    {
        $this->client->request(
            'POST',
            '/',
            array(),
            array(),
            array('HTTP_ACCEPT'=> 'application/json', 'CONTENT_TYPE' => 'application/json')
        );
        $res = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $res->getStatusCode());
    }
}
