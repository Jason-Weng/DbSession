DbSession
=========

Two old school PHP classes to accomplish two thinks. 
1 - Storing the session in a mysql database table. 
2 - Being able to share old legacy sessions with Laravel 4 sessions.

Credits for the original author Philip Brown and his article:
http://culttt.com/2013/02/04/how-to-save-php-sessions-to-a-database/

What I did is add a little bit dependency injection and adjust the columns names of the database table.
Feel free to use namespacing. The legacy code I'm working on sadly has no namespacing.

I've included an example.php script.