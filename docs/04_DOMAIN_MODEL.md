# DOMAIN MODEL

## Proyecto

**Nombre:** Parfum  
**Versión:** 1.0

---

# Propósito del documento

Este documento define el modelo de dominio inicial de Parfum.

Su objetivo es representar los conceptos principales del negocio, sus responsabilidades y las relaciones que existen entre ellos.

Este documento no define todavía:

- Migraciones.
- Tipos exactos de columnas.
- Índices.
- Claves foráneas específicas.
- Implementaciones técnicas.
- Código de modelos Eloquent.

Estos detalles deberán definirse durante la implementación técnica, respetando las necesidades del dominio y las convenciones de Laravel.

---

# Principios del modelo de dominio

El modelo deberá cumplir los siguientes principios:

- Representar correctamente el negocio de la perfumería.
- Mantener responsabilidades claras.
- Evitar duplicación de información.
- Permitir que el contenido público sea administrable.
- Facilitar búsquedas, filtros y comparaciones.
- Permitir la expansión futura hacia inventario, ventas y comercio electrónico.
- Mantener una estructura flexible sin caer en complejidad innecesaria.
- Utilizar nombres claros y consistentes.
- Evitar almacenar información calculable de manera redundante.

---

# Entidades principales

## 1. Perfume

Representa el producto principal de Parfum.

### Información básica

- Nombre.
- Slug.
- Descripción corta.
- Descripción completa.
- Historia o narrativa del perfume.
- Año de lanzamiento.
- País de origen.
- Género recomendado.
- Concentración.
- Estado de publicación.
- Indicador de producto destacado.
- Indicador de producto más vendido.
- Orden de visualización.

### Características de desempeño

- Duración mínima estimada.
- Duración máxima estimada.
- Nivel de duración.
- Nivel de proyección.
- Intensidad general.
- Versatilidad.
- Estación o clima recomendado.
- Ocasiones recomendadas.

### Información comercial futura

Aunque la primera versión pública no se enfoca en ventas, el dominio deberá quedar preparado para incorporar posteriormente:

- Precio.
- Precio promocional.
- Código interno.
- Código de barras.
- Presentación en mililitros.
- Estado de disponibilidad.
- Stock.

### Relaciones

Un perfume:

- Pertenece a una marca.
- Pertenece a una categoría principal.
- Puede pertenecer a varias colecciones.
- Puede tener varias imágenes.
- Puede tener varios acordes.
- Puede tener varias notas olfativas.
- Puede estar recomendado para varias ocasiones.
- Puede estar recomendado para varias temporadas.
- Puede tener varias reseñas.
- Puede estar relacionado con otros perfumes.
- Puede tener varios rasgos de personalidad.
- Puede tener diferentes etapas dentro de su evolución aromática.

---

## 2. Marca

Representa la casa o fabricante de un perfume.

### Información

- Nombre.
- Slug.
- Descripción.
- Historia.
- País de origen.
- Año de fundación.
- Logotipo.
- Imagen de portada.
- Sitio web oficial.
- Estado.
- Orden de visualización.

### Relaciones

Una marca:

- Tiene muchos perfumes.

---

## 3. Categoría

Representa la clasificación comercial o editorial de un perfume.

### Ejemplos

- Perfumería árabe.
- Perfumería de diseñador.
- Perfumería nicho.
- Perfumería de revista.
- Ediciones especiales.
- Colecciones exclusivas.

### Información

- Nombre.
- Slug.
- Descripción.
- Imagen.
- Estado.
- Orden de visualización.

### Relaciones

Una categoría:

- Tiene muchos perfumes.

Un perfume pertenece inicialmente a una categoría principal, aunque el diseño técnico podrá permitir múltiples categorías si el negocio lo necesita en el futuro.

---

## 4. Colección

Representa una agrupación editorial o promocional de perfumes.

No debe confundirse con una categoría.

### Ejemplos

- Perfumes para una primera cita.
- Aromas para clima cálido.
- Los más vendidos.
- Elegancia nocturna.
- Perfumes para oficina.
- Selección Parfum.
- Nuevos lanzamientos.

### Información

- Nombre.
- Slug.
- Descripción.
- Imagen de portada.
- Fecha de inicio.
- Fecha de finalización opcional.
- Estado.
- Orden de visualización.

### Relaciones

Una colección:

- Contiene varios perfumes.

Un perfume:

- Puede pertenecer a varias colecciones.

---

# Clasificación olfativa

## 5. Familia olfativa

Representa la clasificación general a la que pertenece la composición de un perfume.

### Ejemplos

- Cítrica.
- Floral.
- Amaderada.
- Oriental.
- Aromática.
- Cuero.
- Chipre.
- Gourmand.
- Acuática.
- Frutal.
- Especiada.

### Información

- Nombre.
- Slug.
- Descripción.
- Icono o imagen.
- Estado.
- Orden de visualización.

### Relaciones

Una familia olfativa:

- Puede estar asociada a muchos perfumes.

Un perfume:

- Puede tener una familia principal.
- Puede tener familias secundarias.

---

## 6. Acorde

Representa una sensación aromática general percibida en un perfume.

Los acordes serán utilizados para las barras visuales de la interfaz.

### Ejemplos

- Dulce.
- Amaderado.
- Cítrico.
- Floral.
- Fresco.
- Especiado.
- Aromático.
- Avainillado.
- Ámbar.
- Atalcado.
- Afrutado.
- Ahumado.
- Cuero.
- Verde.
- Marino.

### Información

- Nombre.
- Slug.
- Descripción.
- Color representativo.
- Icono opcional.
- Estado.
- Orden de visualización.

### Relación con Perfume

Un perfume puede tener varios acordes.

La relación entre perfume y acorde deberá incluir:

- Nivel de intensidad.
- Orden de importancia.
- Indicador de acorde principal.

La intensidad podrá representarse mediante una escala numérica consistente, por ejemplo de 0 a 100.

---

## 7. Nota olfativa

Representa un ingrediente, esencia o sensación identificable dentro de la composición de un perfume.

### Ejemplos

- Bergamota.
- Limón.
- Vainilla.
- Canela.
- Lavanda.
- Ámbar.
- Sándalo.
- Rosa.
- Jazmín.
- Tabaco.
- Oud.

### Información

- Nombre.
- Slug.
- Descripción.
- Imagen.
- Tipo u origen.
- Estado.
- Orden de visualización.

### Relación con Perfume

Un perfume puede tener muchas notas olfativas.

La relación deberá indicar la etapa de la pirámide:

- Salida.
- Corazón.
- Fondo.

También podrá incluir:

- Orden de aparición.
- Intensidad estimada.
- Descripción específica dentro del perfume.

---

## 8. Pirámide olfativa

La pirámide olfativa representa la evolución estructural del aroma.

No necesariamente requiere una entidad independiente si puede modelarse correctamente mediante la relación entre perfume y nota olfativa.

Las etapas son:

### Notas de salida

Son las primeras notas percibidas después de aplicar el perfume.

### Notas de corazón

Representan la identidad principal de la fragancia después de que las notas iniciales disminuyen.

### Notas de fondo

Son las notas de mayor duración y las que permanecen durante la fase final.

La implementación deberá evitar duplicar información entre una entidad de pirámide y la relación de notas.

---

# Experiencia del perfume

## 9. Ocasión

Representa el contexto en el que se recomienda utilizar un perfume.

### Ejemplos

- Uso diario.
- Oficina.
- Cita.
- Fiesta.
- Evento formal.
- Universidad.
- Actividades al aire libre.
- Reunión especial.

### Información

- Nombre.
- Slug.
- Descripción.
- Icono.
- Estado.
- Orden de visualización.

### Relaciones

Una ocasión:

- Puede estar asociada a muchos perfumes.

Un perfume:

- Puede estar recomendado para varias ocasiones.

La relación podrá incluir un nivel de compatibilidad de 0 a 100.

---

## 10. Temporada

Representa la época, clima o condición ambiental recomendada.

### Ejemplos

- Primavera.
- Verano.
- Otoño.
- Invierno.
- Clima cálido.
- Clima templado.
- Clima frío.
- Día.
- Noche.

Se deberá evaluar técnicamente si el momento del día debe pertenecer a esta entidad o manejarse mediante una clasificación independiente.

### Información

- Nombre.
- Slug.
- Descripción.
- Icono.
- Estado.
- Orden de visualización.

### Relaciones

Una temporada:

- Puede estar asociada a muchos perfumes.

Un perfume:

- Puede estar recomendado para varias temporadas.

La relación podrá incluir un nivel de compatibilidad de 0 a 100.

---

## 11. Rasgo de personalidad

Representa las características emocionales o sociales que transmite un perfume.

### Ejemplos

- Elegante.
- Seductor.
- Misterioso.
- Seguro.
- Extrovertido.
- Reservado.
- Moderno.
- Clásico.
- Atrevido.
- Sofisticado.
- Versátil.
- Romántico.

### Información

- Nombre.
- Slug.
- Descripción.
- Icono.
- Estado.
- Orden de visualización.

### Relaciones

Un rasgo:

- Puede estar asociado a muchos perfumes.

Un perfume:

- Puede tener varios rasgos de personalidad.

La relación deberá incluir una intensidad o nivel de afinidad de 0 a 100.

---

## 12. Evolución aromática

Representa cómo cambia un perfume después de ser aplicado.

Esta entidad permitirá construir la línea de tiempo del perfume.

### Ejemplo

- Primeros 15 minutos: predominan bergamota y limón.
- A los 30 minutos: aparecen lavanda y especias.
- Después de 2 horas: predomina la vainilla.
- Después de 8 horas: permanecen ámbar y maderas.

### Información

- Perfume relacionado.
- Título de la etapa.
- Tiempo aproximado.
- Descripción.
- Orden.
- Estado.

### Relaciones

Un perfume:

- Puede tener varias etapas de evolución aromática.

---

# Contenido visual

## 13. Imagen de perfume

Representa las imágenes asociadas a un perfume.

### Tipos posibles

- Imagen principal.
- Galería.
- Imagen de tarjeta.
- Imagen horizontal.
- Imagen de fondo.
- Imagen para comparador.
- Imagen promocional.

### Información

- Ruta o ubicación.
- Texto alternativo.
- Tipo.
- Orden.
- Estado.
- Indicador de imagen principal.

### Relaciones

Una imagen:

- Pertenece a un perfume.

Un perfume:

- Puede tener varias imágenes.

---

## 14. Recurso multimedia

Representa recursos como videos, animaciones o elementos visuales especiales.

### Información

- Nombre.
- Tipo.
- Ruta o URL.
- Texto alternativo.
- Imagen de portada.
- Ubicación de uso.
- Reproducción automática.
- Repetición.
- Estado.
- Orden.

### Posibles usos

- Video principal del Hero.
- Video de un perfume.
- Video de marca.
- Animación promocional.
- Contenido para una colección.

---

# Contenido administrable

## 15. Página de contenido

Representa una página pública cuyo contenido será administrable.

### Ejemplos

- Nosotros.
- Contacto.
- Política de privacidad.
- Términos y condiciones.

### Información

- Nombre.
- Slug.
- Título.
- Subtítulo.
- Contenido.
- Imagen principal.
- Meta título.
- Meta descripción.
- Estado de publicación.

---

## 16. Sección de contenido

Representa una sección dinámica dentro de una página.

Permitirá administrar el contenido de la web sin modificar las vistas.

### Ejemplos

- Hero del Home.
- Nuestra historia.
- Categorías destacadas.
- Más vendidos.
- Descubre tu Aroma.
- Comparador.
- Llamado a la acción.
- Instagram.
- Reseñas.

### Información

- Página relacionada.
- Clave o identificador técnico.
- Título.
- Subtítulo.
- Descripción.
- Texto del botón.
- Enlace del botón.
- Imagen.
- Video.
- Configuración adicional.
- Estado.
- Orden.

### Consideración técnica

No se debe construir un sistema excesivamente genérico que dificulte el mantenimiento.

Las secciones especiales podrán tener estructuras propias cuando sus necesidades sean claramente diferentes.

---

## 17. Configuración del sitio

Representa los datos generales de Parfum.

### Información

- Nombre comercial.
- Eslogan.
- Logotipo principal.
- Logotipo alternativo.
- Favicon.
- Correo.
- Teléfono.
- WhatsApp.
- Dirección.
- Horario.
- Texto del Footer.
- Meta título global.
- Meta descripción global.
- Imagen predeterminada para redes sociales.

Inicialmente podrá existir un único registro activo de configuración.

---

## 18. Red social

Representa los canales sociales oficiales.

### Información

- Nombre de la plataforma.
- URL.
- Nombre de usuario.
- Icono.
- Estado.
- Orden.

### Ejemplos

- Instagram.
- Facebook.
- TikTok.
- YouTube.
- X.
- WhatsApp.

---

## 19. Publicación social

Representa contenido social que se mostrará dentro del sitio.

### Información

- Red social.
- URL de la publicación.
- Imagen.
- Descripción.
- Fecha de publicación.
- Estado.
- Orden.

En una versión futura podrá sincronizarse con APIs externas.

En el MVP podrá administrarse internamente.

---

## 20. Testimonio o reseña destacada

Representa una opinión seleccionada para mostrarse en el Home.

### Información

- Nombre del autor.
- Fotografía opcional.
- Calificación.
- Comentario.
- Cargo o descripción opcional.
- Estado.
- Orden.

Esta entidad puede ser independiente de las reseñas específicas de perfumes.

---

# Interacción con perfumes

## 21. Reseña de perfume

Representa la opinión de un usuario sobre un perfume.

### Información

- Perfume.
- Nombre del autor.
- Correo opcional.
- Calificación general.
- Comentario.
- Calificación de duración.
- Calificación de proyección.
- Fecha.
- Estado de moderación.
- Indicador de reseña destacada.

### Estados posibles

- Pendiente.
- Aprobada.
- Rechazada.

### Relaciones

Una reseña:

- Pertenece a un perfume.

Un perfume:

- Puede tener muchas reseñas.

En el MVP se podrá trabajar con reseñas cargadas mediante datos de prueba. La interacción pública podrá implementarse posteriormente.

---

## 22. Relación entre perfumes

Representa perfumes semejantes, alternativos o recomendados.

### Tipos posibles

- Similar.
- Alternativa.
- Inspirado en.
- Recomendado.
- Complementario.
- Comparación frecuente.

### Información

- Perfume principal.
- Perfume relacionado.
- Tipo de relación.
- Nivel de similitud.
- Descripción.
- Orden.

La relación debe evitar duplicados y referencias de un perfume consigo mismo.

---

# Descubre tu Aroma

## 23. Pregunta del cuestionario

Representa una pregunta de la experiencia “Mi Aroma Perfecto”.

### Ejemplos

- ¿En qué ocasión usarás el perfume?
- ¿Qué aromas prefieres?
- ¿Qué intensidad buscas?
- ¿En qué clima lo utilizarás?
- ¿Qué personalidad quieres transmitir?

### Información

- Texto.
- Descripción opcional.
- Tipo de respuesta.
- Orden.
- Estado.
- Indicador de obligatoriedad.

---

## 24. Opción de respuesta

Representa una posible respuesta a una pregunta.

### Información

- Pregunta relacionada.
- Texto.
- Descripción.
- Icono o imagen.
- Valor interno.
- Orden.
- Estado.

### Relaciones

Una pregunta:

- Tiene varias opciones.

---

## 25. Regla de recomendación

Representa los criterios utilizados para recomendar perfumes sin inteligencia artificial.

### Información

- Opción de respuesta.
- Criterio relacionado.
- Valor o ponderación.
- Prioridad.
- Estado.

### Funcionamiento esperado

Cada respuesta seleccionada aportará puntuación a uno o varios criterios como:

- Acordes.
- Familias olfativas.
- Ocasiones.
- Temporadas.
- Duración.
- Proyección.
- Personalidad.

Los perfumes con mayor compatibilidad serán recomendados al usuario.

La lógica exacta deberá documentarse antes de su implementación.

---

## 26. Resultado del cuestionario

En la primera versión no será obligatorio persistir cada sesión del cuestionario.

Si en el futuro se requiere analítica o personalización, podrá almacenarse:

- Identificador de sesión.
- Respuestas seleccionadas.
- Perfumes recomendados.
- Puntajes obtenidos.
- Fecha.
- Usuario opcional.

---

# Comparador

El comparador no requiere necesariamente una entidad persistente en el MVP.

Deberá utilizar la información existente de los perfumes para comparar:

- Marca.
- Categoría.
- Familia olfativa.
- Acordes.
- Notas.
- Duración.
- Proyección.
- Intensidad.
- Temporadas.
- Ocasiones.
- Rasgos de personalidad.

En una versión futura se podrán registrar las comparaciones más realizadas para obtener analítica.

---

# Contacto

## 27. Mensaje de contacto

Representa una solicitud enviada desde el formulario de contacto.

### Información

- Nombre.
- Correo.
- Teléfono opcional.
- Asunto.
- Mensaje.
- Estado.
- Fecha de lectura.
- Fecha de respuesta.

### Estados posibles

- Nuevo.
- Leído.
- Respondido.
- Archivado.

---

# Administración y seguridad futura

## 28. Usuario administrativo

Representará a las personas autorizadas para gestionar Parfum.

Laravel podrá utilizar el modelo de usuario estándar como punto de partida.

### Información relevante

- Nombre.
- Correo.
- Contraseña.
- Estado.
- Último acceso.

### Relaciones futuras

Un usuario:

- Puede tener uno o varios roles.
- Puede tener permisos.
- Puede registrar cambios.
- Puede gestionar contenido.

---

## 29. Rol

### Ejemplos

- Administrador.
- Editor de contenido.
- Gestor de catálogo.
- Gestor de inventario.

### Relaciones

Un rol:

- Puede pertenecer a varios usuarios.
- Puede tener varios permisos.

---

## 30. Permiso

Representa una acción autorizada dentro del panel.

### Ejemplos

- Ver perfumes.
- Crear perfumes.
- Editar perfumes.
- Eliminar perfumes.
- Publicar contenido.
- Administrar usuarios.
- Gestionar inventario.

La estrategia exacta de autorización se definirá durante el desarrollo del panel administrativo.

---

# Entidades futuras de inventario y ventas

Estas entidades no forman parte del MVP público, pero el dominio deberá poder evolucionar para incorporarlas.

## Variante de perfume

Permitirá manejar distintas presentaciones del mismo perfume.

Ejemplos:

- 50 ml.
- 100 ml.
- Tester.
- Decant de 5 ml.
- Decant de 10 ml.

## Inventario

Permitirá conocer las unidades disponibles por variante.

## Movimiento de inventario

Registrará entradas, salidas, ajustes y ventas.

## Cliente

Representará compradores registrados.

## Pedido

Representará una compra.

## Detalle de pedido

Representará los productos incluidos en una compra.

## Pago

Representará la información de pago.

## Dirección

Representará las direcciones de entrega de un cliente.

Estas entidades deberán diseñarse cuando se inicie la funcionalidad de comercio electrónico.

---

# Relaciones principales resumidas

```text
Marca
  └── Tiene muchos Perfumes

Categoría
  └── Tiene muchos Perfumes

Perfume
  ├── Pertenece a una Marca
  ├── Pertenece a una Categoría principal
  ├── Puede pertenecer a varias Colecciones
  ├── Tiene varias Imágenes
  ├── Tiene varios Acordes
  ├── Tiene varias Notas olfativas
  ├── Puede tener varias Familias olfativas
  ├── Está asociado con varias Ocasiones
  ├── Está asociado con varias Temporadas
  ├── Tiene varios Rasgos de personalidad
  ├── Tiene varias Etapas de evolución
  ├── Tiene varias Reseñas
  └── Puede relacionarse con otros Perfumes

Página de contenido
  └── Tiene varias Secciones de contenido

Pregunta del cuestionario
  └── Tiene varias Opciones de respuesta

Opción de respuesta
  └── Puede generar varias Reglas de recomendación