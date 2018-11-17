# Symfony 4 UserBundle
Symfony 4 userbundle with command lines

## How to install ?
`composer require kodmit/userbundle`
  
 
Packagist : https://packagist.org/packages/kodmit/userbundle  
  
  
#### This bundle allow you to
- Login
- Register
- Logout
- Change your password
- Edit your profile

#### Command lines
- `php bin/console kodmit:userbundle:init` Auto-configure all config files.
- `php bin/console kodmit:userbundle:override` Auto-generate template files and extended User entity.
- `php bin/console kodmit:userbundle:create-user` Create a new user.
  
  
### TODO
#### In command lines 
- Update user
- Promote user
- Demote user 
- Delete user
- Change user password
  
#### In interface 
- Delete account
- Add picture profile
- Customizable options

## Auto installation (2 steps)

After the `composer require kodmit/userbundle`, you have only 3 steps to have your user area working.

#### Step 1 :
Register the service in your `services.yaml` file.

``` yaml
Kodmit\UserBundle\:
    resource: '../vendor/kodmit/userbundle/*'
    tags: ['controller.service_arguments']
```

#### Step 2 :
Launch this command : `php bin/console kodmit:userbundle:init`

#### Step 3 (Not really a step) :
Update your database schema, you can now access the bundle via `/login`, `/register`.


### Documentation

The source of the documentation is stored in the `Resources/doc/` folder in this bundle.

- <a href="https://github.com/Kodmit/sf4-userbundle/tree/master/Resources/doc/manual-installation.md">Manual installation with config files</a>
- <a href="https://github.com/Kodmit/sf4-userbundle/tree/master/Resources/doc/overriding.md">Overriding templates and extend User entity</a>
