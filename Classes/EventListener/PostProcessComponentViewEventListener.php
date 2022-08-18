<?php

declare(strict_types=1);

namespace StudioMitte\FluidStyleguideEncore\EventListener;

use Sitegeist\FluidStyleguide\Event\PostProcessComponentViewEvent;
use Ssch\Typo3Encore\Asset\EntrypointLookup;
use Ssch\Typo3Encore\Integration\CacheFactory;
use Ssch\Typo3Encore\Integration\Filesystem;
use Ssch\Typo3Encore\Integration\JsonDecoder;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PostProcessComponentViewEventListener
{
    public function __invoke(PostProcessComponentViewEvent $event): void
    {
        $configuration = $this->getConfiguration();
        if (empty($configuration)) {
            return;
        }
        $jsonDecoder = new JsonDecoder();
        $io = new Filesystem();

        $cacheFactory = GeneralUtility::makeInstance(CacheFactory::class);
        $entryPointLookup = GeneralUtility::makeInstance(EntrypointLookup::class, $configuration['path'] ?? '', '_styleguide', true, $jsonDecoder, $io, $cacheFactory);

        foreach ($entryPointLookup->getCssFiles($configuration['entryName'] ?? 'app') as $css) {
            $event->addHeaderData(' <link rel="stylesheet" href="' . htmlspecialchars($css) . '" />');
        }
        foreach ($entryPointLookup->getJavaScriptFiles($configuration['entryName'] ?? 'app') as $js) {
            $event->addHeaderData('<script src="' . htmlspecialchars($js) . '"></script>');
        }
    }

    /**
     * @return string[]
     */
    protected function getConfiguration(): array
    {
        try {
            return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('fluid_styleguide_encore');
        } catch (\Exception $e) {
            // do nothing
        }
        return [];
    }
}
