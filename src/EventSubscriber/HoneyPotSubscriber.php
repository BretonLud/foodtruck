<?php

namespace App\EventSubscriber;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HoneyPotSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $honeyPotLogger;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(LoggerInterface $honeyPotLogger, RequestStack $requestStack){
        $this->honeyPotLogger = $honeyPotLogger;
        $this->requestStack = $requestStack;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'checkHoneyJar'
        ];
    }

    public function checkHoneyJar(FormEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request){
            return;
        }

        $data = $event->getData();

        if (!array_key_exists('Postal_code', $data) || !array_key_exists('Address', $data)){
            throw new HttpException(400, 'Ne pas toucher au formulaire');
        }

        [
            'Postal_code' => $birthday,
            'Address' => $adress
        ] = $data;

        if ($birthday !== "" || $adress !== ""){
            $this->honeyPotLogger->info("Une potentielle tentative de robot spammeur ayant l'adresse ip 
            '{$request->getClientIp()}' a eu lieu. 
            Le champ Birthday contenait '{$birthday}' et le champ Adresse contenait '{$adress}'.");
            throw new HttpException(403, "On t'a vu Mr le bot");
        }
    }
}