# Configuración del servidor

* [Apache](#apache)
* [PHP](#php)
* [MariaDB o MySQL](#mariadb-o-mysql)

Para configurar una pila Windows Apache Php y MySQL/MariaDB se seleccionó el siguiente software:

+ [Apache Haus 2.4](https://www.apachehaus.com/cgi-bin/download.plx)
+ [PHP 8](https://windows.php.net/download#php-8.1)
+ [MariaDB 10.7 (ArchLinux)](https://mariadb.org/download/?t=mariadb&p=mariadb&r=10.6.7&os=windows&cpu=x86_64&pkg=msi&m=gigenet)
+ [MySQL (Windows)](https://dev.mysql.com/downloads/installer/)

El sistema se probó en Windows 10, Windows 11 y ArchLinux. Para instalaciones
Linux se recomienda ver su documentación oficial, en caso de Arch su [Wiki
en ingles](https://wiki.archlinux.org) esta suficientemente documentada para la instalación para esta Stack.

Se considera que la maquina de instalación no haya tenido previamente una 
instancia de apache, si no, se recomienda terminar el servicios Apache24 
desde el panel de Servicios (se puede buscar desde el panel de control) de 
windows.

Se usarán versiones de 64bits, por lo tanto usaremos el directorio 
`C:\Program Files` para instalar el software, en caso de usar 32bits se usará 
`C:\Program Files (x86)`,

## Apache

Para su instalación descargamos el archivo de las ventanas de descargas  
de https://www.apachehaus.com/cgi-bin/download.plx, extraemos los archivos
y movemos la carpeta `Apache24` en `C:\Program Files\` 
(`C:\Program Files (x86)` si descargamos su versión de 32bits)

Con un editor de texto con **permisos administrativos** abrimos el archivo 
de configuración de apache `C:\Program Files\Apache24\conf\httpd.conf` y 
modificamos la linea 39 y cambiamos el valor  

```apacheconf
Define SRVROOT "/Apache24"
```

Por 

```apacheconf
Define SRVROOT "C:/Program Files/Apache24"
```

Agremamos la carpeta `C:\Program Files\Apache24\bin` a la variable `PATH` del 
sistema (reiniciamos).

Abrimos una terminal con permisos administrativos, en este caso usaremos 
Powershell 7, también se puede usar CMD sin problema alguno.

Ejecutamos el siguiente comando para instalar el servidor

```powershell
httpd -k install
```

Si no devolvió ningún mensaje de error iniciamos el servidor con el siguiente
comando

```powershell
httpd -k start
```

En caso de editar cualquier configuración de servicio, podemos reiniciarlo 
usando el comando:

```powershell
httpd -k restart
```

### VirtualHosts

Para usar un host virtual, por ejemplo `C:\Users\www\Proyecto`, debemos cargar unos módulos

```apacheconf
LoadModule vhost_alias_module modules/mod_vhost_alias.so
```

También descomentamos 

```apacheconf
Include conf/extra/httpd-vhosts.conf
```

y agregamos nuestra raíz del proyecto (o bien la ubicación de `index.php` del proyecto) a la configuración
del host virtual en `C:\Program Files\Apache24\conf\extra\httpd-vhosts.conf`:

```àpacheconf
<VirtualHost localhost.proyecto.site:80>
  DocumentRoot "C:\Users\www\Proyecto"
 
  <Directory  "C:\Users\www\Proyecto">
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
    Order allow,deny
    Allow from all
    Require all granted
  </Directory>
  
  ServerName localhost.proyecto.site
</VirtualHost>
```

Donde `localhost.proyecto.site` lo agregamos en el archivo `C:\Windows\System32\drivers\etc\hosts`, por ejemplo:

```unixconfig
# ...
# localhost name resolution is handled within DNS itself.
127.0.0.1       localhost localhost.proyecto.site
# ...
```

Volvemos a `httpd.conf` y descomentamos:

```apacheconf
LoadModule access_compat_module modules/mod_access_compat.so
```

Y, por si un proyecto requiere la configuración mediante `.htaccess` activamos el siguiente módulo:

```apacheconf
LoadModule rewrite_module modules/mod_rewrite.so
```

Reiniciamos el servicio de Apache y probamos

## PHP

Igual que apache, descargamos los binarios
https://windows.php.net/download#php-8.1, lo descomprimimos, cambiamos el 
nombre de la carpeta descomprimida a `php` y cambiamos la dirección de la 
carpeta en `C:\Program Files\`. Agregamos `C:\Program Files\php` a la variable 
`PATH` del sistema (reiniciamos).

En `C:\Program Files\php` renombramos `php.ini-development` a `php.ini`.

En el archivo de configuración de apache `C:\Program Files\Apache24\conf\httpf.conf`, 
al final de donde cargamos los módulos o al final del archivo agregamos las instalación
de PHP.

```apacheconf
LoadModule php_module "C:/Program Files/php/php8apache2_4.dll"

PHPIniDir "C:/Program Files/php"

AddType application/x-httpd-php .php .html .htm
```

Reiniciamos servicio de Apache

Como administrador creamos un archivo en `C:\Program Files\Apache24\htdocs\phpinfo.php`
con el siguiente contenido:

```php
<?php
phpinfo();
```

En un navegador abrimos http://localhost/phpinfo.php y veremos toda la configuración de nuestro PHP

## MariaDB o MySQL

Para windows usaremos `MySQL`, aunque también podemos usar `MariaDB` sin
problema alguno.

En la interfaz del instalador seleccionamos el paquete *Server Only*, Dejamos 
las configuración por defecto con una contraseña para desarrollo y para las 
demás opciones damos continuar.

Se nos instalará un programa para ingresar a la base de datos 
`MySQL 8.0 Command Line Client` con ella crearemos nuestros usuarios y 
administraremos sus permisos, para el resto de tareas como la creación de 
tablas, bien podemos seguir la línea de comandos ó una herramienta 
como [DataGrip](https://www.jetbrains.com/datagrip/) o [Dbeaver](https://dbeaver.io).