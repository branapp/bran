<?php 
class PluginLoader {
    private $plugins = [];

    public function loadPlugins() {
        // Scan each plugin directory under /plugins
        $pluginDirs = glob('../plugins/*' , GLOB_ONLYDIR);
        foreach ($pluginDirs as $dir) {
            $pluginFile = $dir . '/index.php';
            if (file_exists($pluginFile)) {
                require_once $pluginFile;
                $className = basename($dir);
                if (class_exists($className) && in_array('PluginInterface', class_implements($className))) {
                    $this->plugins[] = new $className();
                }
            }
        }
    }

    public function executePlugins() {
        foreach ($this->plugins as $plugin) {
            $plugin->execute();
        }
    }
}

