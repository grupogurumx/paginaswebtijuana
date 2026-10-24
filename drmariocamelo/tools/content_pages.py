# -*- coding: utf-8 -*-
"""Page content for drmariocamelo.com (EN + ES).

Each entry: key, en{...}, es{...}. Links are root-relative so they work on
any domain. Shortcodes are rendered by the theme.
"""

DISCLAIMER_EN = '<p class="disclaimer">*Results vary from patient to patient. This information is educational and does not replace an individual medical evaluation.</p>'
DISCLAIMER_ES = '<p class="disclaimer">*Los resultados varían en cada paciente. Esta información es educativa y no sustituye una valoración médica individual.</p>'

PAGES = [
    # ------------------------------------------------------------------ HOME
    dict(
        key="home",
        en=dict(
            title="Home", slug="home", template="", order=0,
            subtitle="",
            excerpt="Gastric sleeve and gastric bypass in Tijuana with Dr. Mario Camelo, certified bariatric surgeon with 10,000+ surgeries.",
            seo_title="Bariatric Surgery in Tijuana | Dr. Mario Camelo #SuperDrSleeve",
            seo_desc="Gastric sleeve & gastric bypass in Tijuana with Dr. Mario Camelo, certified bariatric surgeon with 10,000+ surgeries. Free evaluation & financing.",
            focus="bariatric surgery Tijuana",
            content="<!-- The home page layout is rendered by the theme (front-page.php). -->",
        ),
        es=dict(
            title="Inicio", slug="es", template="template-home-es.php", order=0,
            subtitle="",
            excerpt="Manga gástrica y bypass gástrico en Tijuana con el Dr. Mario Camelo, cirujano bariatra certificado con más de 10,000 cirugías.",
            seo_title="Cirugía Bariátrica en Tijuana | Dr. Mario Camelo #SuperDrSleeve",
            seo_desc="Manga gástrica y bypass gástrico en Tijuana con el Dr. Mario Camelo, cirujano bariatra certificado con +10,000 cirugías. Valoración gratis y financiamiento.",
            focus="cirugía bariátrica Tijuana",
            content="<!-- El diseño de esta página lo genera el tema (template-home-es.php). -->",
        ),
    ),
    # ----------------------------------------------------------------- ABOUT
    dict(
        key="about",
        thumb="dr-camelo-quirofano-1.jpg",
        en=dict(
            title="About Dr. Mario Camelo", slug="about-dr-mario-camelo", order=1,
            subtitle="Certified bariatric surgeon. More than 10,000 surgeries. One mission: to help you beat obesity for good.",
            excerpt="Meet Dr. Mario Camelo, #SuperDrSleeve: certified bariatric surgeon in Tijuana with more than 10,000 surgeries and a multidisciplinary team.",
            seo_title="Dr. Mario Camelo | Certified Bariatric Surgeon in Tijuana",
            seo_desc="Meet Dr. Mario Camelo (#SuperDrSleeve), certified bariatric surgeon in Tijuana with 10,000+ surgeries and a multidisciplinary metabolic team.",
            focus="bariatric surgeon Tijuana",
            content="""
<h2>The surgeon behind #SuperDrSleeve</h2>
<p>Dr. Mario Camelo is a certified bariatric surgeon dedicated to bariatric surgery and metabolic medicine in Tijuana, Baja California. With <strong>more than 10,000 surgeries performed</strong>, he has helped patients from across the United States and Mexico take back control of their health.</p>
<p>His approach is simple and demanding at the same time: obesity is a chronic disease, not a lack of willpower. It deserves the same scientific, compassionate and individualized care as diabetes or heart disease.</p>
<img src="/wp-content/themes/drmariocamelo/assets/img/dr-camelo-laparoscopia-2.jpg" alt="Dr. Mario Camelo performing laparoscopic gastric sleeve surgery with his team in Tijuana" width="1440" height="959" loading="lazy">
<h2>A multidisciplinary team for every patient</h2>
<p>Surgery is only one part of the journey. Every patient is supported by a team that may include:</p>
<ul>
<li><strong>Bariatric surgery</strong> — laparoscopic, minimally invasive technique.</li>
<li><strong>Internal medicine and metabolic medicine</strong> — control of diabetes, blood pressure and cholesterol.</li>
<li><strong>Nutrition</strong> — pre-operative diet and staged post-operative nutrition plan.</li>
<li><strong>Psychology</strong> — preparation for the emotional changes of rapid weight loss.</li>
<li><strong>Patient coordination</strong> — bilingual support from your first message to your last follow-up.</li>
</ul>
<h2>Why patients from the U.S. choose Dr. Camelo</h2>
<ul>
<li>Experience backed by more than 10,000 bariatric procedures.</li>
<li>Bilingual care in English and Spanish.</li>
<li>Located in Playas de Tijuana, minutes from the San Diego border.</li>
<li>Transparent, personalized evaluation — every case is individualized.</li>
<li>Patient financing available through a fast online application.</li>
</ul>
<blockquote>“My goal is not that you lose weight for a season. It is that you gain years of healthy life.” — Dr. Mario Camelo</blockquote>
<h2>Follow his work</h2>
<p>Dr. Camelo shares patient education every week on <a href="https://www.instagram.com/superdrsleeve/" target="_blank" rel="noopener">Instagram @superdrsleeve</a> and <a href="https://www.facebook.com/Drmariocamelo/" target="_blank" rel="noopener">Facebook</a>: real information about gallstones, medications for weight loss, supplements and life after surgery.</p>
[dmc_reviews]
""" + DISCLAIMER_EN,
        ),
        es=dict(
            title="Sobre el Dr. Mario Camelo", slug="sobre-el-dr-mario-camelo", order=1,
            subtitle="Cirujano bariatra certificado. Más de 10,000 cirugías. Una misión: ayudarte a vencer la obesidad para siempre.",
            excerpt="Conoce al Dr. Mario Camelo, #SuperDrSleeve: cirujano bariatra certificado en Tijuana con más de 10,000 cirugías y un equipo multidisciplinario.",
            seo_title="Dr. Mario Camelo | Cirujano Bariatra Certificado en Tijuana",
            seo_desc="Conoce al Dr. Mario Camelo (#SuperDrSleeve), cirujano bariatra certificado en Tijuana con +10,000 cirugías y un equipo metabólico multidisciplinario.",
            focus="cirujano bariatra Tijuana",
            content="""
<h2>El cirujano detrás de #SuperDrSleeve</h2>
<p>El Dr. Mario Camelo es cirujano bariatra certificado, dedicado a la cirugía bariátrica y la medicina metabólica en Tijuana, Baja California. Con <strong>más de 10,000 cirugías realizadas</strong>, ha ayudado a pacientes de México y Estados Unidos a recuperar el control de su salud.</p>
<p>Su enfoque es sencillo y exigente a la vez: la obesidad es una enfermedad crónica, no una falta de voluntad. Merece la misma atención científica, humana e individualizada que la diabetes o las enfermedades del corazón.</p>
<img src="/wp-content/themes/drmariocamelo/assets/img/dr-camelo-laparoscopia-2.jpg" alt="Dr. Mario Camelo realizando manga gástrica laparoscópica con su equipo en Tijuana" width="1440" height="959" loading="lazy">
<h2>Un equipo multidisciplinario para cada paciente</h2>
<p>La cirugía es solo una parte del camino. Cada paciente cuenta con un equipo que puede incluir:</p>
<ul>
<li><strong>Cirugía bariátrica</strong>: técnica laparoscópica de mínima invasión.</li>
<li><strong>Medicina interna y metabólica</strong>: control de diabetes, presión arterial y colesterol.</li>
<li><strong>Nutrición</strong>: dieta preoperatoria y plan nutricional por etapas después de la cirugía.</li>
<li><strong>Psicología</strong>: preparación para los cambios emocionales de la pérdida de peso.</li>
<li><strong>Coordinación de pacientes</strong>: atención bilingüe desde tu primer mensaje hasta tu último seguimiento.</li>
</ul>
<h2>Por qué los pacientes eligen al Dr. Camelo</h2>
<ul>
<li>Experiencia respaldada por más de 10,000 procedimientos bariátricos.</li>
<li>Atención en español e inglés.</li>
<li>Ubicado en Playas de Tijuana, a minutos de la frontera con San Diego.</li>
<li>Valoración transparente y personalizada: cada caso se individualiza.</li>
<li>Financiamiento disponible con una solicitud en línea rápida.</li>
</ul>
<blockquote>“Mi objetivo no es que bajes de peso por una temporada. Es que ganes años de vida saludable.” — Dr. Mario Camelo</blockquote>
<h2>Sigue su trabajo</h2>
<p>El Dr. Camelo comparte educación para pacientes cada semana en <a href="https://www.instagram.com/superdrsleeve/" target="_blank" rel="noopener">Instagram @superdrsleeve</a> y <a href="https://www.facebook.com/Drmariocamelo/" target="_blank" rel="noopener">Facebook</a>: información real sobre piedras en la vesícula, medicamentos para bajar de peso, suplementos y la vida después de la cirugía.</p>
[dmc_reviews]
""" + DISCLAIMER_ES,
        ),
    ),
    # ---------------------------------------------------------------- SLEEVE
    dict(
        key="sleeve",
        schema="Sleeve Gastrectomy (Gastric Sleeve)",
        thumb="dr-camelo-quirofano-1.jpg",
        en=dict(
            title="Gastric Sleeve in Tijuana", slug="gastric-sleeve-tijuana", order=2,
            subtitle="The world’s most performed weight-loss surgery, done by the surgeon patients call #SuperDrSleeve.",
            excerpt="Gastric sleeve surgery in Tijuana with Dr. Mario Camelo: candidates, procedure, recovery and expected results (25–30% total body weight loss).",
            seo_title="Gastric Sleeve Tijuana | Sleeve Gastrectomy by Dr. Mario Camelo",
            seo_desc="Gastric sleeve in Tijuana with certified bariatric surgeon Dr. Mario Camelo. 25–30% average total body weight loss, free evaluation and financing.",
            focus="gastric sleeve Tijuana",
            content="""
<h2>What is the gastric sleeve?</h2>
<p>The <strong>sleeve gastrectomy</strong> (gastric sleeve) is a laparoscopic procedure that removes approximately 75–80% of the stomach, leaving a narrow, tube-shaped stomach. It works in two ways:</p>
<ul>
<li><strong>Restriction:</strong> you feel full with much smaller portions.</li>
<li><strong>Hormonal effect:</strong> it reduces ghrelin, the “hunger hormone”, so appetite goes down.</li>
</ul>
<h2>Expected results</h2>
<p>On average, gastric sleeve patients lose approximately <strong>25–30% of their total body weight*</strong>. Many also see improvement in type 2 diabetes, high blood pressure, sleep apnea and joint pain.</p>
<table>
<thead><tr><th></th><th>Gastric Sleeve</th><th>Gastric Bypass</th></tr></thead>
<tbody>
<tr><td>Average total body weight loss*</td><td>25–30%</td><td>30–32%</td></tr>
<tr><td>Technique</td><td>Laparoscopic</td><td>Laparoscopic</td></tr>
<tr><td>Intestinal rerouting</td><td>No</td><td>Yes</td></tr>
<tr><td>Best for</td><td>Most patients, BMI 35–50</td><td>Diabetes, severe reflux, higher BMI</td></tr>
</tbody>
</table>
<h2>Am I a candidate?</h2>
<ul>
<li>BMI of 35 or more, or</li>
<li>BMI of 30–35 with obesity-related conditions (type 2 diabetes, hypertension, sleep apnea), and</li>
<li>No contraindications found during your medical evaluation.</li>
</ul>
<p>If you have severe acid reflux (GERD), the <a href="/gastric-bypass-tijuana/">gastric bypass</a> may be a better option — Dr. Camelo will recommend what fits your case.</p>
<h2>Your journey, step by step</h2>
<ol>
<li><strong>Free online evaluation</strong> — send your height, weight and medical history.</li>
<li><strong>Pre-operative plan</strong> — lab work and a pre-surgery liquid diet to reduce liver size and make surgery safer.</li>
<li><strong>Surgery</strong> — laparoscopic procedure through small incisions.</li>
<li><strong>Recovery</strong> — staged diet (liquids, purées, soft foods, solids) and walking early.</li>
<li><strong>Follow-up</strong> — nutrition, supplements and check-ins so your results last.</li>
</ol>
<h2>Risks you should know</h2>
<p>Every surgery carries risks. With the gastric sleeve they include bleeding, staple-line leak, reflux, nutritional deficiencies and gallstone formation during rapid weight loss. A careful evaluation, an experienced team and disciplined follow-up reduce these risks — and we will discuss them openly with you.</p>
<p>Read more: <a href="/gallstones-after-bariatric-surgery/">Gallstones after bariatric surgery</a> · <a href="/gastric-sleeve-vs-gastric-bypass/">Sleeve vs. bypass</a></p>
[dmc_cta]
""" + DISCLAIMER_EN,
        ),
        es=dict(
            title="Manga Gástrica en Tijuana", slug="manga-gastrica-tijuana", order=2,
            subtitle="La cirugía para bajar de peso más realizada del mundo, en manos del cirujano al que sus pacientes llaman #SuperDrSleeve.",
            excerpt="Manga gástrica en Tijuana con el Dr. Mario Camelo: candidatos, procedimiento, recuperación y resultados esperados (25–30% del peso corporal total).",
            seo_title="Manga Gástrica en Tijuana | Dr. Mario Camelo Cirujano Bariatra",
            seo_desc="Manga gástrica en Tijuana con el Dr. Mario Camelo, cirujano bariatra certificado. Pérdida promedio de 25–30% del peso total. Valoración gratis y financiamiento.",
            focus="manga gástrica Tijuana",
            content="""
<h2>¿Qué es la manga gástrica?</h2>
<p>La <strong>gastrectomía en manga</strong> (manga gástrica) es un procedimiento laparoscópico que retira aproximadamente el 75–80% del estómago y deja un estómago delgado en forma de tubo. Funciona de dos maneras:</p>
<ul>
<li><strong>Restricción:</strong> te sientes satisfecho con porciones mucho más pequeñas.</li>
<li><strong>Efecto hormonal:</strong> disminuye la grelina, la “hormona del hambre”, y con ella el apetito.</li>
</ul>
<h2>Resultados esperados</h2>
<p>En promedio, los pacientes de manga gástrica pierden aproximadamente <strong>entre 25 y 30% de su peso corporal total*</strong>. Muchos también mejoran su diabetes tipo 2, presión arterial, apnea del sueño y dolor articular.</p>
<table>
<thead><tr><th></th><th>Manga gástrica</th><th>Bypass gástrico</th></tr></thead>
<tbody>
<tr><td>Pérdida promedio del peso corporal total*</td><td>25–30%</td><td>30–32%</td></tr>
<tr><td>Técnica</td><td>Laparoscópica</td><td>Laparoscópica</td></tr>
<tr><td>Desvío intestinal</td><td>No</td><td>Sí</td></tr>
<tr><td>Ideal para</td><td>La mayoría de pacientes, IMC 35–50</td><td>Diabetes, reflujo severo, IMC elevado</td></tr>
</tbody>
</table>
<h2>¿Soy candidato?</h2>
<ul>
<li>IMC de 35 o más, o</li>
<li>IMC de 30 a 35 con enfermedades asociadas (diabetes tipo 2, hipertensión, apnea del sueño), y</li>
<li>Sin contraindicaciones en tu valoración médica.</li>
</ul>
<p>Si tienes reflujo severo (ERGE), el <a href="/es/bypass-gastrico-tijuana/">bypass gástrico</a> puede ser una mejor opción; el Dr. Camelo te recomendará lo que mejor se adapte a tu caso.</p>
<h2>Tu proceso, paso a paso</h2>
<ol>
<li><strong>Valoración gratuita en línea</strong>: envía tu estatura, peso e historial médico.</li>
<li><strong>Plan preoperatorio</strong>: estudios de laboratorio y dieta líquida previa para reducir el tamaño del hígado y hacer la cirugía más segura.</li>
<li><strong>Cirugía</strong>: procedimiento laparoscópico con pequeñas incisiones.</li>
<li><strong>Recuperación</strong>: dieta por etapas (líquidos, purés, blandos y sólidos) y caminar desde el inicio.</li>
<li><strong>Seguimiento</strong>: nutrición, suplementos y revisiones para que tus resultados perduren.</li>
</ol>
<h2>Riesgos que debes conocer</h2>
<p>Toda cirugía tiene riesgos. En la manga gástrica incluyen sangrado, fuga en la línea de grapas, reflujo, deficiencias nutricionales y formación de piedras en la vesícula durante la pérdida rápida de peso. Una valoración cuidadosa, un equipo con experiencia y un seguimiento disciplinado reducen estos riesgos, y los hablaremos contigo con total transparencia.</p>
<p>Lee también: <a href="/piedras-en-la-vesicula-y-cirugia-bariatrica/">Piedras en la vesícula y cirugía bariátrica</a> · <a href="/manga-gastrica-vs-bypass-gastrico/">Manga vs. bypass</a></p>
[dmc_cta]
""" + DISCLAIMER_ES,
        ),
    ),
    # ---------------------------------------------------------------- BYPASS
    dict(
        key="bypass",
        schema="Roux-en-Y Gastric Bypass",
        thumb="dr-camelo-laparoscopia-2.jpg",
        en=dict(
            title="Gastric Bypass in Tijuana", slug="gastric-bypass-tijuana", order=3,
            subtitle="The gold standard for type 2 diabetes, severe reflux and higher BMI — with 30–32% average total body weight loss.",
            excerpt="Roux-en-Y gastric bypass in Tijuana with Dr. Mario Camelo: how it works, who it is for, results and recovery.",
            seo_title="Gastric Bypass Tijuana | Roux-en-Y by Dr. Mario Camelo",
            seo_desc="Gastric bypass in Tijuana with certified bariatric surgeon Dr. Mario Camelo. Ideal for type 2 diabetes and reflux. 30–32% average total weight loss.",
            focus="gastric bypass Tijuana",
            content="""
<h2>What is the gastric bypass?</h2>
<p>The <strong>Roux-en-Y gastric bypass</strong> creates a small stomach pouch and connects it directly to the small intestine, bypassing most of the stomach and the first part of the intestine. It combines restriction, reduced absorption and powerful hormonal changes.</p>
<h2>Who benefits most</h2>
<ul>
<li>Patients with <strong>type 2 diabetes</strong> — bypass has a strong metabolic effect on blood sugar.</li>
<li>Patients with <strong>severe acid reflux (GERD)</strong> or a hiatal hernia.</li>
<li>Patients with a <strong>higher BMI</strong> who need greater weight loss.</li>
<li>Patients with weight regain or reflux after a previous sleeve (see <a href="/revision-bariatric-surgery/">revision surgery</a>).</li>
</ul>
<h2>Expected results</h2>
<p>On average, gastric bypass patients lose approximately <strong>30–32% of their total body weight*</strong>, with frequent improvement or remission of diabetes, hypertension and sleep apnea.</p>
<h2>Life after bypass</h2>
<p>Because absorption changes, lifelong vitamin and mineral supplementation and periodic lab work are essential. Our nutrition team will give you a clear plan, and we will teach you to avoid “dumping syndrome” by limiting sugars and eating slowly.</p>
<h2>Risks</h2>
<p>As with any surgery, there are risks: bleeding, leaks, marginal ulcers, internal hernias, nutritional deficiencies and gallstones. Our evaluation and follow-up protocol is designed to reduce them, and we explain them openly before you decide.</p>
<p>Compare options: <a href="/gastric-sleeve-vs-gastric-bypass/">Gastric sleeve vs. gastric bypass</a></p>
[dmc_cta]
""" + DISCLAIMER_EN,
        ),
        es=dict(
            title="Bypass Gástrico en Tijuana", slug="bypass-gastrico-tijuana", order=3,
            subtitle="El estándar de oro para diabetes tipo 2, reflujo severo e IMC elevado, con una pérdida promedio de 30–32% del peso total.",
            excerpt="Bypass gástrico en Y de Roux en Tijuana con el Dr. Mario Camelo: cómo funciona, para quién es, resultados y recuperación.",
            seo_title="Bypass Gástrico en Tijuana | Dr. Mario Camelo",
            seo_desc="Bypass gástrico en Tijuana con el Dr. Mario Camelo, cirujano bariatra certificado. Ideal para diabetes tipo 2 y reflujo. Pérdida promedio de 30–32%.",
            focus="bypass gástrico Tijuana",
            content="""
<h2>¿Qué es el bypass gástrico?</h2>
<p>El <strong>bypass gástrico en Y de Roux</strong> crea un pequeño reservorio gástrico y lo conecta directamente al intestino delgado, desviando la mayor parte del estómago y la primera porción del intestino. Combina restricción, menor absorción y potentes cambios hormonales.</p>
<h2>¿Quién se beneficia más?</h2>
<ul>
<li>Pacientes con <strong>diabetes tipo 2</strong>: el bypass tiene un fuerte efecto metabólico sobre la glucosa.</li>
<li>Pacientes con <strong>reflujo severo (ERGE)</strong> o hernia hiatal.</li>
<li>Pacientes con <strong>IMC elevado</strong> que necesitan una mayor pérdida de peso.</li>
<li>Pacientes con reganancia de peso o reflujo después de una manga (ver <a href="/es/cirugia-de-revision/">cirugía de revisión</a>).</li>
</ul>
<h2>Resultados esperados</h2>
<p>En promedio, los pacientes de bypass gástrico pierden aproximadamente <strong>entre 30 y 32% de su peso corporal total*</strong>, con mejoría o remisión frecuente de diabetes, hipertensión y apnea del sueño.</p>
<h2>La vida después del bypass</h2>
<p>Como cambia la absorción, es indispensable tomar vitaminas y minerales de por vida y realizar estudios periódicos. Nuestro equipo de nutrición te dará un plan claro y te enseñará a evitar el “síndrome de dumping” limitando azúcares y comiendo despacio.</p>
<h2>Riesgos</h2>
<p>Como en toda cirugía, existen riesgos: sangrado, fugas, úlceras marginales, hernias internas, deficiencias nutricionales y piedras en la vesícula. Nuestro protocolo de valoración y seguimiento está diseñado para reducirlos, y te los explicamos con claridad antes de que decidas.</p>
<p>Compara opciones: <a href="/manga-gastrica-vs-bypass-gastrico/">Manga gástrica vs. bypass gástrico</a></p>
[dmc_cta]
""" + DISCLAIMER_ES,
        ),
    ),
    # -------------------------------------------------------------- REVISION
    dict(
        key="revision",
        schema="Revision Bariatric Surgery",
        en=dict(
            title="Revision Bariatric Surgery", slug="revision-bariatric-surgery", order=4,
            subtitle="Weight regain or reflux after a previous surgery? You still have options.",
            excerpt="Revision bariatric surgery in Tijuana: sleeve to bypass and band to sleeve or bypass conversions, evaluated individually by Dr. Mario Camelo.",
            seo_title="Revision Bariatric Surgery Tijuana | Sleeve to Bypass",
            seo_desc="Weight regain or reflux after gastric sleeve or lap band? Revision bariatric surgery in Tijuana with Dr. Mario Camelo. Individual evaluation.",
            focus="revision bariatric surgery Tijuana",
            content="""
<h2>When is revision surgery considered?</h2>
<ul>
<li><strong>Weight regain</strong> after gastric sleeve or gastric band.</li>
<li><strong>Severe reflux (GERD)</strong> after a sleeve that does not respond to medication.</li>
<li><strong>Band complications</strong>: slippage, erosion, intolerance or insufficient weight loss.</li>
</ul>
<h2>Common revision procedures</h2>
<ul>
<li><strong>Sleeve to gastric bypass</strong> — the most frequent conversion, especially for reflux.</li>
<li><strong>Lap band removal and conversion</strong> to sleeve or bypass.</li>
</ul>
<h2>A careful, individualized evaluation</h2>
<p>Revision surgery is more complex than a first procedure. Before any recommendation we review your previous operative notes and studies (endoscopy or imaging when needed), your eating habits and your metabolic health. Sometimes the best answer is not surgery but a structured metabolic and nutrition program — and we will tell you honestly.</p>
<p>Related: <a href="/gastric-bypass-tijuana/">Gastric bypass</a> · <a href="/metabolic-medicine/">Metabolic medicine</a></p>
[dmc_cta]
""" + DISCLAIMER_EN,
        ),
        es=dict(
            title="Cirugía de Revisión Bariátrica", slug="cirugia-de-revision", order=4,
            subtitle="¿Reganancia de peso o reflujo después de una cirugía previa? Todavía tienes opciones.",
            excerpt="Cirugía de revisión bariátrica en Tijuana: conversión de manga a bypass y de banda a manga o bypass, con valoración individual del Dr. Mario Camelo.",
            seo_title="Cirugía de Revisión Bariátrica en Tijuana | Manga a Bypass",
            seo_desc="¿Reganancia de peso o reflujo tras manga gástrica o banda? Cirugía de revisión bariátrica en Tijuana con el Dr. Mario Camelo. Valoración individual.",
            focus="cirugía de revisión bariátrica",
            content="""
<h2>¿Cuándo se considera una cirugía de revisión?</h2>
<ul>
<li><strong>Reganancia de peso</strong> después de manga o banda gástrica.</li>
<li><strong>Reflujo severo (ERGE)</strong> después de una manga que no responde a medicamentos.</li>
<li><strong>Complicaciones de banda</strong>: deslizamiento, erosión, intolerancia o pérdida de peso insuficiente.</li>
</ul>
<h2>Procedimientos de revisión más comunes</h2>
<ul>
<li><strong>Conversión de manga a bypass gástrico</strong>: la más frecuente, sobre todo por reflujo.</li>
<li><strong>Retiro de banda y conversión</strong> a manga o bypass.</li>
</ul>
<h2>Una valoración cuidadosa e individual</h2>
<p>La cirugía de revisión es más compleja que un primer procedimiento. Antes de cualquier recomendación revisamos tus notas quirúrgicas y estudios previos (endoscopia o imagen cuando se requiere), tus hábitos de alimentación y tu salud metabólica. A veces la mejor respuesta no es cirugía sino un programa metabólico y nutricional estructurado, y te lo diremos con honestidad.</p>
<p>Relacionado: <a href="/es/bypass-gastrico-tijuana/">Bypass gástrico</a> · <a href="/es/medicina-metabolica/">Medicina metabólica</a></p>
[dmc_cta]
""" + DISCLAIMER_ES,
        ),
    ),
    # ------------------------------------------------------------- METABOLIC
    dict(
        key="metabolic",
        thumb="blog-riesgos-automedicacion.jpg",
        en=dict(
            title="Metabolic Medicine", slug="metabolic-medicine", order=5,
            subtitle="Treating obesity and its comorbidities with science — with or without surgery.",
            excerpt="Metabolic medicine with Dr. Mario Camelo: medical treatment of obesity, type 2 diabetes and metabolic syndrome, including supervised GLP-1 therapy when indicated.",
            seo_title="Metabolic Medicine & Medical Weight Loss | Dr. Mario Camelo",
            seo_desc="Medical treatment of obesity, diabetes and metabolic syndrome in Tijuana. Supervised GLP-1 therapy when indicated. Do not self-medicate — get evaluated.",
            focus="metabolic medicine obesity",
            content="""
<h2>Obesity is a chronic disease</h2>
<p>Obesity rarely travels alone. It is closely linked to <strong>type 2 diabetes, hypertension, high cholesterol, fatty liver, sleep apnea, joint disease and some cancers</strong>. Our metabolic medicine program treats the whole picture, not just the number on the scale.</p>
<h2>What the program includes</h2>
<ul>
<li>Complete metabolic evaluation and lab work.</li>
<li>Personalized nutrition and physical activity plan.</li>
<li>Medical treatment of diabetes, blood pressure and cholesterol.</li>
<li>Anti-obesity medication — including GLP-1 therapy — <strong>only when indicated and under medical supervision</strong>.</li>
<li>Pre- and post-bariatric surgery metabolic follow-up.</li>
</ul>
<h2>Please do not self-medicate</h2>
<p>Weight-loss medications can cause nausea and vomiting, diarrhea and abdominal pain, dehydration, pancreas and gallbladder problems and changes in blood pressure. The same caution applies to vitamins, supplements, protein and creatine: self-medication can be dangerous and they are not always necessary.</p>
<ul>
<li>Do not copy treatments from social media, friends or family.</li>
<li>Do not use medications or supplements without medical supervision.</li>
<li>Every person has different needs and a unique health context.</li>
</ul>
<p><strong>The best decision is to see a specialist.</strong> A proper evaluation can make the difference between getting a benefit and putting your health at risk. Read: <a href="/weight-loss-medications-self-medication-risks/">The risks of self-medicating for weight loss</a>.</p>
[dmc_cta]
""" + DISCLAIMER_EN,
        ),
        es=dict(
            title="Medicina Metabólica", slug="medicina-metabolica", order=5,
            subtitle="Tratamos la obesidad y sus comorbilidades con ciencia, con o sin cirugía.",
            excerpt="Medicina metabólica con el Dr. Mario Camelo: tratamiento médico de la obesidad, diabetes tipo 2 y síndrome metabólico, con terapia GLP-1 supervisada cuando está indicada.",
            seo_title="Medicina Metabólica y Tratamiento de la Obesidad | Dr. Camelo",
            seo_desc="Tratamiento médico de la obesidad, diabetes y síndrome metabólico en Tijuana. Terapia GLP-1 supervisada cuando está indicada. No te automediques.",
            focus="medicina metabólica obesidad",
            content="""
<h2>La obesidad es una enfermedad crónica</h2>
<p>La obesidad rara vez llega sola. Se relaciona con <strong>diabetes tipo 2, hipertensión, colesterol alto, hígado graso, apnea del sueño, enfermedad articular y algunos tipos de cáncer</strong>. Nuestro programa de medicina metabólica atiende el panorama completo, no solo el número en la báscula.</p>
<h2>Qué incluye el programa</h2>
<ul>
<li>Valoración metabólica completa y estudios de laboratorio.</li>
<li>Plan personalizado de nutrición y actividad física.</li>
<li>Tratamiento médico de diabetes, presión arterial y colesterol.</li>
<li>Medicamentos para la obesidad, incluyendo terapia GLP-1, <strong>solo cuando están indicados y bajo supervisión médica</strong>.</li>
<li>Seguimiento metabólico antes y después de la cirugía bariátrica.</li>
</ul>
<h2>Por favor, no te automediques</h2>
<p>Los medicamentos para bajar de peso pueden causar náuseas y vómito, diarrea y dolor abdominal, deshidratación, problemas en el páncreas, alteraciones en la vesícula y cambios en la presión arterial. Lo mismo aplica a vitaminas, suplementos, proteína y creatina: la automedicación puede ser peligrosa para tu salud y no siempre son necesarios.</p>
<ul>
<li>No copies tratamientos de redes sociales, amigos o familiares.</li>
<li>No uses medicamentos o suplementos sin supervisión médica.</li>
<li>Cada persona tiene necesidades diferentes y un contexto de salud único.</li>
</ul>
<p><strong>Lo mejor es acudir con un especialista.</strong> Una valoración adecuada puede hacer la diferencia entre obtener un beneficio y poner en riesgo tu salud. Lee: <a href="/riesgos-de-automedicarse-para-bajar-de-peso/">Los riesgos de automedicarse para bajar de peso</a>.</p>
[dmc_cta]
""" + DISCLAIMER_ES,
        ),
    ),
    # ------------------------------------------------------------- FINANCING
    dict(
        key="financing",
        en=dict(
            title="Bariatric Surgery Financing", slug="financing", order=6,
            subtitle="Start your transformation today with a payment plan that fits your budget.",
            excerpt="Apply for bariatric surgery financing with Dr. Mario Camelo. Fast, secure online application for gastric sleeve and gastric bypass.",
            seo_title="Bariatric Surgery Financing | Gastric Sleeve Payment Plans",
            seo_desc="Finance your gastric sleeve or gastric bypass in Tijuana. Fast, secure online application with Dr. Mario Camelo's team. Apply in minutes.",
            focus="bariatric surgery financing",
            content="""
[dmc_financing]
<h2>How it works</h2>
<ol>
<li><strong>Complete the application</strong> — it only takes a few minutes.</li>
<li><strong>Our team reviews it</strong> and contacts you with the available options.</li>
<li><strong>Schedule your surgery</strong> with a plan that fits your budget.</li>
</ol>
<p>Questions about financing? Use the form below or message us on WhatsApp and a coordinator will help you.</p>
""",
        ),
        es=dict(
            title="Financiamiento para Cirugía Bariátrica", slug="financiamiento", order=6,
            subtitle="Comienza hoy tu transformación con un plan de pagos que se adapta a tu presupuesto.",
            excerpt="Solicita financiamiento para tu cirugía bariátrica con el Dr. Mario Camelo. Solicitud en línea rápida y segura para manga gástrica y bypass.",
            seo_title="Financiamiento Cirugía Bariátrica | Manga Gástrica a Pagos",
            seo_desc="Financia tu manga gástrica o bypass gástrico en Tijuana. Solicitud en línea rápida y segura con el equipo del Dr. Mario Camelo.",
            focus="financiamiento cirugía bariátrica",
            content="""
[dmc_financing]
<h2>Cómo funciona</h2>
<ol>
<li><strong>Completa la solicitud</strong>: toma solo unos minutos.</li>
<li><strong>Nuestro equipo la revisa</strong> y te contacta con las opciones disponibles.</li>
<li><strong>Agenda tu cirugía</strong> con un plan que se adapta a tu presupuesto.</li>
</ol>
<p>¿Dudas sobre el financiamiento? Usa el formulario o escríbenos por WhatsApp y un coordinador te ayudará.</p>
""",
        ),
    ),
    # --------------------------------------------------------------- REVIEWS
    dict(
        key="reviews",
        en=dict(
            title="Patient Reviews", slug="reviews", order=7,
            subtitle="Real stories from real patients of Dr. Mario Camelo.",
            excerpt="Read reviews from patients of Dr. Mario Camelo, certified bariatric surgeon in Tijuana.",
            seo_title="Patient Reviews | Dr. Mario Camelo Bariatric Surgery",
            seo_desc="Read real Google reviews from patients of Dr. Mario Camelo, certified bariatric surgeon in Tijuana with 10,000+ surgeries.",
            focus="Dr. Mario Camelo reviews",
            content="""
<p>Our patients’ experiences are our best introduction. Read their reviews on Google and follow their transformations on our social media.</p>
[dmc_reviews]
<p class="center"><a class="btn btn--navy" href="https://www.instagram.com/superdrsleeve/" target="_blank" rel="noopener">@superdrsleeve on Instagram</a></p>
""",
        ),
        es=dict(
            title="Testimonios de Pacientes", slug="testimonios", order=7,
            subtitle="Historias reales de pacientes reales del Dr. Mario Camelo.",
            excerpt="Lee las reseñas de pacientes del Dr. Mario Camelo, cirujano bariatra certificado en Tijuana.",
            seo_title="Testimonios de Pacientes | Dr. Mario Camelo Cirugía Bariátrica",
            seo_desc="Lee reseñas reales en Google de pacientes del Dr. Mario Camelo, cirujano bariatra certificado en Tijuana con más de 10,000 cirugías.",
            focus="Dr. Mario Camelo opiniones",
            content="""
<p>La experiencia de nuestros pacientes es nuestra mejor carta de presentación. Lee sus reseñas en Google y sigue sus transformaciones en nuestras redes sociales.</p>
[dmc_reviews]
<p class="center"><a class="btn btn--navy" href="https://www.instagram.com/superdrsleeve/" target="_blank" rel="noopener">@superdrsleeve en Instagram</a></p>
""",
        ),
    ),
    # --------------------------------------------------------------- CONTACT
    dict(
        key="contact",
        en=dict(
            title="Contact & Free Evaluation", slug="contact", order=8,
            subtitle="Tell us about your goals. Your free evaluation starts here.",
            excerpt="Contact Dr. Mario Camelo's team in Playas de Tijuana for a free bariatric surgery evaluation.",
            seo_title="Contact Dr. Mario Camelo | Free Bariatric Evaluation Tijuana",
            seo_desc="Schedule your free bariatric surgery evaluation with Dr. Mario Camelo in Playas de Tijuana, minutes from San Diego. Bilingual team.",
            focus="free bariatric evaluation",
            content="""
[dmc_cta]
<h2>Visit our office</h2>
<p>Paseo Playas de Tijuana No. 19, Terrazas de Playas, Tijuana, B.C. 22504, Mexico<br>Monday to Friday, 9:00 a.m. – 6:00 p.m.</p>
<iframe src="https://www.google.com/maps?q=Paseo+Playas+de+Tijuana+19,+Playas+de+Tijuana,+22504+Tijuana,+B.C.&output=embed" width="100%" height="420" style="border:0;border-radius:22px" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map — Dr. Mario Camelo"></iframe>
""",
        ),
        es=dict(
            title="Contacto y Valoración Gratuita", slug="contacto", order=8,
            subtitle="Cuéntanos tus objetivos. Tu valoración gratuita empieza aquí.",
            excerpt="Contacta al equipo del Dr. Mario Camelo en Playas de Tijuana para una valoración bariátrica gratuita.",
            seo_title="Contacto Dr. Mario Camelo | Valoración Bariátrica Gratis",
            seo_desc="Agenda tu valoración gratuita de cirugía bariátrica con el Dr. Mario Camelo en Playas de Tijuana. Equipo bilingüe.",
            focus="valoración bariátrica gratis",
            content="""
[dmc_cta]
<h2>Visita nuestro consultorio</h2>
<p>Paseo Playas de Tijuana No. 19, Terrazas de Playas, Tijuana, B.C. 22504, México<br>Lunes a viernes, 9:00 a 18:00 h.</p>
<iframe src="https://www.google.com/maps?q=Paseo+Playas+de+Tijuana+19,+Playas+de+Tijuana,+22504+Tijuana,+B.C.&output=embed" width="100%" height="420" style="border:0;border-radius:22px" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa — Dr. Mario Camelo"></iframe>
""",
        ),
    ),
    # ------------------------------------------------------------------ BLOG
    dict(
        key="blog",
        en=dict(
            title="Bariatric Health Blog", slug="blog", order=9, subtitle="",
            excerpt="Bariatric surgery and metabolic health articles by Dr. Mario Camelo.",
            seo_title="Bariatric Surgery Blog | Dr. Mario Camelo",
            seo_desc="Expert articles on gastric sleeve, gastric bypass, gallstones, weight-loss medications and metabolic health by Dr. Mario Camelo.",
            focus="bariatric surgery blog",
            content="",
        ),
        es=dict(
            title="Blog de Salud Bariátrica", slug="blog", order=9, subtitle="", template="template-blog-es.php",
            excerpt="Artículos de cirugía bariátrica y salud metabólica del Dr. Mario Camelo.",
            seo_title="Blog de Cirugía Bariátrica | Dr. Mario Camelo",
            seo_desc="Artículos expertos sobre manga gástrica, bypass, piedras en la vesícula, medicamentos para bajar de peso y salud metabólica por el Dr. Mario Camelo.",
            focus="blog cirugía bariátrica",
            content="",
        ),
    ),
    # --------------------------------------------------------------- PRIVACY
    dict(
        key="privacy",
        en=dict(
            title="Privacy Policy", slug="privacy", order=10,
            subtitle="How we protect your personal and health information.",
            excerpt="Privacy policy of drmariocamelo.com.",
            seo_title="Privacy Policy | Dr. Mario Camelo",
            seo_desc="Privacy policy of drmariocamelo.com: how we collect, use and protect your personal and health information.",
            focus="privacy policy",
            noindex=True,
            content="""
<p><em>Template — have it reviewed by your legal advisor before publishing.</em></p>
<h2>Who is responsible for your data</h2>
<p>Dr. Mario Camelo, with offices at Paseo Playas de Tijuana No. 19, Terrazas de Playas, Tijuana, B.C. 22504, Mexico, is responsible for the processing of your personal data in accordance with Mexico’s Federal Law on the Protection of Personal Data Held by Private Parties (LFPDPPP).</p>
<h2>Data we collect</h2>
<p>Identification and contact data (name, email, phone), and health data you voluntarily share (height, weight, medical history) to evaluate your candidacy for treatment.</p>
<h2>Purposes</h2>
<ul><li>Evaluate your case and contact you about the services you requested.</li><li>Coordinate appointments, surgery logistics and follow-up.</li><li>Process financing applications through our partners when you request it.</li></ul>
<h2>Third parties</h2>
<p>Financing applications are processed through Typeform and the corresponding financing provider. We do not sell your data.</p>
<h2>Your rights (ARCO)</h2>
<p>You may access, rectify, cancel or oppose the use of your data by writing to our contact email.</p>
<h2>Cookies and analytics</h2>
<p>This site may use cookies and analytics tools (Google Analytics, Meta Pixel) to improve your experience and measure our campaigns.</p>
""",
        ),
        es=dict(
            title="Aviso de Privacidad", slug="aviso-de-privacidad", order=10,
            subtitle="Cómo protegemos tus datos personales y de salud.",
            excerpt="Aviso de privacidad de drmariocamelo.com.",
            seo_title="Aviso de Privacidad | Dr. Mario Camelo",
            seo_desc="Aviso de privacidad de drmariocamelo.com: cómo recabamos, usamos y protegemos tus datos personales y de salud.",
            focus="aviso de privacidad",
            noindex=True,
            content="""
<p><em>Plantilla: solicita la revisión de tu asesor legal antes de publicar.</em></p>
<h2>Responsable de tus datos</h2>
<p>El Dr. Mario Camelo, con domicilio en Paseo Playas de Tijuana No. 19, Terrazas de Playas, Tijuana, B.C. 22504, México, es responsable del tratamiento de tus datos personales conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP).</p>
<h2>Datos que recabamos</h2>
<p>Datos de identificación y contacto (nombre, correo, teléfono) y datos de salud que compartes voluntariamente (estatura, peso, antecedentes médicos) para valorar tu caso. Los datos de salud se consideran sensibles y requieren tu consentimiento expreso.</p>
<h2>Finalidades</h2>
<ul><li>Valorar tu caso y contactarte sobre los servicios que solicitaste.</li><li>Coordinar citas, logística quirúrgica y seguimiento.</li><li>Gestionar solicitudes de financiamiento con nuestros aliados cuando lo solicites.</li></ul>
<h2>Transferencias</h2>
<p>Las solicitudes de financiamiento se procesan mediante Typeform y el proveedor de financiamiento correspondiente. No vendemos tus datos.</p>
<h2>Derechos ARCO</h2>
<p>Puedes acceder, rectificar, cancelar u oponerte al uso de tus datos escribiendo a nuestro correo de contacto.</p>
<h2>Cookies y analítica</h2>
<p>Este sitio puede utilizar cookies y herramientas de analítica (Google Analytics, Meta Pixel) para mejorar tu experiencia y medir nuestras campañas.</p>
""",
        ),
    ),
]
