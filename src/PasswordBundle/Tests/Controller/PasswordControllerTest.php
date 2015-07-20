<?php
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use PasswordBundle\Tests\Fixtures\Entity\LoadPasswordData;

/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/18/15
 * Time: 1:49 AM
 */
class PasswordControllerTest extends WebTestCase{

    public function customSetUp($fixtures){
        $this->client = static::createClient();
        $this->loadFixtures($fixtures);
    }

    public function testNewPasswordAction()
    {
        $this->client = static::createClient();

        $this->client->request(
            'GET',
            '/api/v1/passwords/new.json',
            array(),
            array()
        );

        $this->assertJsonResponse($this->client->getResponse(), 200, true);

        $this->assertEquals(
            '{"children":{"key":{},"username":{},"password":{}}}',
            $this->client->getResponse()->getContent(),
            $this->client->getResponse()->getContent());
    }

    public function testGetPasswordAction()
    {
        $fixtures = array('PasswordBundle\Tests\Fixtures\Entity\LoadPasswordData');
        $this->customSetUp($fixtures);
        $passwords = LoadPasswordData::$passwords;
        $password = array_pop($passwords);

        $route =  $this->getUrl('api_1_get_password', array('key' => $password->getKey(), '_format' => 'json'));

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['key']));

    }

    public function testPostPasswordAction()
    {
        $this->client = static::createClient();

        $this->client->request(
            'POST',
            '/api/v1/passwords.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"key":"kahfi","username":"kahfi@gmail.com", "password":"kahfi"}'

        );
        $this->assertJsonResponse($this->client->getResponse(), 201, false);
    }

    /*public function testPutPasswordAction()
    {
        $this->client = static::createClient();

        $this->client->request(
            'PUT',
            '/api/v1/passwords/google~',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"key":"default","username":"testUsernameUpdated","password":"testPasswordUpdated"}'
        );

        $this->assertJsonResponse($this->client->getResponse(), 302, true);
    }*/

    public function testDeletePasswordAction(){
        $this->client = static::createClient();

        $route =  $this->getUrl('api_1_delete_password', array(
            'key' => 'testKey',
            '_format' => 'json'
        ));

        $this->client->request('DELETE', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    protected function assertJsonResponse($response, $statusCode = 200, $checkValidJson =  true, $contentType = 'application/json')
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );

        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );

        if ($checkValidJson) {
            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
}
?>