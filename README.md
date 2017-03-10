This is a very basic and simple implementation of Real Time Notification using Socket, Node and PHP. However this does not implement Push notification so the notification can only be served to the active client. 

##Requirements
PHP
Apache/nGinx and Node

#Installation
- Just use `git clone` or download it and place it into your web accessible directory. 
- Open VegFru_Dropdown_Notification/class/Database.class.php and set the default host, username, password and db name.
- Locate http://localhost/VegFru_Dropdown_Notification/class/install.php
Now a `notification` table has been created in the database.
Now just install node dependencies.

```console
    npm install
    
    npm run dev
