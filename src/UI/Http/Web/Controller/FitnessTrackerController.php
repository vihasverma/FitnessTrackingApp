<?php

namespace App\UI\Http\Web\Controller;

use App\Application\UseCase\Command\Fitness\CreateActivityCommand;
use App\Application\UseCase\Command\Fitness\CreateActivityUseCase;
use App\Application\UseCase\Query\Fitness\ReadActivityUseCase;
use App\Domain\Fitness\Exception\InvalidActivityDataException;
use App\UI\Http\Web\Form\ActivityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */
class FitnessTrackerController extends AbstractController
{
    /**
     * @param TokenStorageInterface $storage
     */
    public function __construct(
        TokenStorageInterface $storage,
    )
    {
        $this->tokenStorage = $storage;
    }

    /**
     * @param Request $request
     * @param CreateActivityUseCase $createActivityUseCase
     * @param TokenStorageInterface $storage
     * @return Response
     */
    #[Route('/activity/create', name: 'activity_create')]
    public function __invoke(Request $request, CreateActivityUseCase $createActivityUseCase): Response
    {
        $form = $this->createForm(ActivityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            /** @var string $activityType */
            $activityType = $form->get('activityType')->getData();
            /** @var float $distance */
            $distance = $form->get('distance')->getData();
            /** @var string $distanceUnit */
            $distanceUnit = $form->get('distanceUnit')->getData();
            /** @var int $timeElapsed */
            $elapsedTime = $form->get('elapsedTime')->getData();
            /** @var string $userId */
            if ($this->tokenStorage->getToken() instanceof TokenInterface) {
                $userId = $this->tokenStorage->getToken()->getUser()->getId();
            }
            $createActivityCommand = new CreateActivityCommand($userId, $activityType, $distance, $distanceUnit, $elapsedTime);
            try {
                $createActivityUseCase->create($createActivityCommand);
                $this->addFlash('success', "Activity created.");
                return $this->redirectToRoute('activity_create');
            } catch (InvalidActivityDataException $dataException) {
                $this->addFlash('error', $dataException->getMessage());
            }
        }

        return $this->render('fitness/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param ReadActivityUseCase $activityUseCase
     * @return Response
     */
    #[Route('/activity', name: 'activity')]
    public function showActivities(Request $request, ReadActivityUseCase $activityUseCase): Response
    {
        $activityTypeTotalTimes = [];
        $userId = null;
        if ($this->tokenStorage->getToken() instanceof TokenInterface) {
            $userId = $this->tokenStorage->getToken()->getUser()->getId();
        }
        $activity_type = $request->get('activity_type');
        $activityTypeTotalTimes = $activityUseCase->totalElapsedTimePerActivityType($userId);
        if ($activity_type != '') {
            $activities = $activityUseCase->findAllFilterByActivityType($userId, $activity_type);
        } else {
            $activities = $activityUseCase->findAll($userId);
        }
        return $this->render('fitness/list.html.twig', [
            'activities' => $activities,
            'activityTypeTotalTimes' => $activityTypeTotalTimes
        ]);
    }
}