#!/bin/bash
set -e

# Render provides PORT at runtime; default to 80 if not set (e.g. local testing)
PORT="${PORT:-80}"

# Substitute the port into Apache's config files at container startup
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in the foreground
exec apache2-foreground
