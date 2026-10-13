<?php
/**
 * Contenido inicial: se crea una sola vez al activar el tema.
 *
 * Si usted va a importar el archivo .xml (WXR), este contenido no se duplica:
 * la siembra sólo se ejecuta cuando no existe ningún procedimiento publicado.
 *
 * ARCHIVO GENERADO. Para modificarlo, edite gen_wp.py y vuelva a ejecutarlo.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Datos de los ocho procedimientos.
 *
 * @return array
 */
function cardio_seed_data() {
	return array(
		array(
			'slug'     => 'ecocardiograma-doppler-color',
			'titulo'   => 'Ecocardiograma + Doppler color',
			'orden'    => 1,
			'imagen'   => 'proc-ecocardiograma.jpg',
			'extracto' => 'Ecocardiograma Doppler color en Tijuana realizado e interpretado por el Dr. Eduardo Canseco, certificado en ecocardiografía. Resultado el mismo día.',
			'contenido' => '<p>El ecocardiograma con Doppler color es una herramienta de diagnóstico fundamental que utiliza ultrasonido para crear una imagen detallada y en tiempo real de su corazón. Permite evaluar la estructura del corazón, analizar su funcionamiento y observar el movimiento de las válvulas y del músculo cardíaco.</p>
<p>El sistema Doppler añade información vital al analizar y visualizar el flujo de la sangre a través de las cavidades y de los vasos principales del corazón. Con ese mapa de color es posible identificar si una válvula deja escapar sangre, si está estrechada o si existen comunicaciones anormales entre cavidades.</p>
<p>Es un estudio no invasivo, sin radiación y sin necesidad de inyecciones. En el consultorio lo realiza e interpreta directamente el Dr. Canseco, certificado en ecocardiografía clínica por el Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-ecocardiograma.jpg',
				'_cardio_lead'     => 'El estudio que permite ver el corazón latiendo en tiempo real: sus cavidades, sus válvulas, la fuerza con la que bombea y el flujo de sangre que lo atraviesa.',
				'_cardio_duracion' => '20 a 40 minutos',
				'_cardio_indica'   => 'Soplo cardíaco detectado en una exploración
Falta de aire, fatiga o hinchazón de piernas de origen no aclarado
Sospecha o seguimiento de insuficiencia cardíaca
Valvulopatías: estenosis o insuficiencia de válvulas
Control después de un infarto para valorar la función del ventrículo
Hipertensión arterial de larga evolución
Valoración previa a una cirugía',
				'_cardio_como'     => 'Usted se recuesta sobre el lado izquierdo en la camilla, con el tórax descubierto.
Se aplica un gel conductor y se desliza el transductor sobre distintos puntos del pecho.
Se obtienen imágenes desde varias ventanas acústicas y se registran las mediciones.
Puede pedírsele que contenga la respiración unos segundos para mejorar la imagen.',
				'_cardio_prep'     => 'No requiere ayuno ni preparación especial.
Continúe con sus medicamentos habituales salvo indicación distinta.
Use ropa cómoda y de fácil apertura en el tórax.
Lleve sus estudios cardiológicos previos si los tiene.',
				'_cardio_faq'      => '¿El ecocardiograma duele o tiene riesgos?
No. Es un estudio de ultrasonido, igual que el que se usa en el embarazo: no emplea radiación ni requiere inyecciones. Lo único que puede sentir es la presión del transductor sobre el pecho y la sensación fría del gel.

¿Cuál es la diferencia entre un electrocardiograma y un ecocardiograma?
El electrocardiograma registra la actividad <strong>eléctrica</strong> del corazón mediante electrodos en la piel. El ecocardiograma muestra la <strong>anatomía y el movimiento</strong> del corazón mediante ultrasonido. Son estudios complementarios: uno no sustituye al otro.

¿Cuándo entregan el resultado?
La interpretación se realiza durante la misma consulta. Usted sale del consultorio conociendo el hallazgo y el plan a seguir, con su reporte correspondiente.

¿Necesito una orden médica para hacerme el estudio?
Puede acudir directamente a consulta. En la valoración se define si el ecocardiograma es el estudio indicado para su caso o si conviene otro abordaje.',
			),
		),
		array(
			'slug'     => 'electrocardiograma',
			'titulo'   => 'Electrocardiograma',
			'orden'    => 2,
			'imagen'   => 'proc-electrocardiograma.jpg',
			'extracto' => 'Electrocardiograma en Tijuana con interpretación por cardiólogo el mismo día. Estudio no invasivo, sin molestias ni preparación previa.',
			'contenido' => '<p>El electrocardiograma (ECG) es un examen fundamental y no invasivo que registra la actividad eléctrica de su corazón. Se colocan pequeños parches adhesivos en puntos específicos del tórax, los brazos y las piernas para capturar los datos del ritmo cardíaco.</p>
<p>Este estudio permite identificar problemas como arritmias e indicios de ataques cardíacos previos o en curso, además de alteraciones de la conducción eléctrica, crecimiento de las cavidades y efectos de ciertos medicamentos o alteraciones de los electrolitos.</p>
<p>No causa molestias físicas, no demanda preparativos complicados y sólo requiere que el paciente se encuentre relajado durante el registro. El objetivo es que el Dr. Canseco obtenga un análisis claro del estado de su salud cardiovascular, un primer paso importante en la evaluación cardíaca.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-electrocardiograma.jpg',
				'_cardio_lead'     => 'El primer paso de casi toda evaluación cardíaca: diez minutos que revelan el ritmo, la conducción eléctrica y las huellas que deja un infarto.',
				'_cardio_duracion' => '10 minutos',
				'_cardio_indica'   => 'Dolor o presión en el pecho
Palpitaciones o sensación de latidos irregulares
Mareo, desmayo o pérdida del conocimiento
Control de hipertensión, diabetes o colesterol alto
Chequeo cardiológico de rutina a partir de los 40 años
Requisito previo a una cirugía o a un programa de ejercicio',
				'_cardio_como'     => 'Se recuesta en la camilla con el tórax, los tobillos y las muñecas descubiertos.
Se colocan diez electrodos adhesivos en posiciones estandarizadas.
El equipo registra el trazo durante unos segundos mientras usted permanece quieto y respira con normalidad.
Se retiran los electrodos y el Dr. Canseco interpreta el trazo enseguida.',
				'_cardio_prep'     => 'No requiere ayuno.
Evite cremas o aceites en el pecho el día del estudio: dificultan la adherencia de los electrodos.
Informe qué medicamentos toma, sobre todo los del corazón o la presión.
Permanezca en reposo unos minutos antes del registro.',
				'_cardio_faq'      => '¿El electrocardiograma da toques o electricidad?
No. El equipo no envía corriente al cuerpo: únicamente <strong>registra</strong> la actividad eléctrica que su propio corazón genera. Es un estudio completamente pasivo.

¿Un electrocardiograma normal descarta un problema del corazón?
No siempre. El ECG capta lo que ocurre en los segundos del registro, por lo que una arritmia intermitente o una isquemia que sólo aparece con el esfuerzo pueden no reflejarse. En esos casos se indica un <strong>Holter</strong> o una <strong>prueba de esfuerzo</strong>.

¿Cada cuánto debo repetirlo?
Depende de su perfil de riesgo y de si existe una cardiopatía conocida. En el seguimiento habitual suele repetirse de forma anual, y con mayor frecuencia si hay cambios de síntomas o ajustes de tratamiento.',
			),
		),
		array(
			'slug'     => 'ecg-holter',
			'titulo'   => 'ECG Holter 24 horas',
			'orden'    => 3,
			'imagen'   => 'proc-holter.jpg',
			'extracto' => 'Monitor Holter ECG de 24 o 48 horas en Tijuana para detectar arritmias y palpitaciones intermitentes. Colocación e interpretación por el Dr. Eduardo Canseco.',
			'contenido' => '<p>El Monitor Holter ECG es una herramienta fundamental para registrar de forma continua la actividad eléctrica de su corazón durante 24 o 48 horas. Es crucial para identificar arritmias o síntomas intermitentes que no se manifiestan en una visita regular.</p>
<p>A diferencia de un electrocardiograma convencional, que captura apenas unos segundos, este pequeño dispositivo portátil le permite realizar sus actividades cotidianas con normalidad mientras registra cada latido. Esa continuidad es lo que proporciona información vital para un diagnóstico más preciso y completo de su salud cardiovascular.</p>
<p>Durante el estudio se le pide llevar una bitácora sencilla: anotar la hora en que aparece un síntoma —palpitación, mareo, dolor— permite correlacionarlo con el trazo exacto de ese momento. Esa correlación es, con frecuencia, lo que define el diagnóstico.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-holter.jpg',
				'_cardio_lead'     => 'Las arritmias rara vez aparecen justo cuando usted está en el consultorio. El Holter registra cada latido durante un día completo para atraparlas.',
				'_cardio_duracion' => 'Colocación de 15 minutos · Registro de 24 a 48 horas',
				'_cardio_indica'   => 'Palpitaciones o sensación de latidos rápidos, lentos o irregulares
Mareo o desmayo sin causa aclarada
Sospecha de fibrilación auricular
Control de la eficacia de un antiarrítmico
Evaluación de pausas o bloqueos en la conducción
Seguimiento después de un infarto',
				'_cardio_como'     => 'Se colocan electrodos adhesivos en el tórax, conectados a un grabador del tamaño de un teléfono pequeño.
Usted se retira a casa y hace su vida normal: trabajar, caminar, dormir.
Anota en una bitácora los síntomas y la hora en que ocurren.
Al día siguiente devuelve el equipo y se descarga el registro para su análisis.',
				'_cardio_prep'     => 'No requiere ayuno.
Báñese antes de la colocación: no podrá hacerlo mientras lleve el equipo.
Evite cremas en el tórax; en algunos casos es necesario rasurar zonas pequeñas.
Use ropa holgada de dos piezas para mayor comodidad.
Continúe con sus medicamentos, salvo indicación distinta del médico.',
				'_cardio_faq'      => '¿Puedo bañarme con el Holter puesto?
No. El grabador y los electrodos no deben mojarse. Le recomendamos bañarse justo antes de la colocación y esperar a devolver el equipo para el siguiente baño.

¿Puedo dormir y trabajar normalmente?
Sí, y de hecho es lo deseable: el objetivo es registrar su ritmo cardíaco en un día representativo de su vida real. Mantenga su rutina habitual, incluyendo el ejercicio, salvo que se le indique otra cosa.

¿Qué pasa si se despega un electrodo?
Presione el parche para reacomodarlo. Si se desprende por completo, comuníquese al consultorio; en algunos casos el registro sigue siendo válido y en otros conviene reponer el electrodo.

¿Cuánto tarda el resultado?
El equipo debe completar el registro de 24 horas antes de descargarse. Después se analiza el trazo completo latido por latido, por lo que el reporte se entrega en los días siguientes a la devolución del dispositivo.',
			),
		),
		array(
			'slug'     => 'ergometria-de-esfuerzo',
			'titulo'   => 'Ergometría de esfuerzo',
			'orden'    => 4,
			'imagen'   => 'proc-ergometria.jpg',
			'extracto' => 'Prueba de esfuerzo en Tijuana con vigilancia continua del electrocardiograma y la presión arterial. Detecta isquemia que no aparece en reposo.',
			'contenido' => '<p>La Ergometría de Esfuerzo es un examen crucial que permite evaluar la respuesta de su corazón al esfuerzo físico. El estudio se ejecuta utilizando una caminadora o una bicicleta estacionaria, y durante todo el trayecto se supervisa continuamente la actividad eléctrica cardíaca, la presión arterial y la frecuencia cardíaca del paciente.</p>
<p>Esta prueba es fundamental para detectar de forma temprana problemas cardiovasculares, como la isquemia o los bloqueos arteriales, que podrían no ser evidentes en estado de reposo. Cuando el corazón trabaja más, necesita más sangre; si una arteria está estrechada, es en ese momento cuando el déficit se hace visible en el trazo eléctrico.</p>
<p>El Dr. Canseco utiliza los resultados para establecer diagnósticos precisos, permitiendo al paciente evitar riesgos cardiovasculares mientras mantiene una vida activa y saludable. La prueba también sirve para definir con seguridad hasta dónde puede llegar su nivel de ejercicio.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-ergometria.jpg',
				'_cardio_lead'     => 'Hay problemas del corazón que sólo se muestran cuando se le exige. La ergometría los provoca de forma controlada y vigilada.',
				'_cardio_duracion' => '45 minutos aproximadamente',
				'_cardio_indica'   => 'Dolor de pecho con el esfuerzo
Sospecha de enfermedad de las arterias coronarias
Valoración antes de iniciar un programa de ejercicio intenso
Control después de un infarto o de una angioplastía
Estudio de arritmias que aparecen con la actividad física
Determinación de la capacidad funcional',
				'_cardio_como'     => 'Se colocan los electrodos y se registra un electrocardiograma y una presión arterial de base.
Comienza a caminar en la banda; cada tres minutos aumentan la velocidad y la inclinación.
Se vigila de forma continua el trazo, la presión y sus síntomas.
La prueba se detiene al alcanzar la meta de frecuencia cardíaca o ante cualquier dato de alarma.
Sigue un periodo de recuperación monitorizada de varios minutos.',
				'_cardio_prep'     => 'Ayuno ligero de 2 a 3 horas. Evite café y tabaco ese día.
Lleve ropa deportiva cómoda y calzado cerrado para caminar.
Consulte con el médico si debe suspender betabloqueadores u otros medicamentos antes del estudio; no los suspenda por cuenta propia.
Si usa inhaladores o tiene alguna limitación para caminar, avísenos al agendar.',
				'_cardio_faq'      => '¿Es peligrosa la prueba de esfuerzo?
Se realiza bajo vigilancia médica continua y se interrumpe de inmediato ante cualquier dato de alarma. Es un estudio ampliamente utilizado y seguro cuando se indica correctamente y se supervisa, que es exactamente la razón por la que se hace en el consultorio y no por su cuenta.

¿Qué pasa si no puedo caminar en la banda?
Existen alternativas. Se puede utilizar bicicleta estacionaria o, si la limitación es importante, valorar otros estudios de detección de isquemia. Coméntelo al agendar para preparar el estudio adecuado.

¿Debo suspender mis medicamentos?
Algunos medicamentos, como los betabloqueadores, impiden que la frecuencia cardíaca suba lo suficiente y pueden restar valor al estudio. La decisión de suspenderlos es <strong>exclusivamente médica</strong>: nunca los interrumpa sin indicación.',
			),
		),
		array(
			'slug'     => 'monitoreo-presion-arterial',
			'titulo'   => 'Monitoreo de presión arterial (MAPA)',
			'orden'    => 5,
			'imagen'   => 'proc-presion-arterial.jpg',
			'extracto' => 'Monitoreo ambulatorio de presión arterial (MAPA) de 24 horas en Tijuana. Detecta hipertensión de bata blanca y enmascarada, y evalúa si su tratamiento funciona.',
			'contenido' => '<p>El Monitoreo Ambulatorio de Presión Arterial (MAPA) es un estudio fundamental para obtener un panorama completo y preciso de su presión arterial a lo largo de un día normal. Durante la evaluación se coloca un dispositivo portátil pequeño que toma lecturas a intervalos fijos durante veinticuatro horas, mientras el paciente continúa con sus actividades regulares.</p>
<p>El estudio proporciona ventajas significativas frente a las mediciones tradicionales en clínica: permite evaluar qué tan bien está funcionando el tratamiento actual, detectar la hipertensión de bata blanca —cifras que sólo se elevan frente al médico— y también la hipertensión enmascarada, que pasa desapercibida en el consultorio pero está presente el resto del día.</p>
<p>Un dato que sólo el MAPA aporta es el comportamiento nocturno de la presión. Normalmente la presión desciende durante el sueño; cuando eso no ocurre, el riesgo cardiovascular es mayor y el tratamiento debe ajustarse. Con esa información se construye un plan de atención personalizado y apropiado.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-presion-arterial.jpg',
				'_cardio_lead'     => 'Una toma de presión en el consultorio es una fotografía. El MAPA es la película completa de sus 24 horas, incluida la noche.',
				'_cardio_duracion' => 'Colocación de 15 minutos · Registro de 24 horas',
				'_cardio_indica'   => 'Cifras de presión variables entre el consultorio y la casa
Sospecha de hipertensión de bata blanca o enmascarada
Hipertensión que no se controla pese al tratamiento
Ajuste fino de dosis y horarios de medicamentos
Síntomas de presión baja con el tratamiento actual
Hipertensión en el embarazo, bajo indicación médica',
				'_cardio_como'     => 'Se coloca un brazalete en el brazo, conectado a un registrador que se lleva al cinturón.
El equipo infla el brazalete de forma automática cada 15 a 30 minutos durante el día y cada 30 a 60 durante la noche.
Al sentir que el brazalete infla, mantenga el brazo quieto y relajado.
Se registra en una bitácora la hora de acostarse, levantarse y de la toma de medicamentos.
A las 24 horas devuelve el equipo y se analiza el perfil completo.',
				'_cardio_prep'     => 'No requiere ayuno.
Use una camisa o blusa holgada, de manga que permita pasar el brazalete por debajo.
Continúe con sus medicamentos y anote la hora exacta en que los toma.
Haga su día normal, incluido el trabajo; evite únicamente el ejercicio intenso salvo indicación contraria.',
				'_cardio_faq'      => '¿Me deja dormir el equipo?
El brazalete infla también de noche, con menor frecuencia. Algunas personas notan las tomas nocturnas; aun así, el registro del sueño es una de las partes más valiosas del estudio y no debe omitirse.

¿Qué hago si el brazalete infla mientras camino o manejo?
Deténgase si puede, deje el brazo extendido y relajado hasta que termine la medición. Un brazo en movimiento produce lecturas poco confiables que el equipo suele repetir.

¿Sustituye a mi aparato de presión de casa?
No lo sustituye, lo complementa. El MAPA da un diagnóstico de precisión en 24 horas; el aparato de casa sirve para el seguimiento cotidiano una vez ajustado el tratamiento.',
			),
		),
		array(
			'slug'     => 'riesgo-cardiovascular',
			'titulo'   => 'Detección de riesgo cardiovascular',
			'orden'    => 6,
			'imagen'   => 'proc-riesgo-cardiovascular.jpg',
			'extracto' => 'Valoración de riesgo cardiovascular en Tijuana: estimación del riesgo de infarto, estudios dirigidos y plan de prevención con el Dr. Eduardo Canseco.',
			'contenido' => '<p>La detección de riesgo cardiovascular es una valoración integral que estima su probabilidad de sufrir un infarto, una angina o un evento cerebrovascular en los próximos años, y define qué hacer para reducirla. No se trata de un solo estudio, sino de una lectura conjunta de su historia, su exploración y sus números.</p>
<p>En la consulta se revisan sus antecedentes personales y familiares, el consumo de tabaco, la presión arterial, el peso y el perímetro abdominal, el perfil de lípidos y la glucosa. Con esos datos se calcula el riesgo y se decide si hacen falta estudios adicionales, como un electrocardiograma, un ecocardiograma o una prueba de esfuerzo.</p>
<p>El valor de esta consulta está en lo que sigue: un plan concreto y realista de metas de presión, colesterol, peso y actividad física, con un calendario de seguimiento. Prevenir es considerablemente más eficaz —y menos costoso— que tratar un infarto ya ocurrido.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-riesgo-cardiovascular.jpg',
				'_cardio_lead'     => 'El infarto no es un accidente: casi siempre es el desenlace de factores que llevaban años acumulándose y que se pueden medir hoy.',
				'_cardio_duracion' => '40 a 60 minutos',
				'_cardio_indica'   => 'Antecedentes familiares de infarto o muerte súbita
Hipertensión, diabetes o colesterol elevado
Tabaquismo actual o previo
Sobrepeso, obesidad o vida sedentaria
Hombres desde los 40 años y mujeres desde la menopausia
Antes de iniciar una actividad deportiva exigente',
				'_cardio_como'     => 'Historia clínica detallada y antecedentes familiares.
Exploración física completa con toma de presión y medidas corporales.
Revisión de sus laboratorios; si no los tiene, se le indican los necesarios.
Cálculo del riesgo y estudios dirigidos según el caso.
Entrega del plan de prevención con metas y fecha de seguimiento.',
				'_cardio_prep'     => 'Si va a llevar laboratorios recientes, tráigalos impresos o en digital.
Anote los medicamentos y suplementos que toma, con sus dosis.
Si le pedimos laboratorios nuevos, se le indicará si requieren ayuno.
Conozca, en lo posible, los antecedentes cardíacos de sus padres y hermanos.',
				'_cardio_faq'      => 'Me siento bien, ¿de todas formas necesito la valoración?
Sí, y es precisamente el mejor momento. La hipertensión y el colesterol alto no producen síntomas durante años; cuando aparecen, con frecuencia ya hay daño. La valoración preventiva existe justamente para actuar antes.

¿Qué laboratorios se necesitan?
Habitualmente perfil de lípidos, glucosa, hemoglobina glucosilada y función renal. Según su caso pueden agregarse otros. Si trae estudios recientes, en muchas ocasiones no es necesario repetirlos.

¿Cada cuánto debo repetir el chequeo?
En personas sin factores de riesgo, de forma anual. Si existe hipertensión, diabetes o dislipidemia en tratamiento, el seguimiento es más frecuente y se define en la consulta.',
			),
		),
		array(
			'slug'     => 'valoracion-preoperatoria',
			'titulo'   => 'Valoración preoperatoria',
			'orden'    => 7,
			'imagen'   => 'proc-valoracion-preoperatoria.jpg',
			'extracto' => 'Valoración cardiológica preoperatoria en Tijuana: estudios necesarios y dictamen de riesgo para su cirugía, en el menor tiempo posible. Centro Hospitalario MAC.',
			'contenido' => '<p>La valoración preoperatoria cardiológica determina si su corazón está en condiciones de tolerar una cirugía y la anestesia que ésta requiere, y qué medidas deben tomarse para reducir el riesgo durante y después del procedimiento.</p>
<p>No todas las cirugías ni todos los pacientes requieren los mismos estudios. La valoración parte del tipo de intervención programada, de su edad, de sus antecedentes y de su capacidad funcional actual. A partir de ahí se indica lo necesario —desde un electrocardiograma hasta un ecocardiograma o una prueba de esfuerzo— y se evita lo que no aporta.</p>
<p>El resultado es un dictamen por escrito dirigido a su cirujano y a su anestesiólogo, con la clasificación de riesgo, las recomendaciones sobre el manejo de sus medicamentos en el perioperatorio y, cuando procede, la autorización cardiológica para proceder.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-valoracion-preoperatoria.jpg',
				'_cardio_lead'     => 'El dictamen que le pide su cirujano o su anestesiólogo, resuelto con los estudios que su caso realmente necesita y sin trámites de más.',
				'_cardio_duracion' => '40 a 60 minutos, más los estudios que se indiquen',
				'_cardio_indica'   => 'Cirugía programada de cualquier especialidad
Pacientes con hipertensión, diabetes o cardiopatía conocida
Antecedente de infarto, stent o cirugía cardíaca previa
Pacientes mayores de 60 años
Portadores de marcapasos o desfibrilador
Solicitud expresa del cirujano o del anestesiólogo',
				'_cardio_como'     => 'Traiga la indicación de su cirujano con el tipo de cirugía y la fecha programada.
Se realiza historia clínica, exploración y valoración de la capacidad funcional.
Se indican y realizan los estudios necesarios, en la medida de lo posible el mismo día.
Se emite el dictamen escrito con la clasificación de riesgo y las recomendaciones.',
				'_cardio_prep'     => 'Lleve la orden o el resumen de su cirujano.
Traiga sus estudios previos: electrocardiogramas, laboratorios, reportes cardiológicos.
Lleve la lista completa de medicamentos, incluyendo anticoagulantes y antiagregantes.
Agende con anticipación suficiente a la fecha de su cirugía por si se requieren estudios adicionales.',
				'_cardio_faq'      => '¿Con cuánta anticipación debo hacer la valoración?
Lo ideal es acudir con al menos una o dos semanas de anticipación. Si el estudio revela algo que deba corregirse o requiere un estudio complementario, ese margen evita que se posponga la cirugía.

¿Debo suspender mis anticoagulantes antes de operarme?
Esa decisión se toma de forma conjunta entre el cardiólogo, el cirujano y el anestesiólogo, y depende del motivo por el que los toma y del sangrado esperado en su cirugía. <strong>Nunca los suspenda por cuenta propia.</strong>

¿Me entregan el dictamen por escrito?
Sí. Recibe un documento dirigido a su equipo quirúrgico con la valoración de riesgo, las recomendaciones perioperatorias y, cuando procede, la autorización cardiológica.',
			),
		),
		array(
			'slug'     => 'revision-de-marcapasos',
			'titulo'   => 'Revisión de marcapasos',
			'orden'    => 8,
			'imagen'   => 'proc-marcapasos.jpg',
			'extracto' => 'Control y revisión de marcapasos en Tijuana: estado de la batería, umbrales de estimulación y registro de eventos. Dr. Eduardo Canseco, cardiólogo.',
			'contenido' => '<p>La revisión de marcapasos es el control periódico que verifica que el dispositivo esté funcionando conforme a lo programado y que su configuración siga siendo la adecuada para usted. Es un procedimiento externo, sin punciones ni molestias.</p>
<p>Durante la revisión se comprueba el estado de la batería y la vida útil restante, se miden los umbrales de estimulación y la calidad de la detección, se revisa la integridad de los electrodos y se descarga el registro de eventos almacenados por el dispositivo, incluidos episodios de arritmia que usted quizá no percibió.</p>
<p>Con esa información se ajusta la programación cuando hace falta y se define cuándo será necesario el recambio del generador. Mantener el calendario de revisiones es lo que permite anticipar el reemplazo con tiempo, en lugar de resolverlo con urgencia.</p>',
			'meta'     => array(
				'_cardio_imagen'   => 'proc-marcapasos.jpg',
				'_cardio_lead'     => 'Un marcapasos bien programado pasa desapercibido. Para que siga así hace falta revisarlo periódicamente, mucho antes de que dé señales.',
				'_cardio_duracion' => '20 a 30 minutos',
				'_cardio_indica'   => 'Control programado del dispositivo según su calendario
Palpitaciones, mareo o desmayo en un portador de marcapasos
Sospecha de agotamiento de la batería
Cambio de síntomas o de tolerancia al esfuerzo
Antes de una cirugía o de un estudio de resonancia magnética
Después de una descarga o de un evento cardíaco',
				'_cardio_como'     => 'Se coloca el cabezal del programador sobre el dispositivo, por encima de la ropa o la piel.
Se establece la comunicación y se descargan los parámetros y el registro de eventos.
Se miden umbrales, impedancias y estado de la batería.
Se ajusta la programación si es necesario y se define la fecha del siguiente control.',
				'_cardio_prep'     => 'Lleve la tarjeta de identificación de su marcapasos: contiene marca, modelo y fecha de implante.
Traiga los reportes de revisiones anteriores si los conserva.
Lleve la lista de los medicamentos que toma actualmente.
Anote los síntomas que haya presentado desde el último control y cuándo ocurrieron.',
				'_cardio_faq'      => '¿La revisión duele o requiere pinchar la piel?
No. La comunicación con el dispositivo es inalámbrica: se apoya un cabezal sobre el pecho, sin punciones ni incisiones de ningún tipo.

¿Cada cuánto debo revisar mi marcapasos?
El calendario habitual es de una a dos revisiones al año, y se hace más frecuente conforme la batería se acerca al final de su vida útil. Su intervalo específico se define en la consulta.

¿Debo traer la tarjeta del dispositivo?
Sí, es muy conveniente. Identifica marca y modelo, lo que permite usar el programador correcto. Si la extravió, avísenos al agendar para prepararnos.',
			),
		),
	);
}

/**
 * Datos de las páginas del sitio.
 *
 * @return array
 */
function cardio_seed_paginas() {
	return array(
		array(
			'slug'      => 'inicio',
			'titulo'    => 'Inicio',
			'orden'     => 1,
			'plantilla' => '',
			'extracto'  => '',
			'contenido' => '<!-- La portada la construye la plantilla front-page.php del tema. Los textos del bloque principal se editan en Apariencia → Personalizar → Cardiología: datos del consultorio → Portada. -->',
		),
		array(
			'slug'      => 'nosotros',
			'titulo'    => 'Nosotros',
			'orden'     => 2,
			'plantilla' => 'template-nosotros.php',
			'extracto'  => 'Un consultorio de cardiología construido sobre una idea simple: el estudio vale por la lectura que lo acompaña.',
			'contenido' => '<p>El Dr. Eduardo Canseco es un médico cardiólogo con una amplia experiencia en el cuidado del corazón. Su enfoque se centra en ofrecer la mejor atención clínica y un servicio de calidad, basado en su profundo conocimiento y dedicación para su salud cardiovascular.</p>
<p>El consultorio se encuentra dentro del Centro Hospitalario MAC, en Alamar, lo que permite resolver en un mismo lugar la consulta, los estudios cardiovasculares y su interpretación, con respaldo hospitalario cuando el caso lo requiere.</p>
<p>Atendemos pacientes de todo Tijuana, Rosarito, Tecate y del área de San Diego.</p>',
		),
		array(
			'slug'      => 'dr-eduardo-canseco',
			'titulo'    => 'Dr. Eduardo Canseco',
			'orden'     => 3,
			'plantilla' => 'template-medico.php',
			'extracto'  => 'Médico cardiólogo con más de 10 años de experiencia en el cuidado del corazón, certificado en ecocardiografía clínica.',
			'contenido' => '<p>Su experiencia incluye el ejercicio como médico cirujano en Bolivia, trabajo en cardiología clínica en el <strong>Hospital Español de México</strong> y práctica en ecocardiografía en el Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán.</p>
<p>Se ha desempeñado como cardiólogo clínico en el <strong>ISSSTE</strong> (2009–2011) y en el <strong>IMSS</strong> (desde 2008), además de su práctica privada dentro del Centro Hospitalario MAC.</p>
<p>En consulta realiza electrocardiogramas, ecocardiogramas Doppler, pruebas de esfuerzo, monitoreo Holter y de presión arterial, evaluaciones de riesgo cardiovascular, valoraciones preoperatorias y revisiones de marcapasos.</p>',
		),
		array(
			'slug'      => 'cita',
			'titulo'    => 'Agenda tu cita',
			'orden'     => 4,
			'plantilla' => 'template-cita.php',
			'extracto'  => 'Escríbanos y le confirmamos disponibilidad, preparación del estudio y costo. También puede llamarnos directamente.',
			'contenido' => '<p class="eyebrow">Solicitud de cita</p>
<h2>Cuéntenos qué necesita</h2>
<p class="lead">Complete el formulario y nos pondremos en contacto para confirmar su cita. Si prefiere resolverlo de inmediato, llame o escriba por WhatsApp.</p>',
		),
		array(
			'slug'      => 'contacto',
			'titulo'    => 'Contacto',
			'orden'     => 5,
			'plantilla' => 'template-contacto.php',
			'extracto'  => 'Estamos dentro del Centro Hospitalario MAC, sobre el Blvd. Vía Rápida Oriente, en la zona Alamar de Tijuana.',
			'contenido' => '',
		),
		array(
			'slug'      => 'aviso-de-privacidad',
			'titulo'    => 'Aviso de privacidad',
			'orden'     => 6,
			'plantilla' => '',
			'extracto'  => 'Cómo tratamos y protegemos sus datos personales.',
			'contenido' => '<p><em>Nota para el titular del sitio: este texto es una base redactada conforme a la estructura que exige la legislación mexicana en materia de datos personales. Antes de publicarlo, revíselo con su asesor legal.</em></p>

<h2>1. Responsable del tratamiento</h2>
<p>Dr. Eduardo Canseco, con domicilio en Plaza Península, Int. D2-2, Centro Hospitalario MAC, Blvd. Vía Rápida Oriente 15000, Alamar, C.P. 22110, Tijuana, Baja California, es el responsable del uso y protección de sus datos personales, en términos de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares.</p>

<h2>2. Datos personales que recabamos</h2>
<p>Para las finalidades señaladas en este aviso podemos recabar datos de identificación y contacto: nombre, teléfono, correo electrónico y la información que usted decida proporcionarnos en el formulario de solicitud de cita.</p>
<p>En el marco de la atención médica se recaban además <strong>datos personales sensibles</strong> relativos a su estado de salud presente y pasado. Estos datos se tratan bajo estricta confidencialidad y conforme a la normativa sanitaria aplicable, incluida la NOM-004-SSA3-2012 del expediente clínico.</p>

<h2>3. Finalidades del tratamiento</h2>
<p>Finalidades primarias, necesarias para la relación con usted:</p>
<ul class="check-list">
<li>Agendar, confirmar y dar seguimiento a su cita.</li>
<li>Prestar los servicios de consulta y estudios cardiovasculares solicitados.</li>
<li>Integrar y conservar su expediente clínico.</li>
<li>Emitir comprobantes y cumplir obligaciones fiscales y legales.</li>
</ul>
<p>Finalidades secundarias, que usted puede rechazar sin afectar su atención:</p>
<ul class="check-list">
<li>Envío de recordatorios de control y de información sobre salud cardiovascular.</li>
</ul>

<h2>4. Transferencia de datos</h2>
<p>Sus datos no se transfieren a terceros sin su consentimiento, salvo en los supuestos previstos por el artículo 37 de la ley: requerimiento de autoridad competente, atención de una urgencia médica, o cuando la transferencia sea necesaria para su atención por parte de otros profesionales de la salud o instituciones que participen en su tratamiento.</p>

<h2>5. Derechos ARCO</h2>
<p>Usted tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (<strong>Acceso</strong>); a solicitar la corrección de su información cuando sea inexacta o incompleta (<strong>Rectificación</strong>); a que la eliminemos de nuestros registros cuando considere que no está siendo utilizada conforme a los principios y deberes que marca la normativa (<strong>Cancelación</strong>); así como a oponerse al uso de sus datos personales para fines específicos (<strong>Oposición</strong>).</p>
<p>Para ejercer cualquiera de estos derechos, envíe su solicitud a <a href="mailto:info@cardiologiatijuana.com">info@cardiologiatijuana.com</a>, indicando su nombre completo, el derecho que desea ejercer y un medio para comunicarle la respuesta. La cancelación de datos del expediente clínico está sujeta a los plazos mínimos de conservación que establece la normativa sanitaria.</p>

<h2>6. Revocación del consentimiento</h2>
<p>Puede revocar el consentimiento que nos haya otorgado enviando su solicitud al mismo correo electrónico. Tenga en cuenta que en ciertos casos no será posible concluir el uso de forma inmediata, y que la revocación puede implicar que no podamos seguir prestándole el servicio.</p>

<h2>7. Uso de cookies</h2>
<p>Este sitio puede utilizar cookies y tecnologías similares para recordar sus preferencias y obtener estadísticas agregadas de navegación. Puede deshabilitarlas desde la configuración de su navegador; hacerlo no impide el uso del sitio.</p>

<h2>8. Cambios al aviso de privacidad</h2>
<p>Cualquier modificación a este aviso se publicará en esta misma página. Le sugerimos revisarla periódicamente.</p>',
		),
	);
}

/**
 * Crea las páginas al activar el tema.
 *
 * Sin esto, un tema recién activado sin importar el .xml no tiene portada y
 * WordPress muestra el listado del blog, que no es lo que el tema dibuja.
 * No se duplica nada: cada página se crea sólo si su slug no existe ya.
 */
function cardio_seed_pages() {
	if ( get_option( 'cardio_pages_seeded' ) ) {
		return;
	}

	foreach ( cardio_seed_paginas() as $item ) {
		if ( get_page_by_path( $item['slug'] ) ) {
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_title'   => $item['titulo'],
				'post_name'    => $item['slug'],
				'post_content' => $item['contenido'],
				'post_excerpt' => $item['extracto'],
				'post_status'  => 'publish',
				'menu_order'   => $item['orden'],
			)
		);

		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}

		if ( ! empty( $item['plantilla'] ) ) {
			update_post_meta( $id, '_wp_page_template', $item['plantilla'] );
		}
	}

	update_option( 'cardio_pages_seeded', 1 );
}
add_action( 'after_switch_theme', 'cardio_seed_pages', 15 );

/**
 * Siembra los procedimientos al activar el tema.
 */
function cardio_seed_procedimientos() {
	if ( get_option( 'cardio_seeded' ) ) {
		return;
	}

	// Si ya hay procedimientos (por ejemplo, importados desde el .xml) no se hace nada.
	$existentes = get_posts(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	if ( $existentes ) {
		update_option( 'cardio_seeded', 1 );
		return;
	}

	foreach ( cardio_seed_data() as $item ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'procedimiento',
				'post_title'   => $item['titulo'],
				'post_name'    => $item['slug'],
				'post_content' => $item['contenido'],
				'post_excerpt' => $item['extracto'],
				'post_status'  => 'publish',
				'menu_order'   => $item['orden'],
			)
		);

		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}

		foreach ( $item['meta'] as $key => $value ) {
			update_post_meta( $id, $key, $value );
		}
	}

	update_option( 'cardio_seeded', 1 );
}
add_action( 'after_switch_theme', 'cardio_seed_procedimientos', 20 );

/**
 * Suelta la imagen destacada de los procedimientos cuyo archivo ya no coincide
 * con el que el propio procedimiento declara.
 *
 * Sin esto, quien instaló una versión previa del tema conserva imágenes
 * antiguas —y en algún caso repetidas entre dos procedimientos—, porque la
 * rutina de adjuntado sólo actúa sobre los que no tienen imagen.
 */
function cardio_reparar_imagenes() {
	$mapa = array();
	foreach ( cardio_seed_data() as $item ) {
		$mapa[ $item['slug'] ] = $item['imagen'];
	}

	$procs = get_posts(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => 30,
			'post_status'    => 'any',
		)
	);

	foreach ( $procs as $post ) {
		$esperado = isset( $mapa[ $post->post_name ] ) ? $mapa[ $post->post_name ] : get_post_meta( $post->ID, '_cardio_imagen', true );
		if ( ! $esperado ) {
			continue;
		}

		// El metadato queda al día aunque la instalación sea antigua.
		update_post_meta( $post->ID, '_cardio_imagen', $esperado );

		$actual = get_post_thumbnail_id( $post->ID );
		if ( ! $actual ) {
			continue;
		}

		$archivo = basename( get_attached_file( $actual ) );
		// WordPress añade sufijos al reimportar: «proc-holter-1.jpg».
		$base_actual   = preg_replace( '/-\d+(\.\w+)$/', '$1', $archivo );
		$base_esperado = $esperado;

		if ( $base_actual !== $base_esperado ) {
			delete_post_thumbnail( $post->ID );
		}
	}
}

/**
 * Sube las imágenes incluidas en el tema a la biblioteca de medios y las
 * asigna como imagen destacada del procedimiento que corresponda.
 *
 * Se ejecuta en el escritorio y sólo actúa sobre los procedimientos que
 * todavía no tienen imagen destacada, de modo que funciona tanto si el
 * contenido se creó al activar el tema como si se importó desde el .xml.
 */
function cardio_attach_images() {
	if ( ! is_admin() || wp_doing_ajax() || ! current_user_can( 'upload_files' ) ) {
		return;
	}
	// Al actualizar el tema se revisan de nuevo: una instalación anterior pudo
	// dejar fijada una imagen destacada que ya no corresponde (por ejemplo, un
	// procedimiento que reutilizaba la foto del carrusel).
	if ( get_option( 'cardio_images_version' ) !== CARDIO_VERSION ) {
		delete_transient( 'cardio_images_done' );
		cardio_reparar_imagenes();
		update_option( 'cardio_images_version', CARDIO_VERSION );
	}

	if ( get_transient( 'cardio_images_done' ) ) {
		return;
	}

	$pendientes = get_posts(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => 10,
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'NOT EXISTS',
				),
			),
		)
	);

	if ( ! $pendientes ) {
		set_transient( 'cardio_images_done', 1, DAY_IN_SECONDS );
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Relación slug del procedimiento → archivo incluido en el tema.
	$mapa = array();
	foreach ( cardio_seed_data() as $item ) {
		$mapa[ $item['slug'] ] = $item['imagen'];
	}

	foreach ( $pendientes as $post ) {
		$archivo = '';

		if ( isset( $mapa[ $post->post_name ] ) ) {
			$archivo = $mapa[ $post->post_name ];
		} else {
			// El .xml guarda el nombre del archivo en este metadato.
			$archivo = get_post_meta( $post->ID, '_cardio_imagen', true );
		}

		if ( ! $archivo ) {
			continue;
		}

		$ruta = CARDIO_DIR . '/assets/img/' . $archivo;
		if ( ! file_exists( $ruta ) ) {
			continue;
		}

		// Copia temporal: media_handle_sideload mueve el archivo de origen.
		$tmp = wp_tempnam( $archivo );
		if ( ! $tmp || ! copy( $ruta, $tmp ) ) {
			continue;
		}

		$adjunto = media_handle_sideload(
			array(
				'name'     => $archivo,
				'tmp_name' => $tmp,
			),
			$post->ID,
			$post->post_title
		);

		if ( is_wp_error( $adjunto ) ) {
			@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			continue;
		}

		set_post_thumbnail( $post->ID, $adjunto );
		update_post_meta( $adjunto, '_wp_attachment_image_alt', $post->post_title );
	}

	set_transient( 'cardio_images_done', 1, HOUR_IN_SECONDS );
}
add_action( 'admin_init', 'cardio_attach_images', 20 );

/**
 * Asigna automáticamente los menús importados a sus ubicaciones.
 */
function cardio_assign_menus() {
	if ( get_option( 'cardio_menus_assigned' ) ) {
		return;
	}

	// Ubicación → slug del menú importado y su nombre visible. Si al importar
	// ya existía un menú con ese slug, WordPress le añade un sufijo
	// («menu-principal-2»), por lo que se busca también por nombre.
	$mapa = array(
		'principal' => array( 'menu-principal', 'Menú principal' ),
		'pie'       => array( 'menu-pie', 'Pie: el consultorio' ),
		'legal'     => array( 'menu-legal', 'Legal' ),
	);

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$cambio    = false;

	foreach ( $mapa as $ubicacion => $identificadores ) {
		if ( ! empty( $locations[ $ubicacion ] ) ) {
			continue;
		}

		$menu = null;
		foreach ( $identificadores as $identificador ) {
			$menu = wp_get_nav_menu_object( $identificador );
			if ( $menu ) {
				break;
			}
		}

		// Último recurso: cualquier menú cuyo slug empiece por el esperado.
		if ( ! $menu ) {
			foreach ( wp_get_nav_menus() as $candidato ) {
				if ( 0 === strpos( $candidato->slug, $identificadores[0] ) ) {
					$menu = $candidato;
					break;
				}
			}
		}

		if ( $menu ) {
			$locations[ $ubicacion ] = $menu->term_id;
			$cambio                  = true;
		}
	}

	if ( $cambio ) {
		set_theme_mod( 'nav_menu_locations', $locations );
		update_option( 'cardio_menus_assigned', 1 );
	}
}
add_action( 'admin_init', 'cardio_assign_menus', 30 );

/**
 * Fija la portada y la estructura de enlaces al activar el tema.
 */
function cardio_setup_front_page() {
	if ( get_option( 'cardio_front_set' ) ) {
		return;
	}

	$inicio = get_page_by_path( 'inicio' );
	if ( $inicio ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $inicio->ID );
		update_option( 'cardio_front_set', 1 );
	}

	// Enlaces permanentes legibles, necesarios para el tipo de contenido.
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules();
	}
}
add_action( 'admin_init', 'cardio_setup_front_page', 40 );
