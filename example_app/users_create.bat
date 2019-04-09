curl -X POST -d "email='n2@n2.com'&first_name='fname1'&last_name='lname1'&password='p1'" http://localhost:8081/example_app/index.php?users/create
curl -X DELETE http://localhost:8081/example_app/index.php?users/1
curl -X PUT -d "email='n3@n3.com'&first_name='gicu'&last_name='lname1'&password='p1'" http://localhost:8081/example_app/index.php?users/2/edit
