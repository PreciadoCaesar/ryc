<?php
// Make a real HTTP request to render the form
$ch = curl_init('http://localhost/ryc/admin/cursos/create');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";

// Extract HTML body (after headers)
$parts = explode("\r\n\r\n", $response, 2);
$html = $parts[1] ?? $response;

// Save to file
file_put_contents(__DIR__ . '/debug-form-rendered.html', $html);
$lines = explode("\n", $html);
echo "Total lines: " . count($lines) . "\n";

// Extract JavaScript between <script> tags
preg_match_all('/<script>(.*?)<\/script>/s', $html, $matches, PREG_OFFSET_CAPTURE);

$jsFound = 0;
foreach ($matches[1] as $idx => $match) {
    $js = $match[0];
    $offset = $match[1];
    if (strlen($js) > 100) {
        $jsFound++;
        $filename = __DIR__ . "/debug-form-js-$jsFound.js";
        file_put_contents($filename, $js);
        
        // Check syntax
        $output = shell_exec("node --check " . escapeshellarg($filename) . " 2>&1");
        $exitCode = trim(shell_exec("echo $?"));
        
        echo "\n--- JS Block $jsFound (line ~" . substr_count(substr($html, 0, $offset), "\n") . ", " . strlen($js) . " chars) ---\n";
        
        if ($exitCode === '0') {
            echo "✓ SYNTAX OK\n";
        } else {
            echo "✗ SYNTAX ERROR:\n";
            echo $output . "\n";
            
            // Show surrounding lines
            $blockStart = substr_count(substr($html, 0, $offset), "\n");
            for ($i = max(0, $blockStart - 3); $i <= $blockStart + 5; $i++) {
                if (isset($lines[$i])) {
                    echo "  L" . ($i + 1) . ": " . htmlspecialchars($lines[$i]) . "\n";
                }
            }
        }
    }
}

echo "\nTotal JS blocks > 100 chars: $jsFound\n";
