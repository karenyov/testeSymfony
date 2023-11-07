<?php

namespace App\Core\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListener
{
    private $environment;
    private $translator;

    public function __construct(TranslatorInterface $translator, string $environment)
    {
        $this->translator = $translator;
        $this->environment = $environment;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = $this->createApiResponse($exception);

        $event->setResponse($response);
    }

    private function createApiResponse(\Throwable $exception): JsonResponse
    {
        $statusCode = $this->getStatusCode($exception);
        $message = $this->getExceptionMessage($exception, $statusCode);

        $data = [
            'error' => [
                'code' => $statusCode,
                'message' => $message,
            ],
        ];

        return new JsonResponse($data, $statusCode);
    }

    private function getStatusCode(\Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }
        return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function getExceptionMessage(\Throwable $exception, int $statusCode): string
    {
        if ($this->environment === 'dev' && $statusCode >= 500) {
            return $exception->getMessage();
        }

        $label = 'server_error_message';
        if ($statusCode >= 400 && $statusCode < 500) {
            $statusCodeKey = "client_error_message_$statusCode";
            $translatedMessage = $this->translator->trans($statusCodeKey);

            $label = $statusCodeKey !== $translatedMessage ? $statusCodeKey : $label;
        }

        return $this->translator->trans($label);
    }
}
