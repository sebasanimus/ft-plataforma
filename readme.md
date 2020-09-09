# Plataforma de Proyectos FONTAGRO
---
El objetivo es disponer de un​ nuevo sistema integrado con toda la información vinculada  al nudo de los contenidos, que son precisamente los proyectos. 

La plataforma es​ escalable​, al estar todo almacenado en bases de datos relacionadas, ​no hay información duplicada, se evitan errores de carga y se​ optimizan los tiempos​ de búsqueda de información y de actualización de datos. 

Bajo estas premisas, se cuenta con una plataforma apta para administrar los proyectos y las propuestas del ecosistema de FONTAGRO.

### Guía de instalación
---
Requerimientos para la instalación:

PHP 7.2 o superior

MySQL 5.7.31 o superior

Dependencias (comandos para Ubuntu con servidor apache2): 

    sudo apt-get install php-curl

    sudo apt-get install php-imagick

    sudo apt-get install php-gd

    sudo apt-get install php-mbstring

    sudo apt-get install php-zip

Luego de instalar todas las dependencias, copiar el código en el directorio correspondiente. 

Crear una base de datos nueva y crear las tablas a partir del archivo base-datos.sql

Agregar los datos de configuracion del sitio en application/config/config.php y los datos de acceso a la base de datos en application/config/database.php

Se deben dar permisos de escritura al servidor web a las carpetas que se encuentran dentro de la carpeta uploads.

Si se instala en un subdirectorio, se deben modificar las lineas 8 y 18 del archivo .htaccess

Ir a la direccion: url_de_instalacion/admin y loguearse con el usuario "admin@admin.com" y password "admin". Inmediatamente cambiar los datos de acceso. 

### Guía de usuario
---

### Autores
---
Desarrollado por Coopetariva Animus LTDA

### Licencia para el código de la herramienta
---
Por favor vea la licencia MIT en https://github.com/animus-coop/fontagro-plataforma/blob/master/license.txt

### Licencia para la documentación de la herramienta
---
Licencia CC0 http://creativecommons.org/publicdomain/zero/1.0/

## Limitación de responsabilidades
---
Animus Coop LTDA. no será responsable, bajo circunstancia alguna, de daño ni indemnización, moral o patrimonial; directo o indirecto; accesorio o especial; o por vía de consecuencia, previsto o imprevisto, que pudiese surgir:

i. Bajo cualquier teoría de responsabilidad, ya sea por contrato, infracción de derechos de propiedad intelectual, negligencia o bajo cualquier otra teoría; y/o

ii. A raíz del uso de la Herramienta Digital, incluyendo, pero sin limitación de potenciales defectos en la Herramienta Digital, o la pérdida o inexactitud de los datos de cualquier tipo. Lo anterior incluye los gastos o daños asociados a fallas de comunicación y/o fallas de funcionamiento de computadoras, vinculados con la utilización de la Herramienta Digital.
