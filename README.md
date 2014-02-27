EasySaisie
========================

Welcome to the EasySaisie - It's a webapp that allows universities to note their students.

1) Installing EasySaisie
----------------------------------
EasySaisie is built on Symfony2 framework, whick works with composer to manage vendors.

Run theses command lines to updates your vendors 

  php composer.phar self-update
  php composer.phar update

Install the database
  php app/console doctrine:schema:update --force

Install the assets 
  
  php app/console asset:install web

