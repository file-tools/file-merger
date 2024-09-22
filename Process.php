<?php

require_once("Config.php");

// Function to sanitize and normalize a file path
function normalizeFilePath($path)
{
    // Remove trailing and leading whitespace and quotes
    $path = trim($path, " \t\n\r\0\x0B\"'");

    // Replace backslashes followed by a space with just a space
    $path = preg_replace('/\\\\ +/', ' ', $path);

    // Normalize directory separators to /
    $path = str_replace('\\', '/', $path);

    // Resolve relative paths
    $path = realpath($path);

    return $path;
}

$InputPath = normalizeFilePath($InputPath);

// Check if the input path is valid
if ($InputPath === false) {
    die("Error: Invalid input path.");
}

// Get all markdown files in the input directory
$markdownFiles = glob($InputPath . '/*.md');

// Check if files were found
if (empty($markdownFiles)) {
    die("No markdown files found in the input directory.");
}

// Group files by creation date
$groupedFiles = [];
foreach ($markdownFiles as $file) {
    $cmd = 'mdls -raw -name kMDItemFSCreationDate ' . escapeshellarg($file);

    $output = trim(shell_exec($cmd));
    if ($output === false || empty($output)) {
        echo "Error executing command for file: $file\n";
        continue;
    }

    $creationDateTime = strtotime($output);
    if ($creationDateTime === false) {
        echo "Error parsing date for file: $file\n";
        continue;
    }

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

        if ($creationTimeA === false || $creationTimeB === false) {
            return 0;
        }

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
        
        if ($creationTime === false) {
            echo "Error getting creation time for file: $file\n";
            continue;
        }

        $timeFormatted = date('H:i', $creationTime);
        $content = file_get_contents($file);

        if ($content === false) {
            echo "Error reading content of file: $file\n";
            continue;
        }

        // Add content to the merged file with the timestamp
        $mergedContent .= "\n\n" . $timeFormatted . ":\n\n" . $content;
    }

    // Define a filename for the merged content
    $filename = $creationDate . '_merged.md';
    file_put_contents($filename, $mergedContent);
}

echo "Processing complete. Merged files created.\n";
