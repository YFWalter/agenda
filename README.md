# MiAgenda

Sistema de **reserva de citas online** para un salón de belleza / peluquería, construido con Laravel. Los clientes eligen un servicio, un profesional y un horario disponible, y la cita se reserva con la duración exacta del servicio dentro del horario de atención del negocio.

> ⚠️ **Proyecto demostrativo.** Es una aplicación completamente funcional, pero los datos que incluye son de ejemplo: no corresponde a un negocio real.

---

## ✨ Características

- Reserva de citas eligiendo **servicio**, **profesional** y **franja horaria** disponible.
- Disponibilidad calculada en tiempo real según los **horarios de atención** y las citas ya reservadas.
- Cada servicio tiene una **duración** propia, que determina cuánto ocupa la cita.
- Gestión de citas: ver, reprogramar y cancelar.
- **Roles** con distintos niveles de acceso (cliente, personal, administrador).
- Autenticación de usuarios (registro, login, recuperación de contraseña) con Laravel Breeze.

## 👥 Roles de usuario

| Rol | Qué puede hacer |
|-----|-----------------|
| **Cliente** | Se registra por su cuenta, reserva citas y gestiona (reprograma/cancela) las suyas. |
| **Personal (staff)** | Consulta y gestiona su propia agenda de citas, según los servicios que tiene asignados. |
| **Administrador** | Administra usuarios, servicios y horarios de atención; puede reagendar/cancelar citas e impersonar cuentas para dar soporte. |

> Los **servicios** (ej.: corte de pelo, tinte) se relacionan con el personal que puede brindarlos: un profesional solo aparece disponible para los servicios que tiene asignados.

## 🛠️ Tecnologías

- **Laravel 10** (PHP 8.1+)
- **Blade** + **Tailwind CSS** + **Alpine.js**
- **Vite** para los assets
- **Laravel Breeze** (autenticación) · **Laravel Sanctum**
- **spatie/laravel-permission** (roles y permisos)

## 📋 Requisitos

- PHP 8.1 o superior y [Composer](https://getcomposer.org/)
- Node.js y npm
- Una base de datos (MySQL por defecto)

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/YFWalter/agenda.git
cd agenda

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar el entorno
cp .env.example .env
php artisan key:generate
# Edita .env con los datos de tu base de datos (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 4. Migrar y cargar datos de ejemplo
php artisan migrate --seed

# 5. Compilar assets y levantar el servidor
npm run dev          # en una terminal (o `npm run build` para producción)
php artisan serve    # en otra terminal
```

La aplicación quedará disponible en `http://127.0.0.1:8000`.

## 🔑 Datos de ejemplo

Al ejecutar `migrate --seed` se crean cuentas y datos de prueba:

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | `guali@example.com` | `password` |
| Personal | `franco@example.com` | `password` |

También se cargan servicios de ejemplo (corte de pelo, teñir el pelo, maquillaje, barba) con sus duraciones, los horarios de atención y varios clientes de prueba.

## 📄 Licencia

Publicado bajo la licencia [MIT](https://opensource.org/licenses/MIT).
