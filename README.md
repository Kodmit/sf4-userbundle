# Symfony 4 UserBundle
Symfony 4 userbundle with command lines

## How to install ?
`composer require kodmit/userbundle`
  
 
Packagist : https://packagist.org/packages/kodmit/userbundle  

## Auto installation (2 steps)

After the `composer require kodmit/userbundle`, you have only 2 steps to have your user area working.

#### Step 1 :
Launch this command : `php bin/console kod:userbundle:init`

#### Step 2 :
Update your database schema, you can now access the bundle via `/login`, `/register` and add fields to your user in the User entity generated in `src/Entity/User.php`.
  
## Features
  
#### This bundle allow you to
- Login
- Register
- Logout
- Change your password
- Edit your profile

#### Command lines
- `php bin/console kod:userbundle:init` Auto-configure all config files.
- `php bin/console kod:userbundle:override` Auto-generate templates files.
- `php bin/console kod:user:create` Create a new user.
- `php bin/console kod:user:reset <username>` Reset the user password.
  
  
## TODO
#### In command lines 
- Promote user
- Demote user 
- Delete user
  
#### In interface 
- Delete account
- Add picture profile
- Customizable options

## Documentation

The source of the documentation is stored in the `Resources/doc/` folder in this bundle.

- <a href="https://github.com/Kodmit/sf4-userbundle/tree/master/Resources/doc/manual-installation.md">Manual installation with config files</a>
- <a href="https://github.com/Kodmit/sf4-userbundle/tree/master/Resources/doc/overriding.md">Overriding templates and extend User entity</a>

If some errors occurs during the schema update, change `utf8_mb4` to `utf8` in `doctrine.yaml`.
