<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventListener;

use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

final readonly class AdminListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    /**
     * @param GenericEvent $event
     */
    public function preDelete(GenericEvent $event): void
    {
        $subject = $subject = $event->getSubject();

        if (!$subject instanceof AdminUserInterface) {
            throw new UnexpectedTypeException($subject, AdminUserInterface::class);
        }

        if ('sylius@example.com' === $subject->getEmailCanonical()) {

            /** @var Session $session */
            $session = $this->requestStack->getSession();

            $session->getFlashBag()->add('error', 'sylius_demo.admin_account.prevent_delete');
            $event->stopPropagation();
        }
    }

    /**
     * @param GenericEvent $event
     */
    public function preUpdate(GenericEvent $event): void
    {
        $subject = $event->getSubject();

        if (!$subject instanceof AdminUserInterface) {
            throw new UnexpectedTypeException($subject, AdminUserInterface::class);
        }

        if ('sylius@example.com' === $subject->getEmailCanonical()) {

            /** @var Session $session */
            $session = $this->requestStack->getSession();

            $session->getFlashBag()->add('error', 'sylius_demo.admin_account.prevent_edit');
            $event->stopPropagation();
        }
    }
}
