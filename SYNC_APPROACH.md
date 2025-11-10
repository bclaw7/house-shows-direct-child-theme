# Repository Sync Approach

## Situation

Your WordPress site already has a **BuddyBoss Child** theme installed with existing customizations:
- Admin bar "Vendors" button
- Custom CSS for Eventin plugin (currently commented out)
- References to `/assets/css/custom.css` and `/assets/js/custom.js`

## Solution

Instead of creating a new child theme, we've **synced the GitHub repository** to match your existing live child theme structure. This approach:

✅ Preserves all existing functionality  
✅ Maintains the current theme structure  
✅ Allows seamless deployment via WP Pusher  
✅ Enables version control for future changes  

## What Was Done

1. **Updated `functions.php`**:
   - Kept all existing BuddyBoss child theme setup functions
   - Preserved the admin bar button code
   - Added migrated email customization from WPCode
   - Added placeholder for Gravity Forms snippet
   - Kept the commented Eventin CSS code (for reference)

2. **Updated `style.css`**:
   - Matched the live theme header exactly
   - Maintains compatibility with existing theme

3. **Created asset directories**:
   - `/assets/css/custom.css` - For custom CSS (currently empty, but structure ready)
   - `/assets/js/custom.js` - For custom JavaScript (currently empty, but structure ready)

4. **Updated documentation**:
   - README.md reflects the actual theme structure
   - MIGRATION_GUIDE.md updated for existing theme workflow

## Next Steps

1. **Add Gravity Forms snippet** to `functions.php` (around line 80)
2. **Commit and push** to GitHub
3. **Set up WP Pusher** on WordPress site
4. **Deploy** - WP Pusher will update your existing "BuddyBoss Child" theme with the GitHub version
5. **Test** - Verify all functionality works
6. **Deactivate WPCode snippets** once confirmed working

## Important Notes

- The theme name in `style.css` remains "BuddyBoss Child" to match the live site
- WP Pusher will update the existing theme, not create a new one
- All existing functionality is preserved in the GitHub version
- The `/assets/` directory structure matches what the live theme expects

## File Structure

```
house-shows-direct-child-theme/
├── functions.php          # All theme functions (existing + migrated snippets)
├── style.css              # Theme header (matches live theme)
├── assets/
│   ├── css/
│   │   └── custom.css     # Custom CSS (enqueued by functions.php)
│   └── js/
│       └── custom.js      # Custom JS (enqueued by functions.php)
├── README.md
├── MIGRATION_GUIDE.md
└── SYNC_APPROACH.md       # This file
```

