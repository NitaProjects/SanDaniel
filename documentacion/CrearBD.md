# Tutorial: Cómo Crear la Base de Datos para el Proyecto

## Paso 1: Instalar MariaDB en Debian

1. Actualiza el sistema:
   ```bash
   sudo apt update
   sudo apt upgrade
Instala MariaDB:

bash
Copiar código
sudo apt install mariadb-server
Inicia y habilita el servicio de MariaDB:

bash
Copiar código
sudo systemctl start mariadb
sudo systemctl enable mariadb
Paso 2: Configurar la Seguridad de MariaDB
Ejecuta el siguiente comando para asegurar la instalación:

bash
Copiar código
sudo mysql_secure_installation
Sigue las instrucciones:

Configura una contraseña para el usuario root.
Elimina usuarios anónimos.
Deshabilita el acceso remoto para root.
Elimina la base de datos de prueba.
Recarga las tablas de privilegios.
Paso 3: Crear una Conexión en DBeaver
Abre DBeaver.

Ve a Database > New Database Connection.

Selecciona MariaDB y completa la conexión:

Host: localhost
Port: 3306
Username: root
Password: (la contraseña configurada)
Haz clic en Test Connection para verificar, y luego en Finish.

Paso 4: Crear la Base de Datos en DBeaver
En DBeaver, haz clic derecho en la conexión de MariaDB.
Selecciona Create > Database.
Nombra la base de datos, por ejemplo, escuela, y confirma.
Paso 5: Crear las Tablas
Copia y pega el siguiente código SQL en el SQL Editor de DBeaver:

sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_type ENUM('student', 'teacher') NOT NULL
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    dni VARCHAR(20) UNIQUE NOT NULL,
    enrollment_year YEAR NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    department_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    degree_id INT,
    FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE SET NULL
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

CREATE TABLE degrees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration_years INT NOT NULL
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    enrollment_date DATE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    exam_date DATE NOT NULL,
    description TEXT,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);


-- Agrega el resto de las tablas aquí
Verificar las Tablas
En DBeaver, expande la base de datos escuela.
Asegúrate de que todas las tablas (users, students, teachers, etc.) estén presentes.
¡Listo! Ahora tienes la base de datos configurada. Puedes proceder a la conexión desde PHP para que tu aplicación pueda interactuar con ella.

markdown
Copiar código

### Guardar y Usar
Guarda este archivo como `crear_base_de_datos.md` en la carpeta de documentación. Markdown facilitará la comprensión y edición de los pasos. 

Si necesitas ayuda con algún otro tutorial o paso, ¡dímelo!