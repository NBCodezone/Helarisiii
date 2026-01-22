<?php
header('Content-Type: text/plain');

echo "=== PHP Configuration Check ===\n\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Loaded php.ini: " . php_ini_loaded_file() . "\n\n";

echo "=== FFI Status ===\n";
echo "FFI Extension Loaded: " . (extension_loaded('ffi') ? 'YES' : 'NO') . "\n";
echo "ffi.enable setting: " . ini_get('ffi.enable') . "\n\n";

echo "=== All Loaded Extensions ===\n";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    echo "- $ext\n";
}

echo "\n=== FFI in loaded extensions? ===\n";
echo (in_array('FFI', $extensions) ? 'YES - FFI is loaded!' : 'NO - FFI is NOT loaded');
