1. Error de Carga de autoload.php

Error: Fatal error: Failed opening required '/path/to/vendor/autoload.php'
Causa: La carpeta vendor no estaba creada porque Composer no había instalado las dependencias.
Solución:
Ejecuta composer install en la raíz del proyecto para generar la carpeta vendor y el archivo autoload.php.
Asegúrate de que la línea de inclusión en index.php apunte correctamente a vendor/autoload.php:
php
require __DIR__ . '/vendor/autoload.php';


2. Clase Database No Encontrada

Error: Fatal error: Class "App\Database\Database" not found
Causa: El archivo Database.php estaba en minúsculas (database.php), y los sistemas como Linux distinguen entre mayúsculas y minúsculas en los nombres de archivos.
Solución:
Renombra database.php a Database.php (con D mayúscula) para que coincida con el nombre de la clase.
Asegúrate de que el archivo está ubicado en src/Database/Database.php.


3. Error de Ruta en config.php

Error: Failed opening required '/path/to/config.php'
Causa: La ruta relativa en Database.php para cargar config.php no era correcta.
Solución:
Verifica que config.php esté en la carpeta config/ y que la línea en Database.php sea:
php
$config = require __DIR__ . '/../../config/config.php';


4. Error de Conexión: "could not find driver"

Error: Error en la conexión a la base de datos: could not find driver
Causa: Faltaba la extensión pdo_mysql en PHP.
Solución:
Instala la extensión:

bash
sudo apt install php-mysql
Reinicia el servidor web:

bash
sudo systemctl restart apache2
Verifica que pdo_mysql esté activo:

bash
php -m | grep pdo_mysql


5. Archivo de Vista No Encontrado (home.view.php)

Error: Failed opening required '/path/to/src/views/home.view.php'
Causa: PHP no pudo encontrar la vista especificada, probablemente porque el archivo no existía o la ruta de la constante VIEWS era incorrecta.
Solución:
Crea el archivo de vista home.view.php en la carpeta src/views/.
En index.php, asegúrate de que la constante VIEWS apunte a la carpeta correcta:

php
define('VIEWS', __DIR__ . '/src/views');
Consejos Generales para Depurar Errores en PHP
Verifica Rutas: En sistemas sensibles a mayúsculas (como Linux), asegúrate de que los nombres de archivos y rutas coincidan exactamente.
Composer Autoloading: Siempre ejecuta composer dump-autoload después de crear nuevas clases o cambiar rutas en composer.json.
Extensiones de PHP: Verifica que todas las extensiones necesarias estén instaladas, especialmente para trabajar con bases de datos (ej., php-mysql para MySQL/MariaDB).
Logs de Errores: Habilita display_errors en entornos de desarrollo y revisa los logs de PHP y del servidor web para información adicional sobre los errores.