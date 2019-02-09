<?php

namespace RunePluginReset\Subscriber;

use Enlight\Event\SubscriberInterface;
use RunePluginReset\Services\PluginResetService;

/**
 * Class ClearCacheSubscriber
 * @package RunePluginReset\Subscriber
 */
class ClearCacheSubscriber implements SubscriberInterface
{
    /**
     * @var PluginResetService
     */
    private $pluginResetService;

    /**
     * ClearCacheSubscriber constructor.
     * @param PluginResetService $pluginResetService
     */
    public function __construct(
        PluginResetService $pluginResetService
    ) {

        $this->pluginResetService = $pluginResetService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Bootstrap_AfterInitResource_shopware.commands.cache_clear_command' => 'onClearCache'
        );
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     * @throws \Zend_Db_Adapter_Exception
     * @throws \Zend_Db_Statement_Exception
     */
    public function onClearCache(\Enlight_Event_EventArgs $args)
    {
        $disabled = $this->pluginResetService->resetPlugins();
        if(count($disabled)) {
            printf("[RunePluginReset] %1 plugins disabled\n", count($disabled));
        }
    }
}
