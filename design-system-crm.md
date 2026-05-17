# Design System — CRM Corporativo

> Sistema de diseño construido sobre una identidad azul profunda, tipografía moderna-seria y detalles de glassmorphism contenidos. Cada decisión apunta a confianza, claridad y eficiencia.

---

## 1. Paleta de Colores

```css
:root {

  /* ── Azules Primarios ── */
  --color-primary-950: #03112e;   /* Fondos oscuros premium */
  --color-primary-900: #061d4a;   /* Sidebar, nav profundo */
  --color-primary-800: #0a2d6e;   /* Headers de sección */
  --color-primary-700: #1241a3;   /* Botones primarios hover */
  --color-primary-600: #1a52cc;   /* Botón primario base */
  --color-primary-500: #2563eb;   /* Acento principal (azul corporativo) */
  --color-primary-400: #3b82f6;   /* Links, íconos activos */
  --color-primary-300: #93c5fd;   /* Bordes sutiles, placeholders */
  --color-primary-200: #bfdbfe;   /* Tints de fondo */
  --color-primary-100: #dbeafe;   /* Fondos de tarjeta activa */
  --color-primary-50:  #eff6ff;   /* Background suave */

  /* ── Neutros ── */
  --color-neutral-950: #090e1a;
  --color-neutral-900: #111827;
  --color-neutral-800: #1f2937;
  --color-neutral-700: #374151;
  --color-neutral-600: #4b5563;
  --color-neutral-500: #6b7280;
  --color-neutral-400: #9ca3af;
  --color-neutral-300: #d1d5db;
  --color-neutral-200: #e5e7eb;
  --color-neutral-100: #f3f4f6;
  --color-neutral-50:  #f9fafb;
  --color-white:       #ffffff;

  /* ── Estado / Semánticos ── */
  --color-success-600: #059669;
  --color-success-100: #d1fae5;
  --color-warning-500: #f59e0b;
  --color-warning-100: #fef3c7;
  --color-danger-600:  #dc2626;
  --color-danger-100:  #fee2e2;
  --color-info-500:    #0ea5e9;
  --color-info-100:    #e0f2fe;

  /* ── Glassmorphism Tokens ── */
  --glass-bg:          rgba(255, 255, 255, 0.07);
  --glass-bg-light:    rgba(255, 255, 255, 0.55);
  --glass-border:      rgba(255, 255, 255, 0.14);
  --glass-border-dark: rgba(37, 99, 235, 0.25);
  --glass-shadow:      0 8px 32px rgba(3, 17, 46, 0.28);
  --glass-blur:        blur(14px);
  --glass-blur-heavy:  blur(24px);
}
```

### Uso rápido de la paleta

| Token | Uso principal |
|---|---|
| `--color-primary-500` | CTA principal, badges activos, avatar ring |
| `--color-primary-900` | Sidebar, nav oscuro, modales premium |
| `--color-primary-100` | Fondo de row seleccionado, chip de filtro |
| `--color-neutral-700` | Texto body principal (modo claro) |
| `--color-neutral-400` | Labels, placeholders, metadatos |

---

## 2. Tipografía

```css
/* Google Fonts — importar en <head> */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap');

:root {
  /* Familias */
  --font-sans:  'DM Sans', 'Helvetica Neue', Arial, sans-serif;
  --font-mono:  'DM Mono', 'Courier New', monospace;

  /* Escala tipográfica (Major Third — 1.25) */
  --text-xs:   0.75rem;    /* 12px — micro labels, timestamps */
  --text-sm:   0.875rem;   /* 14px — body secundario, table cells */
  --text-base: 1rem;       /* 16px — body principal */
  --text-lg:   1.125rem;   /* 18px — subtítulos de sección */
  --text-xl:   1.25rem;    /* 20px — card headings */
  --text-2xl:  1.5rem;     /* 24px — page title secundario */
  --text-3xl:  1.875rem;   /* 30px — page title principal */
  --text-4xl:  2.25rem;    /* 36px — dashboard hero metric */

  /* Pesos */
  --weight-light:   300;
  --weight-regular: 400;
  --weight-medium:  500;
  --weight-semibold:600;
  --weight-bold:    700;

  /* Line heights */
  --leading-tight:  1.2;
  --leading-snug:   1.375;
  --leading-normal: 1.5;
  --leading-relaxed:1.625;

  /* Letter spacing */
  --tracking-tight:  -0.02em;
  --tracking-normal:  0em;
  --tracking-wide:    0.04em;
  --tracking-widest:  0.1em;
}
```

### Jerarquía de texto

```css
/* Page title */
.text-page-title {
  font-family: var(--font-sans);
  font-size: var(--text-3xl);
  font-weight: var(--weight-semibold);
  letter-spacing: var(--tracking-tight);
  line-height: var(--leading-tight);
  color: var(--color-neutral-900);
}

/* Section heading */
.text-section-heading {
  font-size: var(--text-xl);
  font-weight: var(--weight-semibold);
  letter-spacing: var(--tracking-tight);
  color: var(--color-neutral-800);
}

/* Card title */
.text-card-title {
  font-size: var(--text-lg);
  font-weight: var(--weight-medium);
  color: var(--color-neutral-800);
}

/* Body */
.text-body {
  font-size: var(--text-base);
  font-weight: var(--weight-regular);
  line-height: var(--leading-normal);
  color: var(--color-neutral-700);
}

/* Label / Caption */
.text-label {
  font-size: var(--text-xs);
  font-weight: var(--weight-medium);
  letter-spacing: var(--tracking-widest);
  text-transform: uppercase;
  color: var(--color-neutral-500);
}

/* Métrica grande (KPI) */
.text-metric {
  font-size: var(--text-4xl);
  font-weight: var(--weight-bold);
  letter-spacing: var(--tracking-tight);
  color: var(--color-primary-500);
}

/* Código / ID interno */
.text-mono {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--color-primary-400);
  background: var(--color-primary-50);
  padding: 2px 6px;
  border-radius: var(--radius-sm);
}
```

---

## 3. Espaciado

> Base de 4px — múltiplos consistentes.

```css
:root {
  --space-1:  4px;
  --space-2:  8px;
  --space-3:  12px;
  --space-4:  16px;
  --space-5:  20px;
  --space-6:  24px;
  --space-8:  32px;
  --space-10: 40px;
  --space-12: 48px;
  --space-16: 64px;
  --space-20: 80px;
  --space-24: 96px;
}
```

---

## 4. Border Radius

> Redondeado sutil y consistente — no burbujeante.

```css
:root {
  --radius-sm:   6px;    /* Chips, badges, inputs pequeños */
  --radius-md:   10px;   /* Botones, inputs estándar */
  --radius-lg:   14px;   /* Cards, dropdowns */
  --radius-xl:   20px;   /* Modales, paneles laterales */
  --radius-2xl:  28px;   /* Glassmorphism cards destacadas */
  --radius-full: 9999px; /* Avatares, toggles, pills */
}
```

---

## 5. Sombras & Elevación

```css
:root {
  /* Elevación funcional */
  --shadow-sm:   0 1px 3px rgba(3,17,46,0.08), 0 1px 2px rgba(3,17,46,0.06);
  --shadow-md:   0 4px 12px rgba(3,17,46,0.10), 0 2px 6px rgba(3,17,46,0.07);
  --shadow-lg:   0 10px 30px rgba(3,17,46,0.13), 0 4px 10px rgba(3,17,46,0.08);
  --shadow-xl:   0 20px 50px rgba(3,17,46,0.18), 0 8px 16px rgba(3,17,46,0.10);

  /* Sombra de color (botones primarios) */
  --shadow-primary: 0 4px 20px rgba(37,99,235,0.35);
  --shadow-primary-hover: 0 8px 30px rgba(37,99,235,0.45);

  /* Glassmorphism */
  --shadow-glass: 0 8px 32px rgba(3,17,46,0.28), inset 0 1px 0 rgba(255,255,255,0.12);
}
```

---

## 6. Componentes Base

### Botones

```css
/* Base */
.btn {
  font-family: var(--font-sans);
  font-size: var(--text-sm);
  font-weight: var(--weight-medium);
  border-radius: var(--radius-md);
  padding: var(--space-2) var(--space-5);
  border: none;
  cursor: pointer;
  transition: all 0.18s ease;
  letter-spacing: 0.01em;
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
}

/* Primario */
.btn-primary {
  background: var(--color-primary-500);
  color: var(--color-white);
  box-shadow: var(--shadow-primary);
}
.btn-primary:hover {
  background: var(--color-primary-600);
  box-shadow: var(--shadow-primary-hover);
  transform: translateY(-1px);
}
.btn-primary:active { transform: translateY(0); }

/* Secundario (outline) */
.btn-secondary {
  background: transparent;
  color: var(--color-primary-500);
  border: 1.5px solid var(--color-primary-300);
}
.btn-secondary:hover {
  background: var(--color-primary-50);
  border-color: var(--color-primary-500);
}

/* Ghost */
.btn-ghost {
  background: transparent;
  color: var(--color-neutral-600);
}
.btn-ghost:hover {
  background: var(--color-neutral-100);
  color: var(--color-neutral-900);
}

/* Tamaños */
.btn-sm { padding: var(--space-1) var(--space-3); font-size: var(--text-xs); }
.btn-lg { padding: var(--space-3) var(--space-8); font-size: var(--text-base); border-radius: var(--radius-lg); }
```

### Cards

```css
/* Card estándar */
.card {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-md);
  border: 1px solid var(--color-neutral-200);
  padding: var(--space-6);
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}

/* Card Glassmorphism — para widgets sobre fondos oscuros/imagen */
.card-glass {
  background: var(--glass-bg);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  border-radius: var(--radius-xl);
  border: 1px solid var(--glass-border);
  box-shadow: var(--shadow-glass);
  padding: var(--space-6);
  color: var(--color-white);
}

/* Card Glass clara — sobre fondos claros */
.card-glass-light {
  background: var(--glass-bg-light);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  border-radius: var(--radius-xl);
  border: 1px solid var(--glass-border-dark);
  box-shadow: var(--shadow-md);
  padding: var(--space-6);
}

/* KPI / Metric card */
.card-metric {
  background: linear-gradient(135deg, var(--color-primary-600) 0%, var(--color-primary-900) 100%);
  border-radius: var(--radius-xl);
  padding: var(--space-6);
  color: var(--color-white);
  box-shadow: var(--shadow-primary);
  position: relative;
  overflow: hidden;
}
.card-metric::before {
  content: '';
  position: absolute;
  top: -30px; right: -30px;
  width: 120px; height: 120px;
  background: rgba(255,255,255,0.05);
  border-radius: var(--radius-full);
}
```

### Inputs

```css
.input {
  font-family: var(--font-sans);
  font-size: var(--text-sm);
  color: var(--color-neutral-800);
  background: var(--color-white);
  border: 1.5px solid var(--color-neutral-300);
  border-radius: var(--radius-md);
  padding: var(--space-2) var(--space-4);
  width: 100%;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
  outline: none;
}
.input::placeholder { color: var(--color-neutral-400); }
.input:focus {
  border-color: var(--color-primary-400);
  box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}
.input:hover:not(:focus) { border-color: var(--color-neutral-400); }

/* Input glass (buscadores sobre fondo oscuro) */
.input-glass {
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.15);
  color: var(--color-white);
  backdrop-filter: blur(8px);
  border-radius: var(--radius-md);
}
.input-glass::placeholder { color: rgba(255,255,255,0.45); }
.input-glass:focus {
  border-color: var(--color-primary-400);
  box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
}
```

### Badges / Pills

```css
.badge {
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  font-size: var(--text-xs);
  font-weight: var(--weight-medium);
  padding: 2px var(--space-2);
  border-radius: var(--radius-full);
}

.badge-primary { background: var(--color-primary-100); color: var(--color-primary-700); }
.badge-success { background: var(--color-success-100); color: var(--color-success-600); }
.badge-warning { background: var(--color-warning-100); color: var(--color-warning-500); }
.badge-danger  { background: var(--color-danger-100);  color: var(--color-danger-600);  }
.badge-neutral { background: var(--color-neutral-100); color: var(--color-neutral-700); }

/* Badge outline (pipeline stages) */
.badge-outline-primary {
  background: transparent;
  border: 1.5px solid var(--color-primary-300);
  color: var(--color-primary-600);
}
```

### Tabla

```css
.table-crm {
  width: 100%;
  border-collapse: collapse;
  font-size: var(--text-sm);
}
.table-crm thead th {
  font-size: var(--text-xs);
  font-weight: var(--weight-semibold);
  letter-spacing: var(--tracking-widest);
  text-transform: uppercase;
  color: var(--color-neutral-500);
  padding: var(--space-3) var(--space-4);
  border-bottom: 1.5px solid var(--color-neutral-200);
  text-align: left;
  background: var(--color-neutral-50);
}
.table-crm tbody td {
  padding: var(--space-3) var(--space-4);
  color: var(--color-neutral-700);
  border-bottom: 1px solid var(--color-neutral-100);
  vertical-align: middle;
}
.table-crm tbody tr:hover td {
  background: var(--color-primary-50);
}
.table-crm tbody tr.selected td {
  background: var(--color-primary-100);
}
```

---

## 7. Glassmorphism — Reglas de uso

El glassmorphism se aplica con **intención quirúrgica**, no como relleno decorativo.

```css
/* Cuándo usar glass:
   ✅ Widgets flotantes sobre el hero/dashboard header oscuro
   ✅ Modales de confirmación rápida
   ✅ Tooltips enriquecidos
   ✅ Notificaciones toast
   ✅ Panel de ayuda contextual flotante
   ❌ Cards de tabla — usar .card estándar
   ❌ Sidebar principal — usar sólido oscuro
*/

/* Receta glass estándar */
.glass-panel {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(14px) saturate(180%);
  -webkit-backdrop-filter: blur(14px) saturate(180%);
  border: 1px solid rgba(255, 255, 255, 0.14);
  border-radius: var(--radius-xl);
  box-shadow:
    0 8px 32px rgba(3, 17, 46, 0.30),
    inset 0 1px 0 rgba(255, 255, 255, 0.12),
    inset 0 -1px 0 rgba(0, 0, 0, 0.08);
}

/* Toast notification */
.toast-glass {
  background: rgba(6, 29, 74, 0.82);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(37, 99, 235, 0.3);
  border-radius: var(--radius-lg);
  color: var(--color-white);
  padding: var(--space-4) var(--space-5);
  box-shadow: var(--shadow-xl);
  min-width: 300px;
}
```

---

## 8. Layout & Grid

```css
:root {
  --sidebar-width:       240px;
  --sidebar-collapsed:   68px;
  --topbar-height:       60px;
  --content-max-width:   1280px;
  --content-padding:     var(--space-8);
  --card-gap:            var(--space-5);
}

/* Dashboard grid típico */
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: var(--card-gap);
}

/* Columnas comunes */
.col-12 { grid-column: span 12; }   /* Full width */
.col-8  { grid-column: span 8; }    /* Tabla principal */
.col-6  { grid-column: span 6; }    /* 50/50 */
.col-4  { grid-column: span 4; }    /* KPI card */
.col-3  { grid-column: span 3; }    /* Mini widget */

@media (max-width: 1024px) {
  .col-4, .col-3 { grid-column: span 6; }
  .col-8 { grid-column: span 12; }
}
@media (max-width: 640px) {
  .col-4, .col-3, .col-6, .col-8 { grid-column: span 12; }
}
```

---

## 9. Transiciones & Animaciones

```css
:root {
  --duration-fast:   120ms;
  --duration-base:   200ms;
  --duration-slow:   350ms;
  --ease-out:        cubic-bezier(0.16, 1, 0.3, 1);
  --ease-in-out:     cubic-bezier(0.4, 0, 0.2, 1);
  --ease-spring:     cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Hover lift (cards, botones) */
.lift-on-hover {
  transition: transform var(--duration-base) var(--ease-out),
              box-shadow var(--duration-base) var(--ease-out);
}
.lift-on-hover:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
}

/* Fade-in de contenido */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}
.fade-in-up {
  animation: fadeInUp var(--duration-slow) var(--ease-out) both;
}

/* Shimmer skeleton */
@keyframes shimmer {
  0%   { background-position: -400px 0; }
  100% { background-position: 400px 0; }
}
.skeleton {
  background: linear-gradient(90deg,
    var(--color-neutral-200) 25%,
    var(--color-neutral-100) 50%,
    var(--color-neutral-200) 75%
  );
  background-size: 800px 100%;
  animation: shimmer 1.4s infinite;
  border-radius: var(--radius-sm);
}
```

---

## 10. Modo oscuro (Dark Mode)

```css
@media (prefers-color-scheme: dark) {
  :root {
    --color-white: #0f172a;
    --color-neutral-50:  #111827;
    --color-neutral-100: #1f2937;
    --color-neutral-200: #374151;
    --color-neutral-700: #d1d5db;
    --color-neutral-800: #e5e7eb;
    --color-neutral-900: #f9fafb;

    --glass-bg: rgba(10, 20, 50, 0.55);
    --glass-border: rgba(255,255,255,0.08);
    --shadow-glass: 0 8px 32px rgba(0,0,0,0.5);
  }
}

/* Toggle manual con clase .dark en <html> */
html.dark {
  /* Sobreescribir los mismos tokens */
}
```

---

## 11. Checklist de implementación

- [ ] Importar `DM Sans` y `DM Mono` desde Google Fonts
- [ ] Definir todos los tokens CSS en `:root` del archivo global
- [ ] Aplicar `font-family: var(--font-sans)` al `body`
- [ ] Usar **siempre tokens**, nunca valores hardcoded (`#2563eb` → `var(--color-primary-500)`)
- [ ] Glassmorphism solo sobre fondos con suficiente contraste (oscuros o con imagen)
- [ ] Testear `backdrop-filter` en Safari (requiere `-webkit-backdrop-filter`)
- [ ] Validar contraste WCAG AA en textos sobre glass (`≥ 4.5:1`)
- [ ] Añadir `will-change: transform` solo a elementos que realmente animan

---

*Design System — CRM v1.0 · Azul Corporativo · DM Sans · Glassmorphism Contenido*
