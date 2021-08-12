# PHP-Reverse-Proxy-Cache
A Reverse Proxy' Cache PHP script with a file-based cache
## How To Use PHP Reverse Proxy Cache
1. Add `Cache.php` In The Fist Line Of The Program
2. if You are using wordpress add in `wp-config.php`
3. If You Are Not Using Wordpress Remove This  `&& (strpos($actual_link, 'wp-cron') !== true)` On Cache.php On 2nd Line
4. Create A Folder Named File
5. Create A hook.php
6. Replace `YOUR CACHE SERVER WEBHOOK URL` By Your Cache Server Hook URL in `Cache.php`
