<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Seeder;

class NoticiasSeeder extends Seeder
{
    public function run(): void
    {
        $noticias = [
            [
                'titulo' => 'Asamblea General Extraordinaria - Marzo 2024',
                'contenido' => 'Se convoca a todos los miembros de ASODAT a la Asamblea General Extraordinaria que se realizará el próximo 15 de marzo de 2024 en el auditorio principal de la UFA-ESPE Sede Latacunga. En esta asamblea se tratarán temas importantes como la aprobación del presupuesto anual, elección de nuevos miembros de la directiva y presentación de proyectos para el próximo período.',
                'categoria' => 'Eventos',
                'imagen_path' => '/assets/img/noticias/asamblea-general.jpg',
                'publicar_desde' => '2024-02-15 08:00:00',
                'publicar_hasta' => '2024-03-20 23:59:59',
            ],
            [
                'titulo' => 'Nuevos Convenios Comerciales Disponibles',
                'contenido' => 'Nos complace informar que hemos establecido nuevos convenios comerciales con importantes empresas de la región. Estos convenios incluyen descuentos especiales en servicios de salud, educación, entretenimiento y productos de primera necesidad. Todos los miembros activos pueden acceder a estos beneficios presentando su carnet de afiliado.',
                'categoria' => 'Anuncios',
                'imagen_path' => '/assets/img/noticias/convenios-comerciales.jpg',
                'publicar_desde' => '2024-02-10 10:00:00',
                'publicar_hasta' => '2024-12-31 23:59:59',
            ],
            [
                'titulo' => 'Celebración del Día del Trabajador',
                'contenido' => 'El próximo 1 de mayo celebraremos el Día Internacional del Trabajador con una serie de actividades especiales. El programa incluye una misa de acción de gracias, almuerzo comunitario, presentaciones culturales y actividades recreativas para toda la familia. La celebración se realizará en las instalaciones de la asociación.',
                'categoria' => 'Eventos',
                'imagen_path' => '/assets/img/noticias/dia-trabajador.jpg',
                'publicar_desde' => '2024-04-20 09:00:00',
                'publicar_hasta' => '2024-05-05 23:59:59',
            ],
            [
                'titulo' => 'Actualización de Estatutos y Reglamentos',
                'contenido' => 'La directiva de ASODAT ha aprobado las actualizaciones a los estatutos y reglamentos de la asociación. Los cambios incluyen mejoras en los procesos de afiliación, nuevos beneficios para los miembros y procedimientos actualizados para las asambleas. Todos los documentos actualizados están disponibles en la oficina de la asociación.',
                'categoria' => 'Comunicados',
                'imagen_path' => null,
                'publicar_desde' => '2024-01-15 14:00:00',
                'publicar_hasta' => '2024-06-30 23:59:59',
            ],
            [
                'titulo' => 'Programa de Capacitación Profesional',
                'contenido' => 'Iniciamos nuestro programa anual de capacitación profesional dirigido a todos los miembros de la asociación. Los cursos incluyen talleres de liderazgo, gestión administrativa, nuevas tecnologías y desarrollo personal. Las inscripciones están abiertas y los cupos son limitados. Los cursos se realizarán los sábados de 9:00 a 13:00.',
                'categoria' => 'Noticias',
                'imagen_path' => '/assets/img/noticias/capacitacion.jpg',
                'publicar_desde' => '2024-02-01 08:00:00',
                'publicar_hasta' => '2024-03-31 23:59:59',
            ],
            [
                'titulo' => 'Servicio de Asesoría Legal Gratuita',
                'contenido' => 'A partir de este mes, todos los miembros de ASODAT pueden acceder al servicio de asesoría legal gratuita. Este servicio incluye consultas sobre temas laborales, familiares, civiles y administrativos. Las consultas se realizan los martes y jueves de 15:00 a 18:00 en la oficina de la asociación. Se requiere cita previa.',
                'categoria' => 'Anuncios',
                'imagen_path' => '/assets/img/noticias/asesoria-legal.jpg',
                'publicar_desde' => '2024-01-20 12:00:00',
                'publicar_hasta' => '2024-12-31 23:59:59',
            ],
            [
                'titulo' => 'Torneo Deportivo Interdepartamental',
                'contenido' => 'Se anuncia el inicio del torneo deportivo interdepartamental que se realizará durante los meses de abril y mayo. Las disciplinas incluyen fútbol, baloncesto, voleibol y tenis de mesa. Los equipos pueden inscribirse hasta el 30 de marzo. Habrá premios para los ganadores y actividades recreativas para toda la familia.',
                'categoria' => 'Eventos',
                'imagen_path' => '/assets/img/noticias/torneo-deportivo.jpg',
                'publicar_desde' => '2024-03-01 10:00:00',
                'publicar_hasta' => '2024-05-31 23:59:59',
            ],
            [
                'titulo' => 'Nuevas Instalaciones de la Asociación',
                'contenido' => 'Nos complace informar que hemos inaugurado las nuevas instalaciones de la asociación. Las nuevas oficinas incluyen salas de reuniones, área de capacitación, sala de cómputo y espacios recreativos. Las instalaciones están disponibles para uso de todos los miembros previa reservación.',
                'categoria' => 'Noticias',
                'imagen_path' => '/assets/img/noticias/nuevas-instalaciones.jpg',
                'publicar_desde' => '2024-01-10 16:00:00',
                'publicar_hasta' => '2024-06-30 23:59:59',
            ],
            [
                'titulo' => 'Cambio de Horarios de Atención',
                'contenido' => 'A partir del próximo lunes, los horarios de atención en la oficina de la asociación cambiarán. El nuevo horario será de lunes a viernes de 8:00 a 17:00 y los sábados de 8:00 a 12:00. Los domingos permanecerá cerrado. Agradecemos su comprensión y esperamos que estos cambios mejoren la atención a nuestros miembros.',
                'categoria' => 'Comunicados',
                'imagen_path' => null,
                'publicar_desde' => '2024-02-25 09:00:00',
                'publicar_hasta' => '2024-04-30 23:59:59',
            ],
            [
                'titulo' => 'Programa de Bienestar Integral',
                'contenido' => 'Lanzamos nuestro programa de bienestar integral que incluye actividades de yoga, meditación, caminatas grupales y talleres de nutrición. Las actividades se realizan los fines de semana en diferentes parques de la ciudad. Todos los miembros y sus familias están invitados a participar. La inscripción es gratuita.',
                'categoria' => 'Eventos',
                'imagen_path' => '/assets/img/noticias/bienestar-integral.jpg',
                'publicar_desde' => '2024-02-05 11:00:00',
                'publicar_hasta' => '2024-12-31 23:59:59',
            ],
            [
                'titulo' => 'Resultados de la Encuesta de Satisfacción',
                'contenido' => 'Compartimos los resultados de la encuesta de satisfacción realizada en diciembre de 2023. El 85% de los miembros calificó como excelente o muy bueno los servicios de la asociación. Los aspectos mejor evaluados fueron la atención personalizada y la variedad de beneficios. Trabajaremos en mejorar las áreas identificadas con menor satisfacción.',
                'categoria' => 'Noticias',
                'imagen_path' => '/assets/img/noticias/encuesta-satisfaccion.jpg',
                'publicar_desde' => '2024-01-25 14:00:00',
                'publicar_hasta' => '2024-03-31 23:59:59',
            ],
        ];

        foreach ($noticias as $noticia) {
            Noticia::create($noticia);
        }
    }
}