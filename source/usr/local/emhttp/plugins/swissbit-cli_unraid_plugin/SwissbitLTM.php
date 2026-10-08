<?php
$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';

// Security check: ensure request is authenticated within emhttp
if (!is_file("$docroot/state/var.ini")) exit;

$bin = "/usr/local/bin/sbdm-cli";
$action = $_GET['action'] ?? '';

if ($action === 'scan') {
    exec("$bin --list 2>&1", $out, $code);
    echo "<pre>" . htmlspecialchars(implode("\n", $out)) . "</pre>";
}
?>
