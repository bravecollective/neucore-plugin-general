<?php

namespace BraveCollective\NeucorePluginGeneral;

use Neucore\Plugin\Core\FactoryInterface;
use Neucore\Plugin\Core\OutputInterface;
use Neucore\Plugin\Data\CoreAccount;
use Neucore\Plugin\Data\CoreRole;
use Neucore\Plugin\Data\NavigationItem;
use Neucore\Plugin\Data\PluginConfiguration;
use Neucore\Plugin\Exception;
use Neucore\Plugin\GeneralInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Plugin implements GeneralInterface
{
    public function __construct(
        LoggerInterface $logger,
        PluginConfiguration $pluginConfiguration,
        FactoryInterface $factory,
    ) {
    }

    public function onConfigurationChange(): void
    {
    }

    public function request(
        string $name,
        ServerRequestInterface $request,
        ResponseInterface $response,
        ?CoreAccount $coreAccount,
    ): ResponseInterface {

        if ($name === 'brave-discord-invite') {
            return $response
                ->withHeader('Location', 'https://discord.gg/9Wwub4BfNs')
                ->withStatus(302);
        }
        if ($name === 'imperium-auth') {
            return $response
                ->withHeader('Location', 'https://esi.goonfleet.com/')
                ->withStatus(302);
        }

        throw new Exception("Invalid request: $name");
    }

    public function getNavigationItems(): array
    {
        return [
            new NavigationItem(
                NavigationItem::PARENT_SERVICE,
                'Public Discord Server: Brave Diplo + Recruitment',
                '/brave-discord-invite',
                '_blank',
                [CoreRole::ANONYMOUS, CoreRole::USER]
            ),
            new NavigationItem(
                NavigationItem::PARENT_SERVICE,
                'Imperium Auth',
                '/imperium-auth',
                '_blank',
                [CoreRole::USER]
            ),
        ];
    }

    public function command(array $arguments, array $options, OutputInterface $output): void
    {
    }
}
