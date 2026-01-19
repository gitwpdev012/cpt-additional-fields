<?php
// WordPress plugin directory test
$plugin_dir = __DIR__ . '/plugins';
$your_plugin = $plugin_dir . '/test12345/test12345.php';

echo "<h3>Plugin Diagnostic</h3>";
echo "Plugins directory exists: " . (is_dir($plugin_dir) ? 'YEeeeS' : 'NO') . "<br>";
echo "Your plugin folder exists: " . (is_dir($plugin_dir . '/test12345') ? 'YES' : 'NO') . "<br>";
echo "Your plugin file exists: " . (file_exists($your_plugin) ? 'YES' : 'NO') . "<br>";
echo "Your plugin is readable: " . (is_readable($your_plugin) ? 'YES' : 'NO') . "<br>";

// List all plugins
echo "<h3>All Plugins Found:</h3>";
$plugins = glob($plugin_dir . '/*/*.php');
foreach ($plugins as $plugin) {
    echo htmlspecialchars(basename(dirname($plugin))) . "/" . basename($plugin) . "<br>";
}