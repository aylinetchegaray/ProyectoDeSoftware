# Fonts Directory / Directorio de Fuentes

This directory is designated for web fonts and typography resources for the NexusCore Software corporate portal.

## Active Typography Stack

1. **Heading Display Font**:
   - **Outfit** (Weights: 400, 500, 600, 700, 800)
   - Fallbacks: `'Inter'`, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif.

2. **Body & Interface Font**:
   - **Plus Jakarta Sans** / **Inter** (Weights: 300, 400, 500, 600, 700)
   - Fallbacks: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif.

3. **Code & Technical Badges**:
   - **JetBrains Mono** / **Fira Code**
   - Fallbacks: 'SF Mono', Consolas, Menlo, monospace.

Web-optimized fonts are imported in `css/variables.css` using modern `@import` and `font-display: swap` for maximum performance, with local fallback declarations.
