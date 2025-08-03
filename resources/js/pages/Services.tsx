import AppLayout from '@/layouts/app-layout';
import { Activity, ArrowRight, CheckCircle, FileText, Handshake, Scale, Star, Users } from 'lucide-react';
import { motion } from 'motion/react';

export default function ServicesPage() {
    const services = [
        {
            title: 'Afiliación a la Asociación',
            description: 'Permite a docentes, administrativos y trabajadores ser parte activa de la ASODAT.',
            icon: Users,
            color: 'blue',
            requirements: [
                'Relación laboral con la UFA-ESPE Sede Latacunga.',
                'Solicitud escrita de afiliación.',
                'Copia de cédula de identidad.',
                'Autorización de descuentos por rol de pagos.',
            ],
        },
        {
            title: 'Asesoría Legal y Administrativa',
            description: 'Apoyo en temas legales relacionados con la relación laboral de los socios.',
            icon: Scale,
            color: 'green',
            requirements: ['Ser miembro activo de la Asociación.', 'Solicitud escrita dirigida a la Directiva.'],
        },
        {
            title: 'Convenios Comerciales',
            description: 'Facilidad de acceso a bienes y servicios mediante descuentos por rol.',
            icon: Handshake,
            color: 'purple',
            requirements: ['Estar al día en las cuotas.', 'No estar sancionado o en mora.'],
        },
        {
            title: 'Actividades Recreativas y Culturales',
            description: 'Eventos deportivos, culturales y de integración para fortalecer la unidad gremial.',
            icon: Activity,
            color: 'orange',
            requirements: ['Inscripción previa cuando se requiera.', 'Participación activa en la organización.'],
        },
        {
            title: 'Participación en Asambleas',
            description: 'Derecho a voz y voto en decisiones importantes para la Asociación.',
            icon: FileText,
            color: 'red',
            requirements: ['Estar registrado ante la autoridad competente.', 'Estar al día en obligaciones estatutarias.'],
        },
    ];

    const getColorClasses = (color: string) => {
        const colors = {
            blue: 'from-blue-600 to-blue-700 bg-blue-50 border-blue-200',
            green: 'from-green-600 to-green-700 bg-green-50 border-green-200',
            purple: 'from-purple-600 to-purple-700 bg-purple-50 border-purple-200',
            orange: 'from-orange-600 to-orange-700 bg-orange-50 border-orange-200',
            red: 'from-red-600 to-red-700 bg-red-50 border-red-200',
        };
        return colors[color as keyof typeof colors] || colors.blue;
    };

    return (
        <AppLayout title="Servicios">
            <section className="relative min-h-screen overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100/50 to-blue-50 py-16">
                {/* Background decorative elements */}
                <div className="absolute inset-0 overflow-hidden">
                    <div className="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-blue-200/20 blur-3xl"></div>
                    <div className="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-blue-300/20 blur-3xl"></div>
                    <div className="absolute top-1/2 left-1/4 h-60 w-60 rounded-full bg-blue-100/30 blur-2xl"></div>
                    <div className="absolute top-1/3 right-1/4 h-40 w-40 rounded-full bg-green-100/20 blur-xl"></div>
                </div>

                <div className="relative container mx-auto px-4 lg:px-6">
                    <motion.div
                        className="space-y-16"
                        initial={{ y: 40, opacity: 0 }}
                        whileInView={{ y: 0, opacity: 1 }}
                        transition={{ duration: 0.8, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    >
                        {/* Hero Section */}
                        <motion.div
                            className="flex min-h-[50vh] flex-col justify-center space-y-8 text-center"
                            initial={{ y: 20, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ duration: 0.8, delay: 0.1, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <div className="space-y-6">
                                <motion.div
                                    className="inline-flex items-center justify-center rounded-full border border-blue-200/50 bg-blue-100/80 px-4 py-2 backdrop-blur-sm"
                                    initial={{ scale: 0.8, opacity: 0 }}
                                    whileInView={{ scale: 1, opacity: 1 }}
                                    transition={{ duration: 0.6, delay: 0.2, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                >
                                    <Star className="mr-2 h-3 w-3 text-blue-600" />
                                    <span className="text-xs font-medium text-blue-700">Servicios profesionales</span>
                                </motion.div>

                                <div className="space-y-4">
                                    <h1 className="text-3xl font-bold text-slate-800 md:text-4xl lg:text-5xl">
                                        <span className="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 bg-clip-text text-transparent">
                                            NUESTROS
                                        </span>
                                        <br />
                                        <span className="text-slate-700">SERVICIOS</span>
                                    </h1>

                                    <motion.div
                                        className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800"
                                        initial={{ scaleX: 0 }}
                                        whileInView={{ scaleX: 1 }}
                                        transition={{ duration: 0.8, delay: 0.3, ease: 'easeOut' }}
                                        viewport={{ once: true, amount: 0.1 }}
                                    />
                                </div>

                                <p className="mx-auto max-w-2xl text-base leading-relaxed text-slate-600">
                                    Descubre todos los servicios que ofrecemos para nuestros miembros y cómo pueden beneficiarte en tu desarrollo
                                    profesional.
                                </p>
                            </div>
                        </motion.div>

                        {/* Services Grid - Diseño mejorado */}
                        <motion.div
                            className="space-y-12"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true, amount: 0.1 }}
                            variants={{
                                hidden: {},
                                visible: {
                                    transition: {
                                        staggerChildren: 0.2,
                                        delayChildren: 0.3,
                                    },
                                },
                            }}
                        >
                            {services.map((service, index) => (
                                <motion.div
                                    key={index}
                                    variants={{
                                        hidden: { y: 80, opacity: 0 },
                                        visible: { y: 0, opacity: 1 },
                                    }}
                                    transition={{ duration: 0.8, ease: 'easeOut' }}
                                    className={`relative overflow-hidden rounded-2xl border bg-white/95 backdrop-blur-sm transition-all duration-500 hover:scale-[1.01] hover:shadow-lg ${getColorClasses(service.color).split(' ')[2]} ${getColorClasses(service.color).split(' ')[3]}`}
                                >
                                    <div className="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-white/20"></div>
                                    <div className="relative p-6">
                                        <div className="grid items-center gap-6 lg:grid-cols-2">
                                            {/* Contenido */}
                                            <div className="space-y-4">
                                                <motion.div
                                                    className={`inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br ${getColorClasses(service.color).split(' ')[0]} ${getColorClasses(service.color).split(' ')[1]} shadow-md`}
                                                    whileHover={{ scale: 1.1, rotate: -5 }}
                                                    transition={{ duration: 0.3 }}
                                                >
                                                    <service.icon className="h-6 w-6 text-white" />
                                                </motion.div>

                                                <div className="space-y-3">
                                                    <h3 className="text-xl font-bold text-slate-800">{service.title}</h3>
                                                    <p className="text-sm leading-relaxed text-slate-600">{service.description}</p>
                                                </div>
                                            </div>

                                            {/* Requisitos */}
                                            <div className="space-y-3">
                                                <div className="flex items-center space-x-2">
                                                    <div className="h-0.5 w-4 rounded-full bg-gradient-to-r from-green-500 to-green-600"></div>
                                                    <h4 className="text-sm font-bold text-slate-800">Requisitos:</h4>
                                                </div>
                                                <div className="space-y-2">
                                                    {service.requirements.map((requirement, reqIndex) => (
                                                        <motion.div
                                                            key={reqIndex}
                                                            className="group flex items-start space-x-2 rounded-md bg-white/60 p-2 backdrop-blur-sm transition-all duration-300 hover:bg-white/80"
                                                            initial={{ x: 30, opacity: 0 }}
                                                            whileInView={{ x: 0, opacity: 1 }}
                                                            transition={{ duration: 0.6, delay: reqIndex * 0.15, ease: 'easeOut' }}
                                                            viewport={{ once: true, amount: 0.1 }}
                                                        >
                                                            <motion.div
                                                                className="mt-0.5 flex-shrink-0"
                                                                whileHover={{ scale: 1.2 }}
                                                                transition={{ duration: 0.2 }}
                                                            >
                                                                <CheckCircle className="h-4 w-4 text-green-600" />
                                                            </motion.div>
                                                            <span className="text-xs text-slate-700 transition-colors duration-200 group-hover:text-slate-800">
                                                                {requirement}
                                                            </span>
                                                        </motion.div>
                                                    ))}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </motion.div>
                            ))}
                        </motion.div>

                        {/* Call to Action */}
                        <motion.div
                            className="space-y-6 text-center"
                            initial={{ y: 40, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ duration: 0.8, delay: 0.5, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <div className="space-y-4">
                                <h2 className="text-2xl font-bold text-slate-800 md:text-3xl">¿Listo para unirte?</h2>
                                <p className="mx-auto max-w-xl text-sm text-slate-600">
                                    Descubre todos los beneficios que tenemos para ti y comienza tu proceso de afiliación hoy mismo.
                                </p>
                            </div>

                            <motion.div
                                className="flex justify-center"
                                initial={{ y: 20, opacity: 0 }}
                                whileInView={{ y: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.6, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                                    <a
                                        href={route('memberships')}
                                        className="inline-flex items-center space-x-2 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:from-blue-700 hover:to-blue-800 hover:shadow-xl"
                                    >
                                        <span>Comenzar Afiliación</span>
                                        <ArrowRight className="h-4 w-4" />
                                    </a>
                                </motion.div>
                            </motion.div>
                        </motion.div>
                    </motion.div>
                </div>
            </section>
        </AppLayout>
    );
}
