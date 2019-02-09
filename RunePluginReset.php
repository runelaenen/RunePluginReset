<?php

namespace RunePluginReset;

use Shopware\Components\Plugin;
use Shopware\Components\Console\Application;
use RunePluginReset\Commands\PluginReset;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin RunePluginReset.
 */
class RunePluginReset extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('rune_plugin_reset.plugin_dir', $this->getPath());
        parent::build($container);
    }

}
