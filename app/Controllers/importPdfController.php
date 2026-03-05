<?php

namespace App\Controllers;
use App\Libraries\openAIService;
class importPdfController extends BaseController {

    public function importPdf(){

        // Lógica para procesar el PDF y extraer información con OpenAI
        $file = $this->request->getFile('formFile');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $parser = new \Smalot\PdfParser\Parser();

            $pdf = $parser->parseFile($file->getTempName());

            $text = $pdf->getText();
            
            // Se quita comillas que confunden a la IA
            $text = str_replace('“', "", $text);
            $text = str_replace('”', "", $text);

            $ai = new openAIService();

            $response = $ai->chat('Eres un sistema de extracción de información académica.
                                Tu tarea es analizar el texto proporcionado y EXTRAER ÚNICAMENTE
                                la información solicitada, SIN interpretar, inferir ni deducir datos.

                                ────────────────────────────
                                REGLAS GENERALES (OBLIGATORIAS)
                                ────────────────────────────
                                - Devuelve SOLO un JSON válido.
                                - NO agregues texto antes ni después del JSON.
                                - Usa únicamente comillas dobles (").
                                - NO uses ningún formato de marcado.
                                - Si un dato no existe o no es explícito, usa null.
                                - Si una lista no tiene elementos, devuelve [].
                                - NO inventes información.
                                - Respeta EXACTAMENTE la estructura solicitada.
                                - Si existen múltiples estudiantes, asesores, coasesores o jurados, inclúyelos todos.
                                - Todas las fechas deben estar en formato YYYY-MM-dd.

                                ────────────────────────────
                                DEFINICIONES CLAVE (NO CONFUNDIR)
                                ────────────────────────────
                                - tipo_modalidad: Categoría general del trabajo de grado (ej: Trabajo de Investigación).
                                - nombre_trabajo: TÍTULO EXACTO del proyecto.
                                - programa_modalidad: Programa académico del estudiante.
                                - sede_modalidad / nombre_sede: Nombre de la sede (ej: Pasto, Túquerres).
                                - sede_codigo: Código numérico asociado EXCLUSIVAMENTE a (programa + sede).

                                ! nombre_trabajo NUNCA es igual a tipo_modalidad.
                                ! sede_codigo NUNCA se deduce, SOLO se asigna si hay coincidencia exacta.

                                ────────────────────────────
                                REGLAS PARA DOCUMENTO_IDENTIDAD
                                ────────────────────────────
                                - documento_identidad corresponde ÚNICAMENTE al número de identificación del estudiante.

                                ────────────────────────────
                                REGLAS PARA OBJETIVOS_MODALIDAD
                                ────────────────────────────
                                - objetivos_modalidad son las actividades o propósitos del trabajo de grado.
                                - Si están numerados, elimina la numeración.
                                - Devuelve SOLO una lista de textos.
                                - Si no existen, devuelve [].

                                ────────────────────────────
                                REGLAS PARA No_acuerdo (CRÍTICO)
                                ────────────────────────────
                                - Extrae el número SOLO si el texto contiene:
                                "ACUERDO No.<numero> (Fecha)"
                                - Devuelve ÚNICAMENTE el número (sin palabra "Acuerdo" ni año).
                                - NO confundas con el Acuerdo 084 de 2020 (normativo).
                                - Si no cumple el formato exacto, devuelve null.

                                ────────────────────────────
                                REGLAS PARA tipo_modalidad (CRÍTICO)
                                ────────────────────────────
                                - tipo_modalidad debe extraerse SOLO si aparece explícitamente en el texto.
                                - Generalmente aparece después de frases como:
                                "<Nombre> solicita acogerse a la modalidad de grado"

                                MODALIDADES VÁLIDAS (EXACTAS):
                                - Trabajo de Investigación
                                - Articulo Cientifico
                                - Participación en Grupos de Investigación
                                - Diplomado
                                - Créditos en Cursos de Postgrado
                                - Pasantia Empresarial
                                - Proyectos comunitarios
                                - Estancias Académicas

                                ! Si no aparece exactamente una de estas, devuelve null.

                                ────────────────────────────
                                REGLAS PARA id_modalidad (OBLIGATORIAS)
                                ────────────────────────────
                                - id_modalidad SOLO se asigna si tipo_modalidad coincide EXACTAMENTE.
                                - NO deduzcas ni asumas.

                                ASIGNACIÓN OBLIGATORIA:
                                - Trabajo de Investigación
                                - Articulo Cientifico
                                - Participación en Grupos de Investigación
                                    → id_modalidad = 1

                                - Diplomado
                                - Créditos en Cursos de Postgrado
                                    → id_modalidad = 2

                                - Pasantia Empresarial
                                - Proyectos comunitarios
                                - Estancias Académicas
                                    → id_modalidad = 3

                                - Si no hay coincidencia exacta → id_modalidad = null

                                ────────────────────────────
                                REGLAS PARA nombre_trabajo
                                ────────────────────────────
                                - Es el TÍTULO EXACTO del proyecto.
                                - NO es la modalidad.
                                - Respeta el texto literal.
                                - Usa SOLO comillas dobles normales (").

                                ────────────────────────────
                                REGLAS PARA DURACIÓN Y FECHAS
                                ────────────────────────────
                                - fecha_inicio_modalidad: extrae SOLO si aparece explícita.
                                - duracion_modalidad: incluye SIEMPRE el valor y la unidad (ej: "1 año").
                                - fin_estimado_modalidad:
                                    -- Se calcula ÚNICAMENTE si fecha_inicio_modalidad y duracion_modalidad existen, teniendo en cuenta
                                    los siguientes calculos.
                                
                                CÁLCULOS:
                                1. Meses → suma directa.
                                2. Años → suma directa.
                                3. SEMESTRES: 
                                - Semestre A: del 02-01 al 06-30
                                - Semestre B: del 08-01 al 12-31

                                PROCEDIMIENTO OBLIGATORIO:
                                1. Identifica el semestre académico en el que cae la fecha_inicio_modalidad:
                                - Febrero a junio → Semestre A
                                - Agosto a diciembre → Semestre B
                                - Enero y julio NO pertenecen a ningún semestre académico.

                                2. El semestre donde inicia la modalidad se considera COMPLETO
                                y cuenta como el primer semestre.

                                3. Suma la cantidad total de semestres indicados en duracion_modalidad,
                                avanzando cronológicamente entre Semestre A y Semestre B.

                                4. El fin_estimado_modalidad debe ser:
                                - YYYY-06-30 si el último semestre es Semestre A
                                - YYYY-12-31 si el último semestre es Semestre B


                                EJEMPLOS (SOLO COMO REFERENCIA):
                                - fecha_inicio = 2024-08-15 + 1 semestre
                                → Semestre B 2024
                                → fin_estimado = 2024-12-31

                                - fecha_inicio = 2024-02-10 + 2 semestres
                                → Semestre A 2024 + Semestre B 2024
                                → fin_estimado = 2024-12-31

                                - fecha_inicio = 2024-09-20 + 2 semestres
                                → Semestre B 2024 + Semestre A 2025
                                → fin_estimado = 2025-06-30

                                4. DURACIÓN EN HORAS (REGLAS OBLIGATORIAS):

                                DEFINICIÓN DE JORNADA LABORAL:
                                - 1 día hábil = 8 horas de trabajo.
                                - Días hábiles: lunes a viernes.
                                - NO se cuentan sábados, domingos ni festivos.
                                - El trabajo se realiza de forma continua en días hábiles.

                                PROCEDIMIENTO OBLIGATORIO:
                                1. Convierte la duración total en horas a días hábiles:
                                - días_hábiles = total_horas / 8
                                - Si el resultado no es un número entero, redondea SIEMPRE hacia arriba.

                                2. Inicia el conteo desde fecha_inicio_modalidad:
                                - Si fecha_inicio_modalidad cae en sábado o domingo,
                                    el conteo inicia el siguiente lunes hábil.

                                3. Suma los días hábiles de forma secuencial:
                                - Avanza solo de lunes a viernes.
                                - NO cuentes sábados ni domingos.

                                4. fin_estimado_modalidad corresponde al ÚLTIMO día hábil contado,
                                en formato YYYY-MM-dd.

                                ────────────────────────────
                                REGLAS PARA estado_modalidad
                                ────────────────────────────
                                - estado_modalidad = "aprobada"
                                SOLO si el texto lo menciona explícitamente.
                                
                                ────────────────────────────
                                REGLAS PARA SEDE Y PROGRAMA (CRÍTICO)
                                ────────────────────────────
                                - Extrae programa_modalidad y sede_modalidad SOLO si aparecen explícitamente.
                                - NO asumas ni infieras.
                                - nombre_sede = sede_modalidad.
                                - sede_codigo SOLO se asigna si:
                                1. programa_modalidad está explícito
                                2. sede_modalidad está explícita
                                3. Coinciden EXACTAMENTE con la tabla

                                TABLA DE PROGRAMAS:
                                30  - Ingeniería Ambiental      - Tumaco
                                31  - Ingeniería Agronómica     - Pasto
                                89  - Ingeniería Ambiental      - Pasto
                                108 - Ingeniería Agroforestal   - Pasto
                                136 - Ingeniería Ambiental      - Tuquerres
                                170 - Ingeniería Agronómica     - Tumaco
                                171 - Ingeniería Agronómica     - Tuquerres
                                182 - Ingeniería Agroforestal   - Tumaco

                                ! CUALQUIER ambigüedad → sede_codigo = null

                                ────────────────────────────
                                ESTRUCTURA JSON (NO MODIFICAR)
                                ────────────────────────────
                                {
                                "estudiantes": [
                                    {
                                    "codigo_estudiantil": null,
                                    "documento_identidad": null,
                                    "nombre": null,
                                    "programa": null,
                                    "nombre_sede": null,
                                    "sede_codigo": null
                                    }
                                ],
                                "asesores": [
                                    { "nombre": null }
                                ],
                                "coasesores": [],
                                "jurados": [
                                    { "nombre": null }
                                ],
                                "modalidad": {
                                    "No_acuerdo": null,
                                    "nombre_trabajo": null,
                                    "tipo_modalidad": null,
                                    "id_modalidad": null,
                                    "estado_modalidad": null,
                                    "fecha_inicio_modalidad": null,
                                    "objetivos_modalidad": [],
                                    "duracion_modalidad": null,
                                    "fin_estimado_modalidad": null
                                }
                                }

                                TEXTO A ANALIZAR: ' . $text);

            // Realizar ajustes al response para que no haya errores json
            $response = str_replace('`', '', $response);
            $response = str_replace('json','',$response);
                    
            $data = json_decode($response,true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON inválido generado por la IA');
            }
            
            // Guardar los datos extraídos en sesión y redirigir al procesamiento
            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
            
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al importar datos desde la IA'
            ]);
        }
    }
}