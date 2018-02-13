FROM mysql:5.7

MAINTAINER Massimiliano Arione <garakkio@gmail.com>

RUN { \
      echo '[mysqld]'; \
      echo 'character-set-server=utf8mb4'; \
      echo 'collation-server=utf8mb4_unicode_ci'; \
      echo '[client]'; \
      echo 'default-character-set=utf8mb4'; \
    } > /etc/mysql/conf.d/charset.cnf