UPGRADE FROM 1.x to 2.0
=======================

### SonataAdmin Support

 * The Admin for `Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent`
   was moved into `symfony-cmf/sonata-admin-integration-bundle`. With the move, the admin service names also changed.
   If you are using the admin, you need to adjust your configuration, i.e. in the sonata dashboard::
   
   Before:
   
   ```yaml
        # app/config/config.yml
        sonata_admin:
            dashboard:
               groups:
                   content:
                       label: Content
                       icon: '<i class="fa fa-file-text-o"></i>'
                       items:
                           - cmf_sonata_admin_integration.content.admin
   ```

    After:
       
   ```yaml
        # app/config/config.yml
        sonata_admin:
           dashboard:
               groups:
                   content:
                       label: Content
                       icon: '<i class="fa fa-file-text-o"></i>'
                       items:
                           - cmf_sonata_admin_integration.content.admin
   ```
