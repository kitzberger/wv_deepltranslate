<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\DependencyInjection\SingletonPass;
use WebVision\WvDeepltranslate\Command\GlossaryCleanupCommand;
use WebVision\WvDeepltranslate\Command\GlossaryListCommand;
use WebVision\WvDeepltranslate\Command\GlossarySyncCommand;
use WebVision\WvDeepltranslate\Hooks\Glossary\UpdatedGlossaryEntryTermHook;
use WebVision\WvDeepltranslate\Service\DeeplGlossaryService;
use WebVision\WvDeepltranslate\Service\DeeplService;
use WebVision\WvDeepltranslate\Service\LanguageService;

return function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder) {
    $services = $containerConfigurator
        ->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // Main DI
    $services
        ->load('WebVision\\WvDeepltranslate\\', '../Classes/')
        ->exclude('../Classes/{Domain/Model,Override/DatabaseRecordList.php}');

    // register console commands
    $services
        ->set(GlossaryCleanupCommand::class)
        ->tag(
            'console.command',
            [
                'command' => 'deepl:glossary:cleanup',
                'schedulable' => true,
            ]
        );
    $services
        ->set(GlossarySyncCommand::class)
        ->tag(
            'console.command',
            [
                'command' => 'deepl:glossary:sync',
                'schedulable' => true,
            ]
        );
    $services
        ->set(GlossaryListCommand::class)
        ->tag(
            'console.command',
            [
                'command' => 'deepl:glossary:list',
                'schedulable' => false,
            ]
        );

    // add caching

    $services->set('cache.wvdeepltranslate')
        ->class(FrontendInterface::class)
        ->factory([service(CacheManager::class), 'getCache'])
        ->args(['wvdeepltranslate']);
    $services
        ->set(DeeplService::class)
        ->public()
        ->arg('$cache', service('cache.wvdeepltranslate'));
    $services
        ->set(DeeplGlossaryService::class)
        ->public()
        ->arg('$cache', service('cache.wvdeepltranslate'));
    $services
        ->set(LanguageService::class)
        ->public();

    $containerBuilder
        ->registerForAutoconfiguration(UpdatedGlossaryEntryTermHook::class)
        ->addTag('deepl.UpdatedGlossaryEntryTermHook');

    $containerBuilder
        ->addCompilerPass(new SingletonPass('deepl.UpdatedGlossaryEntryTermHook'));
};
