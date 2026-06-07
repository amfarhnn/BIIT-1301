FROM php:8.2-apache-bookworm

ARG INSTANT_CLIENT_VERSION=19.30.0.0.0dbru
ARG INSTANT_CLIENT_DIR=instantclient_19_30
ARG INSTANT_CLIENT_URL_VERSION=1930000

RUN apt-get update \
    && apt-get install -y --no-install-recommends libaio1 unzip curl \
    && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL "https://download.oracle.com/otn_software/linux/instantclient/${INSTANT_CLIENT_URL_VERSION}/instantclient-basiclite-linux.x64-${INSTANT_CLIENT_VERSION}.zip" -o /tmp/basiclite.zip \
    && curl -fsSL "https://download.oracle.com/otn_software/linux/instantclient/${INSTANT_CLIENT_URL_VERSION}/instantclient-sdk-linux.x64-${INSTANT_CLIENT_VERSION}.zip" -o /tmp/sdk.zip \
    && mkdir -p /opt/oracle \
    && unzip -oq /tmp/basiclite.zip -d /opt/oracle \
    && unzip -oq /tmp/sdk.zip -d /opt/oracle \
    && rm /tmp/basiclite.zip /tmp/sdk.zip \
    && echo "/opt/oracle/${INSTANT_CLIENT_DIR}" > /etc/ld.so.conf.d/oracle-instantclient.conf \
    && ldconfig \
    && echo "instantclient,/opt/oracle/${INSTANT_CLIENT_DIR}" | pecl install oci8-3.4.1 \
    && docker-php-ext-enable oci8

WORKDIR /var/www/html
COPY WEB/ /var/www/html/
