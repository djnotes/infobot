FROM ghcr.io/djnotes/madelineproto-container:main


COPY . /app


WORKDIR /app

RUN source ./set-env.sh
ENV API_ID "$API_ID"
ENV API_HASH "$API_HASH"
ENV BOT_TOKEN "$BOT_TOKEN"

RUN echo "Set values are $API_ID, $API_HASH, and $BOT_TOKEN"

RUN adduser -D cuser
USER cuser


CMD ["php", "bot.php"]



