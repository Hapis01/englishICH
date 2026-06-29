# ======================
# Stage 1: Node – build Vite assets
# ======================
FROM node:20-alpine AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm ci --prefer-offline

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ======================
# Stage 2: PHP Runtime only (no code baked in)
# Code is bind-mounted from host at runtime via docker-compose volumes
# ======================
FROM php:8.2-fpm-alpine AS runtime

RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    curl \
    unzip \
    bash \
    mysql-client

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        dom \
        xml \
        fileinfo \
        opcache \
        intl

# Opcache: validate timestamps so git pull picks up changes without restart
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.revalidate_freq=0'; \
} > /usr/local/etc/php/conf.d/opcache.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]

# ======================
# Stage 3: Nginx – serves Vite assets + proxies PHP to app container
# Rebuild only when frontend (resources/) changes
# ======================
FROM nginx:1.25-alpine AS nginx

# Copy only the Vite-built assets (not the whole public dir)
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Copy static public assets that are in git
COPY public/favicon.ico public/robots.txt /var/www/html/public/

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80 443
