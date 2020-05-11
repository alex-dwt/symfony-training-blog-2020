<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Bus\Message\CreateUserCommand;
use App\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Annotation\ControllerActionResponseCode;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route(methods={"POST"})
     * @ControllerActionResponseCode(201)
     */
    public function createUserAction(
        Request $request
    ) {
        $name = trim((string) $request->get('name'));
        $city = trim((string) $request->get('city'));
        $country = strtoupper(trim((string) $request->get('country')));

        if ($name === ''
            || $city === ''
            || !Countries::alpha3CodeExists($country)
        ) {
            return new JsonResponse(['message' => 'Validation error'], 422);
        }

        /** @var User $user */
        $user = $this->dispatchMessage(
            new CreateUserCommand(
                $name,
                $country,
                $city
            ))
            ->last(HandledStamp::class)
            ->getResult();

        return $user->toArray();
    }
}
