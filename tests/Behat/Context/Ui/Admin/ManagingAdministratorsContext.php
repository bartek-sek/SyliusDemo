<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\Admin\Administrator\UpdatePageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Component\Core\Model\AdminUser;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingAdministratorsContext implements Context
{
    public function __construct(
        private NotificationCheckerInterface $notificationChecker,
        private RepositoryInterface $adminUserRepository,
        private UpdatePageInterface $adminUserUpdatePage
    ) {
    }

    /**
     * @When I want to edit administrator :email
     */
    public function iWantToEditAdministrator(string $email): void
    {
        /** @var AdminUser $admin */
        $admin = $this->adminUserRepository->findOneBy(['email' => $email]);

        Assert::notNull($admin);

        $this->adminUserUpdatePage->open(['id' => $admin->getId()]);
    }

    /**
     * @Then I should be notified that I cannot delete Administrator of Sylius Demo
     */
    public function iShouldBeNotifierThatICannotDeleteAdministratorOfSyliusDemo(): void
    {
        $this->notificationChecker->checkNotification(
            'You cannot delete administrator of Sylius Demo!',
            NotificationType::failure()
        );
    }

    /**
     * @Then I should be notified that I cannot edit Administrator of Sylius Demo
     */
    public function iShouldBeNotifierThatICannotEditAdministratorOfSyliusDemo(): void
    {
        $this->notificationChecker->checkNotification(
            'You cannot edit administrator of Sylius Demo!',
            NotificationType::failure()
        );
    }
}
