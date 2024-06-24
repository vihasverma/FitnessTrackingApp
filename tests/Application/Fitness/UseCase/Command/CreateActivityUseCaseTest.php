<?php

namespace App\Tests\Application\UseCase\Command\Fitness;

use App\Application\UseCase\Command\Fitness\CreateActivityCommand;
use App\Application\UseCase\Command\Fitness\CreateActivityUseCase;
use App\Domain\Fitness\Exception\InvalidActivityDataException;
use App\Domain\Fitness\Repository\ActivityRepositoryInterface;
use App\Domain\Shared\IdGenerator;
use App\Infrastructure\Fitness\Repository\InMemoryActivityRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CreateActivityTest extends KernelTestCase
{
    /**
     * @return void
     * @throws Exception
     * @group test
     *
     */
    public function testCreatePost()
    {
        $idGenerator = new IdGenerator;
        $activityRepository = $this->getRepository();
        $createActivityUserCase = new CreateActivityUseCase($activityRepository, $idGenerator);
        $createActivityCommand = new CreateActivityCommand(Uuid::v6(),'walking','12','km', '12');
        $newActivity = $createActivityUserCase->create($createActivityCommand);
        $this->assertEquals($newActivity, $activityRepository->findOneById($newActivity->getId()));
    }

    /**
     * @param string $type
     *
     * @return ActivityRepositoryInterface
     */
    public function getRepository()
    {
        return new InMemoryActivityRepository();
    }

    /**
     * @param array<string, string> $postData
     * @group test
     * @return void
     * @throws InvalidActivityDataException
     * @dataProvider provideTrimInvalidData
     */
    public function testCreatePostInvalidData(array $postData)
    {
        $this->expectException(InvalidActivityDataException::class);

        $idGenerator = new IdGenerator;
        $postRepository = $this->getRepository();

        $createPostUserCase = new CreateActivityUseCase($postRepository, $idGenerator);

        $createPostCommand = new CreateActivityCommand(
            $postData[0],$postData[1],$postData[2],$postData[3],$postData[4]
        );

        $createPostUserCase->create($createPostCommand);
    }

    /**
     * @return array[]
     */
    public function provideTrimInvalidData(): array
    {
        return [
            [[Uuid::v6(),'walking','12','km', 0]],
            [[Uuid::v6(),'walking',0,'km', 13]]
        ];
    }
}