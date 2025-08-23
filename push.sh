#!/bin/bash
# Quick commit + push helper for 49bespoke repo
# Stages ALL changes (added, deleted, modified) and pushes to GitHub main.

cd /home/pfcd/49b4.pfcd.ca || exit 1

git add -A
git commit -m "Update from server edit on $(date +%F-%H%M)"
git push origin main

