# Panel Administrativo

# Proyecto

Parfum

Versión 2.0

---

# Objetivo

Construir un panel administrativo premium que permita gestionar completamente el contenido de Parfum sin depender de modificaciones al código fuente.

Toda la información visible en el Frontend deberá poder administrarse desde este panel.

El panel compartirá el mismo dominio de negocio del Frontend público, reutilizando la arquitectura existente y manteniendo una experiencia moderna, consistente y escalable.

El administrador será la única fuente de mantenimiento del sistema.

---

# Objetivos

La versión 2.0 deberá permitir administrar completamente:

- Perfumes.
- Marcas.
- Categorías.
- Acordes.
- Notas olfativas.
- Climas.
- Temporadas.
- Ocasiones.
- Imágenes.
- Mi Aroma Perfecto.
- Contenido institucional.
- Información de contacto.
- SEO.
- Configuración general del sitio.

---

# Alcance

El panel administrativo será una aplicación independiente del Frontend público.

Compartirá:

- modelos;
- servicios;
- reglas de negocio;
- base de datos;
- componentes reutilizables.

No deberá duplicar lógica existente.

Toda funcionalidad deberá integrarse sobre la arquitectura construida durante la Fase 1.

---

# Filosofía de Desarrollo

Cada Sprint deberá:

- ser completamente funcional;
- poder validarse de manera independiente;
- mantener la arquitectura existente;
- reutilizar componentes antes de crear nuevos;
- evitar deuda técnica;
- incluir pruebas automatizadas;
- quedar listo para producción antes de continuar con el siguiente Sprint.

---

# Principios

El panel deberá sentirse tan premium como el Frontend.

No será un CRUD tradicional.

La experiencia deberá transmitir:

- simplicidad;
- orden;
- velocidad;
- elegancia;
- consistencia.

Cada pantalla deberá sentirse como una extensión natural del sitio público.

---

# Módulos

## Dashboard

Debe mostrar indicadores generales del sistema.

Ejemplos:

- Total de perfumes.
- Marcas.
- Categorías.
- Acordes.
- Notas.
- Preguntas.
- Reglas.
- Últimas modificaciones.

---

## Perfumes

CRUD completo.

Cada perfume deberá permitir administrar:

- nombre;
- slug;
- descripción;
- historia editorial;
- marca;
- categoría;
- acordes;
- notas de salida;
- notas de corazón;
- notas de fondo;
- duración;
- proyección;
- intensidad;
- climas;
- temporadas;
- ocasiones;
- perfumes relacionados;
- estado;
- imágenes.

---

## Marcas

CRUD completo.

---

## Categorías

CRUD completo.

---

## Acordes

CRUD completo.

---

## Notas Olfativas

CRUD completo.

---

## Climas

CRUD completo.

---

## Temporadas

CRUD completo.

---

## Ocasiones

CRUD completo.

---

## Imágenes

Cada perfume podrá administrar múltiples imágenes.

El administrador podrá:

- subir imágenes;
- eliminar imágenes;
- ordenar imágenes;
- seleccionar portada;
- editar texto alternativo.

---

## Mi Aroma Perfecto

Administración completa de:

- preguntas;
- opciones;
- reglas;
- pesos;
- orden;
- activación.

El RecommendationService deberá seguir siendo la única fuente de cálculo del recomendador.

No deberá requerirse modificar código para cambiar el comportamiento del asistente.

---

## Contenido Institucional

Administración de:

- Hero.
- Historia.
- Filosofía.
- Misión.
- Visión.
- Valores.
- Información de contacto.
- Redes sociales.
- Footer.

---

## SEO

Administración de:

- títulos;
- descripciones;
- robots;
- Open Graph;
- Twitter Cards.

---

## Configuración

Configuraciones generales del sitio.

Ejemplos:

- nombre del sitio;
- correo de contacto;
- teléfono;
- dirección;
- enlaces sociales;
- configuraciones futuras.

---

# Lo que NO incluye

Esta versión no desarrollará todavía:

- ventas;
- carrito;
- inventario;
- pedidos;
- pagos;
- favoritos;
- lista de deseos;
- blog;
- comentarios;
- notificaciones;
- analítica avanzada.

---

# Arquitectura

Todo el panel deberá reutilizar la arquitectura existente.

No deberán duplicarse:

- modelos;
- servicios;
- reglas de negocio;
- componentes;
- validaciones;
- consultas.

Toda nueva funcionalidad deberá integrarse sobre la base existente.

---

# Principios Técnicos

Todo desarrollo deberá cumplir:

- SOLID.
- Laravel Best Practices.
- Blade Components reutilizables.
- Eloquent.
- Form Requests.
- Services.
- Policies.
- Gates cuando sean necesarios.
- Middleware reutilizables.
- MySQL.
- Pruebas automatizadas.

---

# Principios de Diseño

El panel deberá mantener la identidad visual de Parfum.

Deberá cumplir:

- excelente legibilidad;
- mucho espacio en blanco;
- diseño editorial;
- tablas modernas;
- formularios claros;
- navegación intuitiva;
- componentes reutilizables;
- responsive;
- accesibilidad.

Nunca deberá sentirse como un sistema administrativo tradicional.

---

# Componentes Base

Desde el inicio deberán existir componentes reutilizables para:

- Layout administrativo.
- Sidebar.
- Navbar.
- Dashboard Cards.
- Breadcrumbs.
- Formularios.
- Inputs.
- Selects.
- Textareas.
- Checkboxes.
- Tablas.
- Badges.
- Alertas.
- Flash Messages.
- Botones.
- Confirmaciones.
- Paginación.

---

# Criterios de Éxito

La versión 2.0 será considerada exitosa cuando:

- cualquier contenido pueda modificarse sin tocar código;
- el panel sea intuitivo;
- la administración sea rápida;
- la arquitectura continúe siendo escalable;
- agregar nuevos módulos sea sencillo;
- el diseño mantenga la calidad visual del Frontend.

---

# Roadmap Técnico

## Sprint 1 ✅

Infraestructura administrativa.

Incluye:

- Login administrativo.
- Dashboard.
- Layout.
- Sidebar.
- Navbar.
- Middleware.
- Roles.
- Estadísticas generales.

---

## Sprint 2 ✅

CRUD completo de Perfumes.

Incluye:

- formulario reutilizable;
- búsqueda;
- filtros;
- relaciones;
- validaciones;
- activación/desactivación;
- servicios;
- pruebas.

---

## Sprint 3 ✅

CRUD completo de:

- Marcas.
- Categorías.

---

## Sprint 4

CRUD completo de:

- Acordes.
- Notas Olfativas.

---

## Sprint 5

CRUD completo de:

- Climas.
- Temporadas.
- Ocasiones.

---

## Sprint 6

Gestión de Imágenes.

Cada perfume podrá:

- subir imágenes;
- eliminar imágenes;
- ordenar imágenes;
- seleccionar portada;
- editar texto alternativo.

---

## Sprint 7

Administración de Mi Aroma Perfecto.

Gestión completa de:

- preguntas;
- opciones;
- reglas;
- pesos;
- orden;
- activación.

---

## Sprint 8

Contenido Institucional.

Administración de:

- Hero.
- Historia.
- Filosofía.
- Misión.
- Visión.
- Valores.
- Contacto.
- Redes sociales.
- Footer.

---

## Sprint 9

SEO y Configuración.

Administración de:

- SEO.
- Robots.
- Open Graph.
- Twitter Cards.
- Configuración general.

---

## Sprint 10

Release Candidate.

Incluye:

- optimización;
- revisión completa;
- limpieza de código;
- accesibilidad;
- pruebas finales;
- corrección de bugs;
- preparación para producción.

---

# Objetivo Final

La Fase 2 convertirá Parfum en una plataforma completamente administrable.

El administrador podrá evolucionar el contenido del sitio durante años sin depender de modificaciones directas al código fuente.

Toda nueva funcionalidad deberá integrarse sobre una arquitectura limpia, reutilizable y escalable, manteniendo la misma calidad técnica y visual construida durante la Fase 1.