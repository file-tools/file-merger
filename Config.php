<?php
/*
Ideas could add: 
- FILE FORMATS: Currently only markdown files but could add a option to switch output file format and input ... 
- CUSTOM OUTPUT FORMATS: If you want to customize the output formats to use Bullets or not include time or anything -- like adding a templating method ... currently limited to my preference of using DateTime at the top. 
- Merge to one file instead of multiple (would need to add new header to distinquish days)
- Change date ordering - ASC or DESC ... currently latest at top, my default
*/

// Set the timezone to New York
date_default_timezone_set('America/New_York');

// Define input and output paths
$InputPath = '/Users/Reess/Library/Mobile Documents/iCloud~co~fluder~fsnotes/Documents/Obsidian';
$OutputPath = '/Users/Reess/Desktop/OutFS';

// Date formate for output files 
$DateFormat = 'Y_m_d';


