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
- `php bin/console kodmit:userbundle:init` Auto-configure all config files
- `php bin/console kodmit:userbundle:create-user` Create user and follow the steps
  
  
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

## Auto installation

After the `composer require kodmit/userbundle`, you have only 3 steps to have your user area working.

#### Step 1 :
Register the service in your `services.yaml` file.

``` yaml
Kodmit\UserBundle\:
    resource: '../vendor/kodmit/userbundle/*'
```

#### Step 2 :
Launch this command : `php bin/console kodmit:userbundle:init`

#### Step 3 (Not really a step) :
Update your database schema, you can access the bundles pages on `/login`, `/register`, `/logout`, more pages are coming soon.

## Manual installation
  
First you need to update the `security.yaml` with this config :
  
``` yaml
security:
    encoders:
        Kodmit\UserBundle\Entity\User:
            algorithm: argon2i

    providers:
        app_user_provider:
            entity:
                class: Kodmit\UserBundle\Entity\User
                property: username
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            remember_me:
                secret:   '%kernel.secret%'
                lifetime: 604800 # 1 week in seconds
                path:     /
            logout:
                path:   kodmit_userbundle_logout
            anonymous: true
            guard:
                authenticators:
                - Kodmit\UserBundle\Security\KodmitUserBundleAuthenticator
            form_login: true

    access_control:
    - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/register, roles: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/, roles: ROLE_USER }

```

#### routes.yaml

``` yaml
kodmit_userbundle:
  resource: '@KodmitUserBundle/Resources/config/routes.yaml'
```

#### twig.yaml

``` yaml
twig:
    paths:
        '%kernel.project_dir%/src/Kodmit/UserBundle/Resources/views': KodmitUserBundle
```
  
#### service.yaml

``` yaml
Kodmit\UserBundle\:
    resource: '../vendor/kodmit/userbundle/*'
```

Don't forget to update your database schema.
