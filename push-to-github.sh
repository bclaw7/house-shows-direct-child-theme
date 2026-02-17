#!/bin/bash
# Helper script to push to GitHub using Personal Access Token
# Usage: ./push-to-github.sh

echo "Pushing to GitHub..."
echo ""
echo "When prompted:"
echo "  Username: bclaw7"
echo "  Password: [paste your Personal Access Token here]"
echo ""
echo "If you don't have a token yet, create one at:"
echo "https://github.com/settings/tokens"
echo ""

git push -u origin main


