# Proyecto negocios 2022
Proyecto para negocios electrónicos y desarrollo web, un recetario


## Notas de Configuración

### Módulos

Regularmente con los módulos por defecto es más que suficientes
(si se usa una instalación como Appserver o XAMPP), sin embargo
nos basaremos en la instalación PHP de la Wiki de arch linux: 
https://wiki.archlinux.org/title/Apache_HTTP_Server#PHP

Otro módulo importante para poder implementar un Router es el módulo de 
 `LoadModule rewrite_module modules/mod_rewrite.so`


### Configurar VirtualHost y Proxy

Agregar las siguientes líneas en el archivo de configuración de 
apache `httpd.conf` (para una máquina en especial usaremos 
`fxarch.proyecto_neg.site`[^1], donde, para este ejemplo,
nuestro entorno de desarrollo está ubicado en
`$HOME/public_html/proyecto_neg`[^2])

```apacheconf
<VirtualHost fxarch.proyecto_neg.site:80>
  DocumentRoot /home/tysyak/public_html/proyecto_neg  
 
  <Directory  /home/tysyak/public_html/proyecto_neg>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
    Order allow,deny
    allow from all
  </Directory>
  
  ServerName fxarch.proyecto_neg.site
</VirtualHost>
```

Agregar el mismo host en el archivo `/etc/hosts` 
(en windows es `C:Windows/System32/drivers/etc/hosts`)

```unixconfig
127.0.0.1	fxarch.proyecto_neg.site
```

Reiniciamos el servicio de apache e ingresamos[^3] a 
http://fxarch.proyecto_neg.site/

[^1]: https://linuxconfig.org/how-to-set-up-apache-webserver-proxy-in-front-of-apache-tomcat-on-red-hat-linux
[^2]: https://wiki.archlinux.org/title/Apache_HTTP_Server#User_directories
[^3]: `fxarch` es el Hostname de la máquina, se puede cambiar por cualquier valor.