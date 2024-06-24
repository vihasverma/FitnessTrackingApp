<?php

namespace App\Tests\UI\Http\Web\Controller;

use App\Infrastructure\Fitness\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FitnessTrackerControllerTest extends WebTestCase
{

    /**
     * @group functional_test
     * */
    public function testHomePage(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('vihas@example.com');
        $client->loginUser($testUser);

        $client->request('GET', '/activity');
        self::assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h2', 'Fitness Tracking: Dashboard');
    }
}