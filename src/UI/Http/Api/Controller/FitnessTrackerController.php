<?php

namespace App\UI\Http\Api\Controller;

use App\Application\UseCase\Command\Fitness\CreateActivityCommand;
use App\Application\UseCase\Command\Fitness\CreateActivityUseCase;
use App\Domain\Fitness\Exception\InvalidActivityDataException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FitnessTrackerController
{

    /** @var  TokenStorageInterface */
    private TokenStorageInterface $tokenStorage;

    /** @var  CreateActivityUseCase */
    private CreateActivityUseCase $activityUseCase;

    /**
     * @param TokenStorageInterface $storage
     */
    public function __construct(
        TokenStorageInterface $storage,
        CreateActivityUseCase $activityUseCase

    )
    {
        $this->tokenStorage = $storage;
        $this->activityUseCase = $activityUseCase;
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/api/create_activity')]
    public function __invoke(Request $request): Response
    {
        /** @var string $activityType */
        $activityType = $request->get('activityType');
        /** @var float $distance */
        $distance = $request->get('distance');
        /** @var string $distanceUnit */
        $distanceUnit = $request->get('distanceUnit');
        /** @var int $timeElapsed */
        $elapsedTime = $request->get('elapsedTime');
        /** @var string $userId */
        if ($this->tokenStorage->getToken() instanceof TokenInterface) {
            $userId = $this->tokenStorage->getToken()->getUser()->getId();
        }
        $createActivityCommand = new CreateActivityCommand($userId, $activityType, $distance, $distanceUnit, $elapsedTime);
        try {
            $this->activityUseCase->create($createActivityCommand);
            return new JsonResponse('ok');
        } catch (InvalidActivityDataException $dataException) {
            return new JsonResponse($dataException->getMessage(), 400);
        }

    }
}
