FROM php:8.1-apache

# Habilita o mod_rewrite do Apache (opcional, útil para alguns frameworks)
RUN a2enmod rewrite

# Copia todos os arquivos para o diretório público do Apache
COPY . /var/www/html/

# Define permissões para o Apache acessar os arquivos (opcional)
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta padrão do Apache
EXPOSE 80
