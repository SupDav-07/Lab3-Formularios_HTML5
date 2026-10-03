# Laboratorio # 3: Registro de Aspirantes

📅 Fecha: [DD/MM/AAAA]

## 📄 Contenido del Repositorio

Este repositorio contiene el desarrollo del Laboratorio #3, un sistema de registro de aspirantes que implementa un formulario HTML5 maquetado con Bootstrap, procesamiento y validación de datos en PHP (incluyendo carga segura de archivos), componentes modulares reutilizables mediante `include`, y buenas prácticas de seguridad tanto a nivel de carpeta como de código.

## 🛠️ Tecnologías Utilizadas

- **Lenguaje de marcado:** HTML5
- **Framework CSS:** Bootstrap v5.3.8 (vía CDN)
- **Lenguaje de backend:** PHP
- **Servidor local:** WampServer (Apache)
- **Editor:** Visual Studio Code
- **Control de versiones:** Git / GitHub

## 🖥️ Capturas de Pantalla y Problemas

### Interfaz Principal

*(Aquí se incluye la imagen de la salida de cada problema)*

- **Formulario de Registro (`index.php`):** formulario con los campos nombre, apellido, identificación, fecha de nacimiento, sexo y fotografía (`enctype="multipart/form-data"`), maquetado con Bootstrap y componentes semánticos de HTML5.

  ![Formulario de Registro](ruta/a/tu/captura-formulario.png)

- **Procesamiento de Datos (`procesar.php`):** valida los campos requeridos, sanea el texto con `htmlspecialchars()` y `strip_tags()`, normaliza nombre y apellido a formato tipo título, calcula la edad a partir de la fecha de nacimiento (validando el rango de 18 a 70 años), valida la extensión de la imagen y la guarda de forma segura en `uploaded_files/`.

  ![Resultado del Registro](ruta/a/tu/captura-resultado.png)

- **Navegación y Breadcrumb (`includes/header.php`):** barra de navegación y migas de pan dinámicas, que cambian según la página actual usando `basename($_SERVER['PHP_SELF'])`.

  ![Navegación](ruta/a/tu/captura-navegacion.png)

- **Seguridad de Carpetas:** la carpeta `uploaded_files/` está protegida con un archivo `.htaccess` que deshabilita el listado de directorio (`Options -Indexes`) y bloquea la ejecución de scripts subidos. Los archivos `header.php` y `footer.php` están protegidos contra acceso directo mediante una constante (`INCLUDED_FROM_APP`) que solo se define en `index.php` y `procesar.php`.

  ![Seguridad](ruta/a/tu/captura-seguridad.png)

## 📁 Estructura de Carpetas o Directorios

```
TallerAspirantes/
├── includes/
│   ├── header.php          # <header>, navbar y breadcrumb dinámico (protegido)
│   └── footer.php          # <footer> con año dinámico (protegido)
├── uploaded_files/
│   ├── .htaccess            # Bloquea listado de carpeta y ejecución de scripts
│   └── .gitkeep               # Mantiene la carpeta vacía en el repositorio
├── index.php                    # Formulario visual de registro
├── procesar.php                   # Backend: valida, procesa y guarda el registro
└── README.md                        # Documentación del proyecto
```

## ▶️ Instrucciones de Ejecución / Uso

1. Clonar el repositorio.
2. Copiar la carpeta `TallerAspirantes` dentro de `C:\wamp64\www\`.
3. Iniciar WampServer y verificar que Apache esté activo (ícono en verde).
4. Abrir el navegador y acceder a:
   - `http://localhost/TallerAspirantes/index.php`
5. Completar el formulario y presionar "Registrar Aspirante" para ver el procesamiento en `procesar.php`.

## 🔒 Aspectos de Seguridad Implementados

- **Saneamiento de entradas:** `htmlspecialchars()` y `strip_tags()` para prevenir XSS.
- **Validación de archivos:** solo se permiten imágenes con extensión jpg, jpeg, png, gif o webp.
- **Nombres de archivo únicos:** se usa `md5(time() . nombre)` para evitar colisiones o sobrescritura de archivos.
- **Protección de carpeta de subida:** `.htaccess` con `Options -Indexes` y bloqueo de ejecución de scripts.
- **Protección de componentes internos:** `header.php` y `footer.php` verifican la constante `INCLUDED_FROM_APP` antes de ejecutarse, bloqueando el acceso directo por URL.

## 👤 Autor y Contexto

- **Nombre:** René
- **Institución:** Universidad Tecnológica de Panamá (UTP) - Facultad de Ingeniería en Sistemas, Campus Víctor Levy Sasso
- **Fecha de Realización:** [DD/MM/AAAA]

## 🔗 Referencias

- Laboratorio #3 - Módulo II: Diseño Web con HTML5 y CSS3 / Módulo III: Programación de Aplicaciones Web
- Documentación oficial de PHP: https://www.php.net/manual/es/
- Documentación oficial de Bootstrap: https://getbootstrap.com/docs/5.3/
