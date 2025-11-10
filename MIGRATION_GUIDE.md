# Migration Guide: WPCode to Child Theme

This guide walks you through completing the migration from WPCode snippets to the child theme workflow.

## Important Note

**Your WordPress site already has a child theme installed** (BuddyBoss Child). This GitHub repository has been updated to match your existing live child theme structure. All existing functionality has been preserved, and we're adding the WPCode snippets to the existing theme.

## Current Status

✅ **Repository synced** - GitHub repo now matches live child theme structure  
✅ **Email Snippet** - Migrated to `functions.php`  
✅ **Dokan Template** - `dokan/seller-warning.php` added  
⏳ **Gravity Forms Snippet** - Needs to be added

## Step 1: Get Gravity Forms Snippet Code

1. Log into WordPress admin at https://houseshowsdirect.com/wp-admin
2. Navigate to **WPCode → Code Snippets**
3. Find the Gravity Forms registration form snippet
4. Click to view/edit the snippet
5. Copy the entire PHP code from the snippet
6. The code should start with something like `add_filter`, `add_action`, or a function definition

## Step 2: Add Missing File Content

### 2.1 Add Gravity Forms Code to Child Theme

1. Open `functions.php` in this repository
2. Find the section marked:
   ```php
   /**
    * Gravity Forms Registration Form Customizations
    * ...
    * TODO: Add the Gravity Forms registration form snippet code here.
    */
   ```
3. Replace the comment `// Add your Gravity Forms registration form code below this comment` with your actual code
4. Ensure proper WordPress coding standards (indentation, spacing)
5. Add comments explaining what the code does (if not already documented)

### 2.2 Dokan Template Content

✅ **Completed** - The `dokan/seller-warning.php` file has been added with the custom vendor approval message.

## Step 3: Test Locally (Optional but Recommended)

If you have a local WordPress development environment:

1. Copy the child theme to your local WordPress `wp-content/themes/` directory
2. Activate the child theme
3. Test the Gravity Forms registration form functionality
4. Test email functionality (password reset, contact forms, etc.)
5. Verify everything works as expected

## Step 4: Commit and Push to GitHub

Once the Gravity Forms code is added:

```bash
cd house-shows-direct-child-theme
git add functions.php
git commit -m "Add Gravity Forms registration form customization"
git push origin main
```

## Step 5: Set Up WP Pusher on WordPress Site

### 5.1 Install WP Pusher Plugin

1. Log into WordPress admin
2. Go to **Plugins → Add New**
3. Search for "WP Pusher"
4. Install and activate the plugin

### 5.2 Get WP Pusher License (if needed)

- If your GitHub repo is **public**: Free version works
- If your GitHub repo is **private**: Purchase license at https://wppusher.com ($99/year for Freelancer plan)

### 5.3 Create GitHub Personal Access Token

1. Go to https://github.com/settings/tokens
2. Click **Generate new token (classic)**
3. Give it a name like "WP Pusher - House Shows Direct"
4. Select scope: **repo** (full control of private repositories)
5. Click **Generate token**
6. **Copy the token immediately** (you won't see it again)

### 5.4 Connect Repository in WP Pusher

1. In WordPress admin, go to **WP Pusher → Themes**
2. Click **Install theme**
3. Fill in:
   - **Repository**: `bclaw7/house-shows-direct-child-theme`
   - **Branch**: `main`
   - **GitHub token**: Paste your personal access token
4. Click **Install theme**

### 5.5 Enable Push-to-Deploy (Recommended)

1. In WP Pusher settings, enable **Push-to-Deploy**
2. Copy the webhook URL provided
3. Go to GitHub: https://github.com/bclaw7/house-shows-direct-child-theme/settings/hooks
4. Click **Add webhook**
5. Paste the webhook URL
6. Content type: **application/json**
7. Events: Select **Just the push event**
8. Click **Add webhook**

Now, every time you push to GitHub, the theme will automatically update on your WordPress site!

## Step 6: Deploy Child Theme via WP Pusher

Since your child theme is already active on the live site, WP Pusher will update the existing theme:

1. After connecting the repository in WP Pusher, click **Install theme** (or **Update** if already installed)
2. WP Pusher will sync the GitHub version with your live theme
3. Verify your site still looks and works correctly
4. The existing "BuddyBoss Child" theme will be updated with the GitHub version

## Step 7: Test Functionality

1. **Test Email**:
   - Trigger a password reset email
   - Check that "From" address is `bj@houseshowsdirect.com`
   - Check that "From" name is "House Shows Direct"

2. **Test Gravity Forms**:
   - Test the registration form
   - Verify all custom functionality works

## Step 8: Deactivate WPCode Snippets

Once everything is working:

1. Go to **WPCode → Code Snippets**
2. Deactivate the email snippet
3. Test email functionality
4. Deactivate the Gravity Forms snippet
5. Test Gravity Forms functionality
6. If everything works, you can optionally delete the snippets or keep them deactivated as backup

## Step 9: Ongoing Workflow

For future customizations:

1. **Make changes locally** in the child theme files
2. **Test locally** (if possible)
3. **Commit to Git**: `git add . && git commit -m "Description of changes" && git push`
4. **Auto-deploy**: If Push-to-Deploy is enabled, changes go live automatically
5. **Or manual deploy**: Go to WP Pusher → Themes and click "Update"

## Troubleshooting

### Theme not updating after push
- Check webhook is configured correctly in GitHub
- Verify GitHub token has correct permissions
- Check WP Pusher logs in WordPress admin

### Site breaks after activating child theme
- Deactivate child theme immediately
- Check error logs in WP Engine portal
- Review code for syntax errors
- Test in staging environment first

### Email not working
- Verify email snippet code is correct in `functions.php`
- Check that filters are properly added
- Test with a plugin like "Check Email" to verify

### Gravity Forms not working
- Verify all Gravity Forms hooks are correct
- Check for conflicts with other plugins
- Review Gravity Forms error logs

## Support

- WP Pusher Documentation: https://wppusher.com/docs
- WordPress Child Theme Guide: https://developer.wordpress.org/themes/advanced-topics/child-themes/
- WP Engine Support: Available via their portal

