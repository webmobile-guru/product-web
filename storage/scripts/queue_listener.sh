process=`pgrep -f "php /home/exchange/doch.exchange/artisan queue:work --tries=3"`
if [ -z "$process" ]
then
    nohup php /home/exchange/doch.exchange/artisan queue:work --tries=3 &>> /home/exchange/doch.exchange/storage/logs/queue.log &
fi
