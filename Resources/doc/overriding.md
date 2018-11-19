# Overriding the bundle

## Automatically 

After the bundle installed and configured, enter this command in order to generate all the files you need to override the bundle.
  
`php bin/console kodmit:userbundle:override`


### Views
Now you will have in your `templates/bundles/KodmitUserBundle` all the twig files to override the bundle views.

<i>If your changes are not effective, clear the Symfony cache.</i>

<br>

## Manually 

If for some reasons the automatic way doesn't work, you can do it manually.

### Views
Create the folder `templates/bundles/KodmitUserBundle` and update the `config/twig.yaml` file with this config :

```yaml
twig:
    paths: 
        '%kernel.project_dir%/templates/bundles/KodmitUserBundle': KodmitUserBundle, 
        '%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views': KodmitUserBundle
```

You can now override the bundle templates.

<i>If your changes are not effective, clear the Symfony cache.</i>

