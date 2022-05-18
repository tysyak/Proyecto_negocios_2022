# Configuración del servidor

* [Apache](#apache)
* [PHP](#php)
* [MariaDB o MySQL](#mariadb-o-mysql)

Para configurar una pila Windows Apache Php y MySQL/MariaDB se seleccionó el siguiente software:

+ [Apache Haus 2.4](https://www.apachehaus.com/cgi-bin/download.plx)
+ [PHP 8](https://windows.php.net/download#php-8.1)
+ [MariaDB 10.7 (ArchLinux)](https://mariadb.org/download/?t=mariadb&p=mariadb&r=10.6.7&os=windows&cpu=x86_64&pkg=msi&m=gigenet)
+ [MySQL (Windows)](https://dev.mysql.com/downloads/installer/)

El sistema se probó en Windows 10, Windows 11 y ArchLinux. Para instalaciónes
Linux se recomienda ver su documentación oficial, en caso de Arch su [Wiki
en ingles](https://wiki.archlinux.org) esta suficientemente documentada para la instalción para esta Stack.

Se considera que la maquina de instalación no haya tenido previamente una 
instancia de apache, si no, se recomenienda terminar el servicios Apache24 
desde el panel de Servicios (se puede buscar desde el panel de control) de 
windows.

Se usarán versiónes de 64bits, por lo tanto usaremos el directorio 
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
Powershell 7, tambien se puede usar CMD sin problema alguno.

Ejecutamos el siguiente comando para instalar el servidor

```powershell
httpd -k install
```

Si no devolvio ningun mensaje de error inciamos el servidor con el siguiente
comando

```powershell
httpd -k start
```

En caso de editar cualquier configuración de servicio, podemos reiniciarlo 
usando el comando:

```powershell
httpd -k restart
```

## PHP

Igual que apache, descargamos los binarios
https://windows.php.net/download#php-8.1, lo descomprimimos, cambiamos el 
nombre de la carpeta descompimida a `php` y cambiamos la dirección de la 
carpeta en `C:\Program Files\`. Agregamos `C:\Program Files\php` a la variable 
`PATH` del sistema (reiniciamos).

## MariaDB o MySQL

Para windows usaremos `MySQL`, aunque tambien podemos usar `MariaDB` sin
problema alguno.

En la interfaz del instalador seleccionamos el paquete *Server Only*, Dejamos 
las configuración por defecto con una contraseña para desarrollo y para las 
demas opciones damos continuar.

Se nos instalará un programa para ingresar a la base de datos `MySQL 8.0 Command Line Client` con ella crearemos nuestros usuarios y administraremos sus permisos, para el resto de tareas como la creacion de tablas, bien podemos seguir la línea de comandos ó una herramienta como [DataGrip](https://www.jetbrains.com/datagrip/) o [Dbeaver](https://dbeaver.io).