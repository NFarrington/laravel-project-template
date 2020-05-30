#!/usr/bin/env sh

set -eu

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- nginx "$@"
fi

if [ "$1" = 'nginx' ] && [ "$(id -u)" = '0' ]; then
	# enable SSL if the certificates are made available
	if [ -f "/run/secrets/server.crt" ] && [ -f "/run/secrets/server.key" ] && [ -f "/etc/nginx/conf.d/default-ssl.conf.disabled" ]; then
		mv /etc/nginx/conf.d/default-ssl.conf.disabled /etc/nginx/conf.d/default-ssl.conf
	fi

	chown nginx:nginx /dev/std*
	exec su-exec nginx "$0" "$@"
fi

exec "$@"
