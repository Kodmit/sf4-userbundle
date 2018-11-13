# Documentation
  
### Installation
  
First you need to update the `security.yaml` with this config :
  
``` yaml
security:
    encoders:
        Kodmit\UserBundle\Entity\User:
            algorithm: argon2i
    providers:
        # used to reload user from session & other features (e.g. switch_user)
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
                    - Kodmit\UserBundle\Security\KodmitUserBundleAuthentificatorAuthenticator
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
  
    
### How to use  
#### Create user
`php bin/console kodmit:userbundle:create-user`  
<i>And follow the steps</i>