## Podcast parser command

"php artisan parse:podcast-data [RSS URL]"

## Note

The project takes advantage of job queues to efficiently parse and store podcast data in the background. So the necessary configurations have to be done. Reference = https://laravel.com/docs/8.x/queues#introduction
