<?php


namespace App\EventListener;


use App\Entity\Entretien;
use App\Repository\EntretienRepository;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FullCalendarListener
{
    private $entretienRepository;
    private $router;

    public function __construct(
        EntretienRepository  $entretienRepository,
        UrlGeneratorInterface $router
    ) {
        $this->entretienRepository = $entretienRepository;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();


        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $entretien = $this->entretienRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($entretien as $Entretien) {
            // this create the events with your own entity (here booking entity) to populate calendar
            $entretienEvent = new Event(
                $Entretien->getTitle(),
                $Entretien->getBeginAt(),
                $Entretien->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setUrl('http://www.google.com');
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $entretienEvent->setUrl(
                $this->router->generate('entretien_show', [
                    'id' => $entretien->getId(),
                ])
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($entretienEvent);
        }
    }
}