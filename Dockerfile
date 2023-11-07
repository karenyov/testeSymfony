# 1. Use a imagem base
FROM php:8.2-cli

# 2. Instale pacotes de desenvolvimento e limpe o cache do apt.
# Este comando atualiza o sistema e instala várias dependências e ferramentas necessárias.
RUN apt-get update && apt-get install -y \
    curl \
    g++ \
    git \
    libbz2-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libpng-dev \
    libreadline-dev \
    sudo \
    unzip \
    zip \
    nodejs \
    curl \
    libxml2-dev \
    libmcrypt-dev \
    freetds-bin \
    freetds-dev \
    freetds-common \
    libct4 \
    libsybdb5 \
    tdsodbc \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libc-client-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# 3. Configure o Symfony CLI para instalação posterior.
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli -y

# 4. Configure o Git globalmente com nome e email.
RUN git config --global user.name "ilogix-alpha"
RUN git config --global user.email "ilogix@ilogix.com.br"

# 5. # Defina o diretório de trabalho para /app e instale as dependências do zip.
WORKDIR /app
RUN apt-get install zip libzip-dev -y
RUN docker-php-ext-configure zip

# 6. Configure a imagem PHP base com extensões necessárias.
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN ln -s /usr/lib/x86_64-linux-gnu/libsybdb.so /usr/lib/
RUN docker-php-ext-install \
    bcmath \
    bz2 \
    calendar \
    iconv \
    intl \
    mbstring \
    opcache \
    pdo_mysql \
    zip \
    gd \
    mysqli \
    pdo \
    sockets \
    soap \
    pdo_dblib \
    pcntl \
    gettext	\
    exif \ 
    dba \
    shmop

# 7. Copie o Composer para a imagem e instale o Symfony Runtime.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# 9. Defina um usuário com o mesmo UID/GID do host.
ARG uid

# 10. Copie o script de inicialização e torne-o executável.
COPY start_server.sh /usr/local/bin/start_server.sh
RUN chmod +x /usr/local/bin/start_server.sh

# 11. Defina o comando padrão para executar o script de inicialização.
CMD ["/usr/local/bin/start_server.sh"]
