# File Merger - FS Notes to Obsidian Daily Journal Converter

A PHP tool designed to transform scattered, on-the-fly text or markdown notes into organized daily summaries that are perfectly compatible with **Obsidian journal pages**.



## Why

When I'm out in the world and have a thought or idea, I like to just be able to log it quickly and not have to worry about whether I should put it in a certain folder. If I knew I had to make this additional decision, perhaps I wouldn't want to log my thought. 

Many notes apps work for quick logging thoughts but Obsidian, in my view, is not one of them. This is unfortunate because I actually use Obsdian for everything else. 

To solve for this limitation with Obsidian mobile app, I have landed on using FS Notes which is a native iOS app that writes notes to markdown files, just like Obsidian, which allows transfer between the two apps simple. 

The remaining issue is that I am generally a believer in the popular Obsidian-compatable note format of keeping a day-based journal for quick notes, maybe stored in a "journals" folder and a "pages" folder for more durable, important standalone notes. 

Within my journal notes, I always timestamp my thoughts like this: 

```
[16:24]
Idea - Study different indigenous grass types for law improvements

[13:24]
Finished writing quarterly reports
```

These notes generally aren't that important but good to have stored and accessible via search in Obsidian. 

This script allows me to take notes like these on FS Notes where they live as indpenedent files (e.g. an entire markdown files that just says "Finished writing quarterly reports") and then have this script merge that script into a file like "2025_05_05.md" along with other notes for that day with the proper header 

In short: 
- Obsidian is wonderful for storing and searching and formatting markdown notes and I want to keep this as my main infomation store. It not good, however, at quick capturing ideas on my phone, on the go. 
- FS Notes (and others) are native, fast apps that write to markdown files and much better for quick capture
- This script reformats my quick captures on FS Notes and prepared them for storage on Obsidian ... 



## The Solution

This tool automatically:
1. **Groups** your FS Notes markdown files by their creation date
2. **Merges** all notes from the same day into a single organized file
3. **Timestamps** each note with its original creation time (in military format)
4. **Formats** the output to be compatible with Obsidian's daily note structure
5. **Preserves** all original content while making it searchable and reviewable

## Key Benefits

- **🗂️ Organization**: Transform chaos into structure with daily summaries
- **⚡ Quick Review**: Scan an entire day's thoughts in one file instead of dozens
- **🔍 Better Search**: Obsidian can now search across consolidated daily content
- **📅 Journal Compatibility**: Files use standard date formats (YYYY_MM_DD.md)
- **⏰ Time Context**: Each note retains its original timestamp for reference
- **💾 Space Efficient**: Reduces file system clutter significantly

## How It Works

### Input Structure
Your FS Notes directory contains scattered markdown files:
```
textonly/
├── Quick thought about project.md
├── Meeting notes with John.md
├── Grocery list ideas.md
└── Random inspiration.md
```

### Output Structure
The tool creates organized daily files:
```
OutFS/
├── 2024_01_15.md
├── 2024_01_16.md
└── 2024_01_17.md
```

### File Format
Each daily summary file contains timestamped entries:
```markdown
# 14:30
Quick thought about project content here...

# 11:15
Meeting notes with John content here...

# 09:45
Grocery list ideas content here...
```

## Setup Instructions

### 1. Install PHP
Ensure you have PHP installed on your system (macOS usually includes it).

### 2. Configure the Tool
1. Change name of `config-sample.ini` to `config.ini`
2. Edit `config.ini` with your specific paths:
   - **timezone**: Your local timezone (e.g., "America/New_York")
   - **input_path**: Path to your FS Notes directory
   - **output_path**: Where you want the merged files saved
   - **date_format**: Date format for output files (default: "Y_m_d")

### 3. Run the Tool
```bash
php Process.php
```

## Configuration

The tool uses a simple INI configuration file:

```ini
timezone = "America/New_York"
input_path = "/Users/YourUsername/Library/Mobile Documents/iCloud~co~fluder~fsnotes/Documents/textonly"
output_path = "/Users/YourUsername/Desktop/OutFS/"
date_format = "Y_m_d"
```

## Integration with Obsidian

The output files are designed to work seamlessly with Obsidian:

1. **Daily Notes Plugin**: Files follow the standard daily note naming convention
2. **Search Functionality**: All content becomes searchable within Obsidian
3. **Linking**: You can link to specific days using `[[2024_01_15]]` syntax
4. **Templates**: The timestamp format (# HH:MM) creates natural section headers

## File Processing Details

- **Sorting**: Files are sorted by creation time within each day
- **Ordering**: Most recent notes appear at the top of each daily file
- **Timestamps**: Uses 24-hour format (military time) for precision
- **Preservation**: All original content is preserved exactly as written

## Requirements

- **PHP**: Version 7.0 or higher
- **macOS**: Uses `mdls` command for file metadata (macOS specific)
- **FS Notes**: Source files should be in markdown format

## Future Development Ideas

- Support for additional file formats beyond markdown
- Customizable output templates (bullets, different timestamp formats)
- Option to merge all notes into a single file instead of daily files
- Configurable date ordering (ascending vs descending)
- Cross-platform compatibility (Windows/Linux support)

## Use Cases

Perfect for:
- **Daily Journaling**: Convert scattered thoughts into coherent daily entries
- **Meeting Notes**: Consolidate multiple meeting notes from the same day  
- **Project Planning**: Organize brainstorming sessions by date
- **Research**: Group related research notes chronologically
- **Personal Knowledge Management**: Maintain searchable daily archives

## Why This Approach Works

Instead of managing hundreds of individual files, you get:
- **Contextual Grouping**: See all thoughts from a specific day together
- **Temporal Organization**: Natural chronological flow of ideas
- **Reduced Cognitive Load**: Fewer files to manage and navigate
- **Enhanced Discoverability**: Better search and linking capabilities
- **Obsidian Optimization**: Leverages Obsidian's strengths for knowledge management

This tool bridges the gap between quick capture (FS Notes) and organized review (Obsidian), creating a powerful workflow for knowledge workers, researchers, and anyone who values both spontaneous note-taking and structured information management.
