<?php

namespace RunePluginReset\Commands;

use RunePluginReset\Services\PluginResetService;
use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PluginReset
 * @package RunePluginReset\Commands
 */
class PluginReset extends ShopwareCommand
{
    /**
     * @var PluginResetService
     */
    private $pluginResetService;

    /**
     * PluginReset constructor.
     */
    public function __construct(
        PluginResetService $pluginResetService
    ){

        parent::__construct();
        $this->pluginResetService = $pluginResetService;
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rune:pluginreset:resetplugins')
            ->setDescription('Disabled removed plugins automatically')
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("*** Checking for removed but enabled plugins");

        $disabled = $this->pluginResetService->resetPlugins();

        if(count($disabled) == 0) {
            $output->writeln("*** No plugins disabled");
            return;
        }
        $output->writeln("*** " . count($disabled) . " plugin(s) disabled: " . implode(', ', $disabled));
    }
}
