<?php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

/**
 * test short summary.
 *
 * test description.
 *
 * @version 1.0
 * @author cst212
 */
class test extends WebTestCase
{

    public function testLoginPageAvaliability()
    {
        $client = static::createClient();
        $client->request('GET', "http://localhost");

        //Code 200 means the page exists
        $this->assertSame(
            200,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', "projectList")
        );
    }

    public function testLoginSucess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://localhost/login');

        //fill out the form
        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'max';
        $form['_password'] = 'test';
        $crawler = $client->submit($form);

        //checks that we get redirected and follows the redirect
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        //Checks that text on the page exists bu looking for a text on it
        $this->assertContains(
        'Hello world',
        $client->getResponse()->getContent()
    );

    }

    public function testLoginFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://localhost/login');


        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'max1';
        $form['_password'] = 'test2';
        $crawler = $client->submit($form);
        //Select and fill out the form
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        //Checks that text on the page exists bu looking for a text on it
        $this->assertContains(
        'Invalid credentials.',
        $client->getResponse()->getContent()
        );
    }

    public function testFunctionTests()
    {
        $loginCred = [
            ["max", "test"],
            ["TerryG","TestPassword"],
            ["TerryP", "TestPasswordS"],
            ["TerryG","TestPasswordS"],
            ["","TestPassword"],
            ["TerryG",""],
            ["1234567890abcdefg","TestPassword"],
            ["TerryP","111111111111111111111111111111111111111111111111111"],
            ["12","TestPassword"],
            ["TerryP","123"],
        ];

        foreach ($loginCred as $item)
        {
            //First iten in the list asserts to True ( login should work )
            if ($loginCred[0] == $item)//first item passes
            {
                $client = static::createClient();
                $crawler = $client->request('GET', 'http://localhost/login');

                //Select and fill out the form
                $form = $crawler->selectButton('_submit')->form();
                $form['_username'] = $item[0];
                $form['_password'] = $item[1];
                $crawler = $client->submit($form);

                //checks that we get redirected and follows the redirect
                $this->assertTrue($client->getResponse()->isRedirect());
                $client->followRedirect();
                //Checks that text on the page exists
                $this->assertContains(
                'Hello world',
                $client->getResponse()->getContent()
                );
            }
            else //all other items in the list should assert to false (invalid Login)
            {
                $client = static::createClient();
                $crawler = $client->request('GET', 'http://localhost/login');

                //Select and fill out the form
                $form = $crawler->selectButton('_submit')->form();
                $form['_username'] = $item[0];
                $form['_password'] = $item[1];
                $crawler = $client->submit($form);

                $this->assertTrue($client->getResponse()->isRedirect());
                $client->followRedirect();
                $this->assertContains(
                'Invalid credentials.',
                $client->getResponse()->getContent()
                );
            }

        }

    }


}