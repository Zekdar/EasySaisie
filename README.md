EasySaisie
========================

Welcome to the EasySaisie - It's a webapp that allows universities to note their students.

1) Installing EasySaisie
----------------------------------
EasySaisie is built on Symfony2 framework, which works with composer to manage vendors.

Run theses command lines to updates your vendors 

    php composer.phar self-update
    php composer.phar update

Install the database

    php app/console doctrine:schema:update --force

Install the assets 
  
    php app/console asset:install web
	
2) Use GetStarted function to create necessary elements 
----------------------------------

The Get Started function will guide you in creating the necessary elements in order to use the application correctly

First, you need to create a formation and then a promotion.

After that, you need to add a container (you can add many containers).

Then, you need to create some subjects, teaching units and affect them to your promotion.

To finish, you have to create students and affect them to your promotion.

Once this is done, you have the miminum to start using the application.

3) Create An User
----------------------------------
Using the FOSUserBundle
Create the first Administrateur
	
	php app/console fos:user:create

Promote an user as Admin

	php app/console fos:user:promote  (enter 'ROLE_ADMIN' as role)

