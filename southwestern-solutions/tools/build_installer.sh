#!/usr/bin/env bash
# Packages the one-click installer plugin: theme + import XMLs + bundled WordPress Importer.
set -e
cd "$(dirname "$0")/.."
I=installer/southwestern-site-installer
rm -rf $I/theme $I/data && mkdir -p $I/theme $I/data
cp -r theme/southwestern-solutions $I/theme/
cp import/southwestern-solutions.WordPress.xml import/southwestern-solutions-products.WordPress.xml $I/data/
mkdir -p release && rm -f release/southwestern-site-installer.zip
(cd installer && zip -qr ../release/southwestern-site-installer.zip southwestern-site-installer)
du -h release/southwestern-site-installer.zip
