FROM ghcr.io/djnotes/madelineproto-container:main


COPY . /app


WORKDIR /app



RUN adduser -D cuser
USER cuser


CMD ["php", "bot.php"]



