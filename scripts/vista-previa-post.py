import os, re, sys
root = sys.argv[1]
src = sys.argv[2] if len(sys.argv) > 2 else 'http://localhost:8080'
# 1. Renombrar archivos con ?ver=
for d, _, fs in os.walk(root):
    for f in fs:
        if '?ver=' in f:
            new = re.sub(r'\?ver=[^/]*$', '', f)
            os.rename(os.path.join(d, f), os.path.join(d, new))
WA = 'https://wa.me/526644097979'
SCRIPT = """<script>
/* Vista previa estática: sin servidor PHP, el formulario abre WhatsApp con los datos. */
document.querySelectorAll('form.form').forEach(function (f) {
  f.addEventListener('submit', function (e) {
    e.preventDefault();
    var g = function (n) { var el = f.querySelector('[name="' + n + '"]'); return el ? el.value.trim() : ''; };
    var t = 'Hola, quiero una cotización.\\nNombre: ' + g('wmt_nombre') + '\\nTeléfono: ' + g('wmt_telefono') +
      '\\nCorreo: ' + g('wmt_email') + '\\nServicio: ' + g('wmt_servicio') + '\\nProyecto: ' + g('wmt_mensaje');
    window.open('""" + WA + """?text=' + encodeURIComponent(t), '_blank', 'noopener');
  });
});
</script>
"""
for d, _, fs in os.walk(root):
    for f in fs:
        p = os.path.join(d, f)
        if not f.endswith(('.html', '.css', '.js')):
            continue
        s = open(p, encoding='utf-8').read()
        s = s.replace(src, '').replace(src.replace('/', '\\/'), '')
        s = re.sub(r'\?ver=[0-9.]+', '', s)
        if f.endswith('.html'):
            s = re.sub(r'<link rel="(https://api\.w\.org/|alternate|EditURI|shortlink)"[^>]*>\n?', '', s)
            s = s.replace('action="/wp-admin/admin-post.php"', 'action="#"')
            s = s.replace('<meta name="viewport"', '<meta name="robots" content="noindex, nofollow">\n\t<meta name="viewport"', 1)
            if 'class="form"' in s:
                s = s.replace('</body>', SCRIPT + '</body>')
            # href vacío al inicio
            s = s.replace('href=""', 'href="/"')
        open(p, 'w', encoding='utf-8').write(s)
