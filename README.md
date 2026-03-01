# Sistema de Gestión de Modalidades de Grado

## Descripción

Sistema web desarrollado para la gestión y administración de modalidades de grado en la Facultad de Ciencias Agrícolas. Permite el registro, visualización y organización de docentes, estudiantes y modalidades académicas.

El sistema incluye autenticación de usuarios y un módulo de procesamiento automatizado de acuerdos en formato PDF, utilizando un modelo de IA (Copilot) para extraer información estructurada y almacenarla automáticamente en la base de datos.

El proyecto está desarrollado bajo arquitectura MVC utilizando CodeIgniter.

---

## Funcionalidades Principales

### Autenticación
- Inicio de sesión mediante credenciales.
- Protección de rutas internas del sistema.
- Acceso restringido a usuarios autorizados.
<img width="1920" height="944" alt="image" src="https://github.com/user-attachments/assets/4b0b3fb4-4ebc-4def-82d6-686d7b048d3e" />

### Gestión de Modalidades
- Registro automático de modalidades mediante carga de acuerdos en PDF.
  <img width="1920" height="958" alt="image" src="https://github.com/user-attachments/assets/6618a8e2-7aa9-45be-a7f6-1fefecb7be0b" />
- Procesamiento del documento utilizando modelo de IA.
- Extracción estructurada de información relevante.
- Inserción automática de datos en la base de datos.
<img width="1918" height="956" alt="image" src="https://github.com/user-attachments/assets/c13cdc23-acc7-44d1-8f3e-ecec754da1ce" />


### Gestión de Docentes
- Visualización de docentes registrados.
- Relación con modalidades asociadas.
<img width="1920" height="966" alt="Sin título" src="https://github.com/user-attachments/assets/3fe0e3e4-c098-48f1-aa0e-6a70cfa8c202" />


### Gestión de Estudiantes
- Visualización de estudiantes registrados.
- Asociación con modalidad correspondiente.
<img width="1920" height="966" alt="Sin título" src="https://github.com/user-attachments/assets/b8c26502-ab69-4f66-a04d-ba0b128dcf42" />


### Panel de Inicio
- Vista general del sistema.
- Acceso rápido a los módulos principales.
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/6652298f-400f-4e2b-8c43-f0720f93d8e0" />


---

## Procesamiento Automatizado de Acuerdos

El sistema permite la carga de archivos PDF correspondientes a acuerdos oficiales.

Flujo del proceso:

1. Usuario carga el archivo PDF del acuerdo.
2. El sistema envía el contenido a un modelo de IA (Copilot).
3. El modelo extrae información estructurada (modalidad, docentes, estudiantes, fechas, etc.).
4. Los datos procesados son validados.
5. Se realiza la inserción automática en la base de datos relacional.

Este módulo reduce el ingreso manual de información y minimiza errores administrativos.

---

## Tecnologías Utilizadas

### Backend
- PHP
- CodeIgniter
- Arquitectura MVC

### Frontend
- HTML5
- CSS3
- Bootstrap
- JavaScript
- AJAX
- DataTables

### Base de Datos
- MySQL / PostgreSQL

### Integración
- Procesamiento de documentos mediante modelo de IA (Copilot)

### Control de Versiones
- Git

---

## Arquitectura del Sistema

El proyecto está estructurado bajo el patrón Modelo-Vista-Controlador:

- Models: Gestión de consultas y lógica de acceso a datos.
- Views: Interfaces de usuario (Login, Inicio, Docentes, Estudiantes, Modalidades).
- Controllers: Lógica de negocio, autenticación y procesamiento de archivos.

---

## Estructura del Proyecto

```
app/
 ├── Controllers/
 ├── Models/
 ├── Views/
public/
 ├── assets/
```

---

## Seguridad

- Autenticación de usuarios.
- Protección de rutas internas.
- Validación de archivos antes del procesamiento.
- Separación de responsabilidades por capas.

## Estado del Proyecto

Actualmente en fase de desarrollo activo. 
Las funcionalidades principales se encuentran implementadas y en proceso de optimización y ampliación.

---

## Autor

Jonás Samuel Salazar Torres  
Estudiante de Ingeniería de Sistemas – Noveno semestre  
GitHub: https://github.com/zzzam21
