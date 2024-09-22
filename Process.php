<?php

require_once("Config.php");

// Function to sanitize and normalize a file path
function normalizeFilePath($path)
{
    // Remove trailing and leading whitespace and quotes
    $path = trim($path, " \t\n\r\0\x0B\"\'");

    // Replace backslashes followed by a space with just a space
    $path = preg_replace('/\\\\ +/', ' ', $path);

    // Normalize directory separators to /
    $path = str_replace('\\', '/', $path);

    // Resolve relative paths
    $path = realpath($path);

    return $path;
}

$InputPath = normalizeFilePath($InputPath);

// Get all markdown files in the input directory
$markdownFiles = glob($InputPath . '/*.md');

// Group files by creation date
$groupedFiles = [];
foreach ($markdownFiles as $file) {
    $cmd = 'mdls -raw -name kMDItemFSCreationDate ' . escapeshellarg($file);
    $creationDateTime = strtotime(trim(shell_exec($cmd)));
    $creationDate = date('Y_m_d', $creationDateTime);
    $groupedFiles[$creationDate][] = $file;
}

// Process each group and create a merged file for each day
foreach ($groupedFiles as $creationDate => $files) {
    // Sort files within each group by creation time (earliest to latest)
    usort($files, function ($a, $b) {
        $cmdA = 'mdls -raw -name kMDItemFSCreationDate ' . escapeshellarg($a);
        $cmdB = 'mdls -raw -name kMDItemFSCreationDate ' . escapeshellarg($b);
        $creationTimeA = strtotime(trim(shell_exec($cmdA)));
        $creationTimeB = strtotime(trim(shell_exec($cmdB)));

        return $creationTimeA <=> $creationTimeB;
    });

    // Initialize an empty string to store the merged content
    $mergedContent = '';
    $filename = ''; // Initialize outside the loop

    // Iterate through each markdown file in the group (in reverse order)
    foreach (array_reverse($files) as $file) {
        // Get creation time in military format (hour:minute)
        $cmd = 'mdls -raw -name kMDItemFSCreationDate ' . escapeshellarg($file);
        $creationTime = strtotime(trim(shell_exec($cmd)));
        $creationHour = date('H_i', $creationTime);

        // Add filename as the merged file name
        $filename = $creationDate . '-' . $creationHour . '.md';

        // Add content to merged file
        $mergedContent .= file_get_contents($file) . "\n\n";
    }

    // Write the merged content to a new file
    file_put_contents($InputPath . '/' . $filename, $mergedContent);
}
