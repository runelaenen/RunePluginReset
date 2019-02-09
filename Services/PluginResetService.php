<?php

namespace RunePluginReset\Services;

use Enlight_Components_Db_Adapter_Pdo_Mysql;

/**
 * Class PluginResetService
 * @package RunePluginReset\Services
 */
class PluginResetService
{
    /**
     * @var Enlight_Components_Db_Adapter_Pdo_Mysql
     */
    private $db;

    /**
     * PluginResetService constructor.
     * @param Enlight_Components_Db_Adapter_Pdo_Mysql $db
     */
    public function __construct(
        Enlight_Components_Db_Adapter_Pdo_Mysql $db
    ){
        $this->db = $db;
    }

    /**
     * @return array
     * @throws \Zend_Db_Adapter_Exception
     * @throws \Zend_Db_Statement_Exception
     */
    public function resetPlugins()
    {
        $query = $this->db->query("SELECT `id`, `name` FROM s_core_plugins WHERE active = 1 AND capability_secure_uninstall = 1");
        $dbPlugins = $query->fetchAll();

        /** @var Kernel $kernel */
        $kernel = Shopware()->Container()->get('kernel');
        $plugins = $kernel->getPlugins();

        $disabled = [];

        foreach ($dbPlugins as $dbPlugin) {
            if(!isset($plugins[$dbPlugin['name']])) {
                $this->db->query("UPDATE s_core_plugins SET active = 0 WHERE id = :pluginId", ['pluginId' => $dbPlugin['id']]);

                $disabled[] = $dbPlugin['name'];
            }
        }

        return $disabled;
    }

}
