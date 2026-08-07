# Proyecto Integrador · Sesión 2 · Módulo 2

Investigación del mercado internacional para la **Salsa de Habanero con Mango** de la Península de
Yucatán. Continente asignado: **Asia**, con foco en el sudeste asiático. Comparativo entre Malasia,
Singapur y Filipinas.

Continúa el trabajo del Módulo 1 (`RafaelH_Rodriguez_S1M1.pdf`), donde se seleccionó el chile
habanero con Denominación de Origen y se definió como unidad de análisis una empresa social de la
Zona Maya de Quintana Roo.

## Entregables

| Archivo | Contenido |
| --- | --- |
| `RafaelH_Rodriguez_S2M2.pdf` | Documento completo (11 páginas): justificación del mercado, cuadro comparativo, matriz de selección ponderada, segmentación, infografía del Buyer Persona Internacional, implicaciones estratégicas y referencias APA |
| `RafaelH_Rodriguez_S2M2_Bibliografia.pdf` | Bibliografía anexa (4 páginas): fuentes clasificadas por tipo, con nota de uso por fuente y nota metodológica |

Los PDF se generan a partir de los archivos fuente `S2M2.html` y `Bibliografia.html`.

## Contenido del documento

1. **¿Por qué este mercado?** — planteamiento, criterios de decisión y los tres modelos de acceso
   evaluados dentro del bloque ASEAN.
2. **Cuadro comparativo** — Malasia, Singapur y Filipinas en economía, cultura, competencia,
   consumidor, barreras comerciales y tendencias de consumo.
3. **Matriz de selección ponderada** — siete criterios con peso explícito. Resultado: Singapur 4.15,
   Malasia 2.85, Filipinas 2.50.
4. **Segmentación del mercado singapurense** — geográfica, demográfica, psicográfica y conductual.
5. **Infografía del Buyer Persona Internacional** — Rachel Tan Wei Ling (33 años, Singapur), con las
   siete secciones solicitadas: datos generales, perfil personal, comportamiento de compra,
   necesidades, barreras de compra, canales de comunicación y motivadores de compra.
6. **Implicaciones estratégicas** — consecuencias del perfil sobre producto, precio, plaza y
   promoción, y secuencia de expansión regional (Singapur, luego Malasia, luego Filipinas).

## Regenerar los PDF

```bash
cd proyecto-integrador/modulo2

chromium --headless --no-pdf-header-footer \
  --print-to-pdf="RafaelH_Rodriguez_S2M2.pdf" "file://$PWD/S2M2.html"

chromium --headless --no-pdf-header-footer \
  --print-to-pdf="RafaelH_Rodriguez_S2M2_Bibliografia.pdf" "file://$PWD/Bibliografia.html"
```

El diseño usa tamaño A4 y requiere las tipografías Bitstream Charter y DejaVu Sans, más una
tipografía con soporte de caracteres chinos (WenQuanYi Zen Hei) para el nombre del buyer persona.
