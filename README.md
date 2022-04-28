# Proyecto_negocios_2022
Proyecto para negocios electronicos y desarrollo web, un recetario


## Notas de Configuración

### Configurar VirtualHost y Proxy

Agregar las siguientes líneas en el archivo de configuración de 
apache `httpd.conf` (para una máquina en especial usaremos 
`fxarch.proyecto_neg.site`[1^], donde, para este ejemplo,
nuestro entorno de desarrollo está ubicado en
`$HOME/public_html/proyecto_neg`[2^])

```apacheconf
<VirtualHost fxarch.proyecto_neg.site:80>
  ServerName fxarch.proyecto_neg.site

  ProxyRequests Off
  ProxyPass /proyecto_neg http://localhost/proyecto_neg
  ProxyPassReverse /proyecto_neg http://loacalhost/proyecto_neg
</VirtualHost> 
```

Agregar el mismo host en el archivo `/etc/hosts` 
(en windows es `C:Windows/System32/drivers/etc/hosts`)

```unixconfig
127.0.0.1	fxarch.proyecto_neg.site
```

Reiniciamos el servicio de apache e ingresamos a 
http://fxarch.proyecto_neg.site/

[1^]: https://linuxconfig.org/how-to-set-up-apache-webserver-proxy-in-front-of-apache-tomcat-on-red-hat-linux
[2^]: https://wiki.archlinux.org/title/Apache_HTTP_Server#User_directories