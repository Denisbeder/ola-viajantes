FROM certbot/certbot:latest

#COPY run-certbot.sh /root/certbot/run-certbot.sh

CMD certonly dry-run --webroot --webroot-path={$WEBROOT_PATH}/letsencrypt \
    --email duek.digital@gmail.com --agree-tos --no-eff-email \
    -d olaviajantes.com.br \
    -d www.olaviajantes.com.br

ARG FILE=/etc/resolv.conf

RUN set -eux; \ 
    if [[ -f "$FILE" ]]; then \
        echo "$FILE exists." \
    else  \
        echo "$FILE does not exist." \
    fi
#ENTRYPOINT bash -c "bash /root/certbot/run-certbot.sh && sleep infinity"
