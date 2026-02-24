#!/bin/bash
# Pull latest code from WP Engine production
# Usage: ./pull-from-production.sh

set -e  # Exit on error

echo "=========================================="
echo "Pulling latest code from WP Engine production"
echo "=========================================="
echo ""
echo "Source: houseshows@houseshows.ssh.wpengine.net:/sites/houseshows/wp-content/themes/house-shows-direct-child-theme/"
echo "Destination: $(pwd)"
echo ""

# Check if we're in a git repository
if [ ! -d .git ]; then
    echo "⚠️  Warning: Not in a git repository directory"
    echo "   Make sure you're in the correct directory"
    read -p "Continue anyway? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Test SSH connection first
echo "Testing SSH connection..."
if ! ssh -o ConnectTimeout=5 houseshows@houseshows.ssh.wpengine.net "echo 'SSH connection successful'" 2>/dev/null; then
    echo "❌ Error: Cannot connect to WP Engine via SSH"
    echo ""
    echo "Troubleshooting:"
    echo "  1. Verify SSH keys are configured in WP Engine portal"
    echo "  2. Test manually: ssh houseshows@houseshows.ssh.wpengine.net"
    echo "  3. Check your SSH key: ls -la ~/.ssh/"
    exit 1
fi

echo "✅ SSH connection successful"
echo ""

# Show current git status before pull
echo "Current git status:"
git status --short || echo "Not a git repo or no changes"
echo ""

# Pull from WP Engine
echo "Syncing files from WP Engine..."
rsync -avz --delete \
  --exclude='.git' \
  --exclude='.DS_Store' \
  --exclude='*.log' \
  houseshows@houseshows.ssh.wpengine.net:/sites/houseshows/wp-content/themes/house-shows-direct-child-theme/ \
  ./

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Pull complete!"
    echo ""
    echo "Files changed:"
    git status --short || echo "No git changes detected"
    echo ""
    echo "Next steps:"
    echo "  1. Review changes: git status"
    echo "  2. See differences: git diff"
    echo "  3. If you want to commit the sync:"
    echo "     git add ."
    echo "     git commit -m 'Sync with WP Engine production - $(date +%Y-%m-%d)'"
    echo "  4. Make your changes"
    echo "  5. Push to GitHub: ./push-to-github.sh"
    echo ""
else
    echo ""
    echo "❌ Error: Failed to pull from WP Engine"
    echo ""
    echo "Troubleshooting:"
    echo "  1. Verify the path is correct on WP Engine"
    echo "  2. Check SSH access: ssh houseshows@houseshows.ssh.wpengine.net"
    echo "  3. Verify rsync is installed: which rsync"
    exit 1
fi

