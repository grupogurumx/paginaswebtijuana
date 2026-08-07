# Proyecto Integrador · Sesión 2 · Módulo 2

Investigación del mercado internacional para la **Salsa de Habanero con Mango** de la Península de
Yucatán. Continente asignado: **Asia**. Comparativo entre Japón, Corea del Sur y Singapur.

Continúa el trabajo del Módulo 1 (`RafaelH_Rodriguez_S1M1.pdf`), donde se seleccionó el chile
habanero con Denominación de Origen y se definió como unidad de análisis una empresa social de la
Zona Maya de Quintana Roo.

## Entregables

| Archivo | Contenido |
| --- | --- |
| `RafaelH_Rodriguez_S2M2.pdf` | Documento completo (11 páginas): justificación del mercado, cuadro comparativo, matriz de selección ponderada, segmentación, infografía del Buyer Persona Internacional, implicaciones estratégicas y referencias APA |
| `RafaelH_Rodriguez_S2M2_Bibliografia.pdf` | Bibliografía anexa (3 páginas): fuentes clasificadas por tipo, con nota de uso por fuente y nota metodológica |

Los PDF se generan a partir de los archivos fuente `S2M2.html` y `Bibliografia.html`.

## Contenido del documento

1. **¿Por qué este mercado?** — planteamiento, criterios de decisión y los tres modelos de acceso
   evaluados.
2. **Cuadro comparativo** — Japón, Corea del Sur y Singapur en economía, cultura, competencia,
   consumidor, barreras comerciales y tendencias de consumo.
3. **Matriz de selección ponderada** — siete criterios con peso explícito. Resultado: Japón 4.50,
   Singapur 3.55, Corea del Sur 2.35.
4. **Segmentación del mercado japonés** — geográfica, demográfica, psicográfica y conductual.
5. **Infografía del Buyer Persona Internacional** — Yui Nakamura (34 años, Tokio), con las siete
   secciones solicitadas: datos generales, perfil personal, comportamiento de compra, necesidades,
   barreras de compra, canales de comunicación y motivadores de compra.
6. **Implicaciones estratégicas** — consecuencias del perfil sobre producto, precio, plaza y
   promoción.

## Regenerar los PDF

```bash
cd proyecto-integrador/modulo2

chromium --headless --no-pdf-header-footer \
  --print-to-pdf="RafaelH_Rodriguez_S2M2.pdf" "file://$PWD/S2M2.html"

chromium --headless --no-pdf-header-footer \
  --print-to-pdf="RafaelH_Rodriguez_S2M2_Bibliografia.pdf" "file://$PWD/Bibliografia.html"
```

El diseño usa tamaño A4 y requiere las tipografías Bitstream Charter, DejaVu Sans e IPAGothic (esta
última para los caracteres japoneses).
