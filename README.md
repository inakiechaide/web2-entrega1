Sistema de Gestión de Turnos

El sistema está diseñado para gestionar los turnos entre clientes y profesionales.

Diagrama de la Base de Datos

Diagrama de la base de datos (Diagrama-bd-gestion_turnos.jpg)

El diagrama muestra las relaciones entre las tablas:

- Clientes: Contiene la información básica de los clientes (nombre, teléfono, email).

- Profesionales: Registra los profesionales que atienden los turnos y su especialidad.

- Turnos: Guarda la información de los turnos asignados, relacionando a un cliente con un profesional.

Modelo de Datos

- Un cliente puede tener varios turnos.
- Un profesional puede atender muchos turnos.
- Cada turno está asignado a un solo cliente y un solo profesional.


