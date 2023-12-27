Project installation steps.

1 - `composer install`

1 - Go to the core/DatabaseSingleton.php file and add connection credentials there

2 - Run sql/create_database.sql in your postgres terminal 

3 - `php migrations/create_main_tables.php`