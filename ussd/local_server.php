<?php
// Simple local server for USSD testing
// Run with: php local_server.php

$host = '127.0.0.1';
$port = 8080;

echo "Starting USSD server on http://{$host}:{$port}\n";
echo "Press Ctrl+C to stop\n\n";

// Start the built-in PHP server
$command = "php -S {$host}:{$port} -t .";
passthru($command);
