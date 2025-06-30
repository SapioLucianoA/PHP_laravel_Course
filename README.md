# PHP_LARAVEL_course

📄 Documentación de la API - Sistema de Cursos y Evaluaciones
Bienvenido/a al repositorio del Sistema de Gestión Educativa, una API RESTful desarrollada con Laravel que permite administrar cursos, usuarios, inscripciones y evaluaciones.

🚀 Características Principales
✔ Autenticación con Sanctum (Tokens JWT)
✔ Roles de usuario (Admin/Student)
✔ CRUD completo de Cursos y Categorías
✔ Inscripciones y Evaluaciones
✔ Filtrados, paginación y relaciones

🔌 Configuración Rápida
Requisitos
PHP 8.1+

Laravel 10+

MySQL 8.0+

bash----------------------------------------------------------------
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
composer install
cp .env.example .env
php artisan migrate --seed
---------------------------------------------------------------------
## 📡 Endpoints Clave

### 🔓 Rutas Públicas
| Método | Endpoint                     | Descripción                          |
|--------|------------------------------|--------------------------------------|
| POST   | `/api/login`                 | Autenticación de usuario             |
| POST   | `/api/user`                  | Registrar nuevo usuario              |
| GET    | `/api/category/{id}/courses` | Cursos por categoría                 |

### 🔐 Rutas Protegidas (requieren auth)
#### 👤 Usuarios
| Método | Endpoint                     | Descripción                          |
|--------|------------------------------|--------------------------------------|
| GET    | `/api/profile`               | Perfil del usuario logueado          |
| POST   | `/api/logout`                | Cerrar sesión                        |
| GET    | `/api/user/{id}`             | Detalles de usuario                  |
| PUT    | `/api/user/{id}`             | Actualizar usuario                   |
| GET    | `/api/users`                 | Listar todos los usuarios            |
| GET    | `/api/user/{id}/evaluations` | Evaluaciones de un usuario           |
| GET    | `/api/user/{id}/courses`     | Cursos de un usuario                 |

#### 📚 Cursos & Categorías
| Método | Endpoint              | Descripción                          |
|--------|-----------------------|--------------------------------------|
| GET    | `/api/courses`        | Listar cursos (paginados)            |
| GET    | `/api/course/{id}`    | Detalles de un curso                 |
| GET    | `/api/categories`     | Listar categorías                    |
| GET    | `/api/category/{id}`  | Detalles de una categoría            |

#### 🎓 Inscripciones & Evaluaciones
| Método | Endpoint               | Descripción                          |
|--------|------------------------|--------------------------------------|
| POST   | `/api/enrollment`      | Crear inscripción                    |
| GET    | `/api/enrollment/{id}` | Detalles de inscripción              |
| DELETE | `/api/enrollment/{id}` | Eliminar inscripción                 |
| GET    | `/api/evaluation/{id}` | Detalles de evaluación               |

### 👑 Rutas Solo Administradores
#### 🛠 Gestión de Contenido
| Método | Endpoint              | Descripción                          |
|--------|-----------------------|--------------------------------------|
| POST   | `/api/category`       | Crear categoría                      |
| PUT    | `/api/category/{id}`  | Actualizar categoría                 |
| DELETE | `/api/category/{id}`  | Eliminar categoría                   |
| POST   | `/api/course`         | Crear curso                          |
| PUT    | `/api/course/{id}`    | Actualizar curso                     |
| DELETE | `/api/course/{id}`    | Eliminar curso                       |

#### 📊 Gestión Académica
| Método | Endpoint               | Descripción                          |
|--------|------------------------|--------------------------------------|
| GET    | `/api/enrollments`     | Listar todas las inscripciones       |
| PUT    | `/api/enrollment/{id}` | Actualizar inscripción               |
| GET    | `/api/evaluations`     | Listar evaluaciones (paginadas)      |
| POST   | `/api/evaluation`      | Crear evaluación                     |
| PUT    | `/api/evaluation/{id}` | Actualizar evaluación                |
| DELETE | `/api/evaluation/{id}` | Eliminar evaluación                  |

#### 👥 Gestión de Usuarios
| Método | Endpoint          | Descripción                          |
|--------|-------------------|--------------------------------------|
| POST   | `/api/admin`      | Crear usuario administrador          |
| DELETE | `/api/user/{id}`  | Eliminar usuario                     |

📌 Notas:
Autenticación: Todas las rutas protegidas requieren el header Authorization: Bearer {token}

Paginación: Los endpoints marcados como "paginados" aceptan parámetros ?page= y ?per_page=

Roles: Las rutas de administrador verifican el rol admin del usuario

(Consulta la colección de Postman para todos los endpoints)

🛠 Postman Collection
Incluí una colección de Postman preconfigurada para probar la API fácilmente:

📂 Estructura:

postman_enviorment/
├── collections/
│   └── EducaAPI.postman_collection.json  # Todos los endpoints
├── environments/
│   └── EducaAPI_Local.postman_environment.json  # Variables para localhost


📌  Cómo importar:
Descarga los archivos JSON de la carpeta postman/.

En Postman:

Colección: Import → Selecciona el archivo ...collection.json.

Environment: Environments → Import → Selecciona ...environment.json.

token	(completar por Logueo exitoso)

