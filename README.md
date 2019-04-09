# zenoframework

Framework for creating, reading, updating and deleting users

Uses the entity mapper design pattern.


# Structure #
 -> example_app folder 

 example_app/Controllers/ folder:
  the particular Controller(s) which derive from the ZenoFramework ones
 example_app/db : db schema migration
 example_app/Models => the users model

example_app folder uses the ZenoFramework framework which is found locally (for demo purposes) under packages/zenoframework, via composer local path. 

This was done for convenience and demo purposes. Also, it clearly separates the framework from the client app.

 -> packages/zenoframework

  The actual generic framework. It can support any type of model, any type of DB :)
  It has generic controllers, models, a router, a MySQL adapter for starters.


# Purpose #
packages/zenoframework is actually a generic REST framework, it can handle object model deserialization,
different DB schema, even non-DB (flat files etc)

The particularization is inside example_app, inside the Controllers, Models folder respectively.

The client programmer doesn't have to write a lot of code to achieve the particularization.

# How to use #
Used PHP7.1

Please see example_usage.txt and example_usage_users.txt after you installed the packages from example_app via php composer, so basically :

cd example_app
composer install (Assuming you have it globally)

Run the phinx db migration 

phinx migrate -e development (make sure phinx.yml is correct)

Also, inside example_app/index.php lines 14 and 15 you have to modify the DB credentials.

