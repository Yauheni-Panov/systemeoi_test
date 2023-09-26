<?php

namespace App\EventSubscriber;

use App\Model\Exception\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException']
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if($exception instanceof ApiException){
            $errors = (!empty($exception->getErrors())) ? $exception->getErrors() : ['error' => $exception->getMessage()];
            $event->setResponse(
                new JsonResponse($errors, Response::HTTP_BAD_REQUEST)
            );
        }
    }
}