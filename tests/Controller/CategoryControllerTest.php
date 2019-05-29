<?php

namespace App\tests\Controller;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CategoryControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $session = static::$kernel->getContainer()->get('session');
        $user = self::$kernel->getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(array('email' => 'datadogprojektas@gmail.com'));
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testCreateCategory()
    {
        $path = $this->client->getContainer()->get('router')->generate('app_createcategory', [], false);
        $crawler = $this->client->request('GET', $path);

        $form = $crawler->selectButton('Pridėti')->form([
            'create_category_form[categoryName]' => 'TestingCategory'
        ]);
        $this->client->submit($form);

        /*$this->client->getResponse();
        $crawler = $this->client->followRedirect();
        $this->assertGreaterThan(0, $crawler->filter('html:contains("sukurta sėkmingai")')->count());*/

        $category = self::$kernel->getContainer()->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'TestingCategory'));
        $this->assertEquals('TestingCategory', $category->getName());
    }

    public function testDeleteCategory()
    {
        $path = $this->client->getContainer()->get('router')->generate('app_deletecategory');
        $crawler = $this->client->request('GET', $path);

        $category = self::$kernel->getContainer()->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'TestingCategory'));
        $form = $crawler->selectButton('Šalinti')->form([
            'delete_category_form[name]' => $category->getId()
        ]);
        $this->client->submit($form);

        /*$this->client->getResponse();
        $crawler = $this->client->followRedirect();
        $this->assertGreaterThan(0, $crawler->filter('html:contains("pašalinta sėkmingai")')->count());*/

        $category = self::$kernel->getContainer()->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'TestingCategory'));
        $this->assertEmpty($category);
    }
}
