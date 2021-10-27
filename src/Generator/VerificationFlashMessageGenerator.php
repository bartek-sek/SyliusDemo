<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Generator;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class VerificationFlashMessageGenerator implements FlashMessageGeneratorInterface
{
    private UrlGeneratorInterface $urlGenerator;

    private TranslatorInterface $translator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    public function generate(string $token): string
    {
        $url = $this
            ->urlGenerator
            ->generate('sylius_shop_user_verification', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL)
        ;

        $message = $this->translator->trans('sylius_demo.verification_link_flash', [
            '%url%' => $url,
        ]);

        return $message;
    }
}
