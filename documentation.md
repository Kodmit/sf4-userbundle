# Documentation
  
### Installation
  
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
