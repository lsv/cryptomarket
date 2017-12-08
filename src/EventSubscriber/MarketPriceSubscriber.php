<?php

namespace App\EventSubscriber;

use App\Entity\MarketPrice;
use App\Event\TriggerEvent;
use App\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MarketPriceSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    private $mailer;

    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onGeneralTrigger(TriggerEvent $event)
    {
        $event->getOutput()->writeln('General triggered');
    }

    public function onLowprice(TriggerEvent $event)
    {
        $message = new \Swift_Message(
            sprintf(
                '[coiner] Low price triggered - %s: %s',
                $event->getMarketPrice()->getType(),
                $this->currencyConvert($event->getMarketPrice())
            ),
            "Hello\n\nLow price has triggered"
        );

        $this->mailer->send($message);
    }

    public function onHighprice(TriggerEvent $event)
    {
        $message = new \Swift_Message(
            sprintf(
                '[coiner] High price triggered - %s: %s',
                $event->getMarketPrice()->getType(),
                $this->currencyConvert($event->getMarketPrice())
            ),
            "Hello\n\nHigh price has triggered"
        );

        $this->mailer->send($message);
    }

    public function onDifference(TriggerEvent $event)
    {
        $message = new \Swift_Message(
            sprintf(
                '[coiner] Diff price triggered - %s: %s (%d)',
                $event->getMarketPrice()->getType(),
                $this->currencyConvert($event->getMarketPrice()), $event->getData()['difference']
            ),
            "Hello\n\nDifference price has triggered"
        );

        $this->mailer->send($message);
    }

    /**
     * @param MarketPrice $price
     *
     * @return string
     */
    private function currencyConvert(MarketPrice $price): string
    {
        return sprintf(
            '%s %s',
            $price->getPrice() / (int) '1'.str_repeat(0, $price->getDecimals()),
            $price->getCurrency()
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TriggerEvent::EVENT_NAME => 'onGeneralTrigger',
            'app.trigger.low' => 'onLowprice',
            'app.trigger.high' => 'onHighprice',
            'app.trigger.diff' => 'onDifference',
        ];
    }
}
