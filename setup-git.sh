#!/bin/bash
# Setup script for connecting child theme to GitHub repository

# Initialize git repository
git init

# Add remote repository
git remote add origin https://github.com/bclaw7/house-shows-direct-child-theme.git

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: House Shows Direct child theme setup"

# Set main branch (if not already set)
git branch -M main

# Push to GitHub (you may need to authenticate)
echo "Ready to push! Run: git push -u origin main"
echo "Note: You may need to authenticate with GitHub first."

