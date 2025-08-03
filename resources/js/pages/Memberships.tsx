import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { Award, Check, Download, Users } from 'lucide-react';
import { motion } from 'motion/react';

export default function MembershipsPage() {
    const requirements = [
        'Ser servidor de la UFA-ESPE sede Latacunga con relación de dependencia.',
        'Presentar una solicitud escrita dirigida al Presidente de la Fundación.',
        'Adjuntar copia de la cédula de identidad.',
        'Aceptar cumplir con el Estatuto, normativas y sanciones asignadas.',
        'Autorizar descuentos por nómina de aportes ordinarios y extraordinarios.',
    ];

    const benefits = [
        'Elegir y ser elegido para dignidades de la Directiva.',
        'Participar con voz y voto en Asambleas Generales.',
        'Asesoría administrativa y legal en temas laborales.',
        'Acceso a proyectos sociales, culturales, deportivos y académicos.',
        'Descuentos y servicios comerciales gestionados por la Asociación.',
        'Acceso a cooperativas y servicios de lavandería.',
    ];

    return (
        <AppLayout title="Afiliación">
            <section className="relative min-h-screen overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100/50 to-blue-50 py-20">
                {/* Background decorative elements */}
                <div className="absolute inset-0 overflow-hidden">
                    <div className="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-blue-200/20 blur-3xl"></div>
                    <div className="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-blue-300/20 blur-3xl"></div>
                    <div className="absolute top-1/2 left-1/4 h-60 w-60 rounded-full bg-blue-100/30 blur-2xl"></div>
                </div>

                <div className="relative container mx-auto px-4 lg:px-6">
                    <motion.div
                        className="space-y-20"
                        initial={{ y: 40, opacity: 0 }}
                        whileInView={{ y: 0, opacity: 1 }}
                        transition={{ duration: 0.8, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    >
                        {/* Hero Section - Más altura */}
                        <motion.div
                            className="flex min-h-[50vh] flex-col justify-center space-y-12 text-center"
                            initial={{ y: 20, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ duration: 0.8, delay: 0.1, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <div className="space-y-8">
                                <motion.div
                                    className="inline-flex items-center justify-center rounded-full border border-blue-200/50 bg-blue-100/80 px-6 py-2 backdrop-blur-sm"
                                    initial={{ scale: 0.8, opacity: 0 }}
                                    whileInView={{ scale: 1, opacity: 1 }}
                                    transition={{ duration: 0.6, delay: 0.2, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                >
                                    <Users className="mr-2 h-4 w-4 text-blue-600" />
                                    <span className="text-sm font-medium text-blue-700">Únete a nuestra comunidad</span>
                                </motion.div>

                                <h1 className="text-4xl font-bold text-slate-800 md:text-6xl lg:text-7xl">
                                    <span className="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 bg-clip-text text-transparent">
                                        AFILIACIÓN
                                    </span>
                                    <br />
                                    <span className="text-slate-700">A ASODAT</span>
                                </h1>

                                <motion.div
                                    className="mx-auto h-1 w-32 rounded-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800"
                                    initial={{ scaleX: 0 }}
                                    whileInView={{ scaleX: 1 }}
                                    transition={{ duration: 0.8, delay: 0.3, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                />

                                <p className="mx-auto max-w-3xl text-xl leading-relaxed text-slate-600">
                                    Descubre cómo formar parte de nuestra asociación y acceder a todos los beneficios exclusivos para nuestros
                                    miembros.
                                </p>
                            </div>
                        </motion.div>

                        {/* Requirements and Benefits Grid - Diseño completamente novedoso */}
                        <div className="space-y-16">
                            {/* Requisitos Section - Imagen alineada con la lista */}
                            <motion.div
                                initial={{ x: -60, opacity: 0 }}
                                whileInView={{ x: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.2, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                <div className="grid items-start gap-8 lg:grid-cols-3">
                                    {/* Imagen lateral izquierda */}
                                    <motion.div
                                        className="order-2 lg:order-1 lg:col-span-1"
                                        initial={{ scale: 0.8, opacity: 0 }}
                                        whileInView={{ scale: 1, opacity: 1 }}
                                        transition={{ duration: 0.8, delay: 0.3, ease: 'easeOut' }}
                                        viewport={{ once: true, amount: 0.1 }}
                                    >
                                        <div className="relative flex h-full items-center justify-center pt-16">
                                            <motion.div
                                                className="h-96 w-full overflow-hidden rounded-3xl"
                                                whileHover={{ scale: 1.02 }}
                                                transition={{ duration: 0.3 }}
                                            >
                                                <img
                                                    src="/assets/img/cooperation.webp"
                                                    alt="Imagen Afiliación"
                                                    className="h-full w-full object-cover"
                                                />
                                            </motion.div>
                                        </div>
                                    </motion.div>

                                    {/* Contenido central */}
                                    <div className="order-1 lg:order-2 lg:col-span-2">
                                        <div className="space-y-6">
                                            <div className="space-y-4">
                                                <h2 className="text-3xl font-bold text-slate-800">REQUISITOS PARA AFILIACIÓN</h2>
                                                <div className="h-1 w-24 rounded-full bg-blue-600"></div>
                                            </div>

                                            <div className="grid gap-4">
                                                {requirements.map((requirement, index) => (
                                                    <motion.div
                                                        key={index}
                                                        className="group flex items-start space-x-4 rounded-xl bg-white/50 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/70"
                                                        initial={{ x: -30, opacity: 0 }}
                                                        whileInView={{ x: 0, opacity: 1 }}
                                                        transition={{ duration: 0.6, delay: 0.4 + index * 0.1, ease: 'easeOut' }}
                                                        viewport={{ once: true, amount: 0.1 }}
                                                    >
                                                        <motion.div
                                                            className="mt-1 flex-shrink-0"
                                                            whileHover={{ scale: 1.2 }}
                                                            transition={{ duration: 0.2 }}
                                                        >
                                                            <Check className="h-6 w-6 text-green-600" />
                                                        </motion.div>
                                                        <span className="text-slate-700 transition-colors duration-200 group-hover:text-slate-800">
                                                            {requirement}
                                                        </span>
                                                    </motion.div>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </motion.div>

                            {/* Beneficios Section - Imagen reposicionada */}
                            <motion.div
                                initial={{ x: 60, opacity: 0 }}
                                whileInView={{ x: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.3, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                <div className="space-y-8">
                                    {/* Header con imagen */}
                                    <div className="space-y-6 text-center">
                                        <motion.div
                                            className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-600 shadow-xl"
                                            whileHover={{ scale: 1.1, rotate: 5 }}
                                            transition={{ duration: 0.3 }}
                                        >
                                            <Award className="h-10 w-10 text-white" />
                                        </motion.div>
                                        <div className="space-y-4">
                                            <h2 className="text-3xl font-bold text-slate-800">BENEFICIOS DE SER MIEMBRO</h2>
                                            <div className="mx-auto h-1 w-24 rounded-full bg-green-600"></div>
                                        </div>
                                    </div>

                                    <div className="grid gap-6 md:grid-cols-2">
                                        {benefits.map((benefit, index) => (
                                            <motion.div
                                                key={index}
                                                className="group flex items-start space-x-4 rounded-2xl bg-white/80 p-6 backdrop-blur-sm transition-all duration-300 hover:bg-white/90 hover:shadow-lg"
                                                initial={{ y: 30, opacity: 0 }}
                                                whileInView={{ y: 0, opacity: 1 }}
                                                transition={{ duration: 0.6, delay: 0.5 + index * 0.1, ease: 'easeOut' }}
                                                viewport={{ once: true, amount: 0.1 }}
                                            >
                                                <motion.div className="mt-1 flex-shrink-0" whileHover={{ scale: 1.2 }} transition={{ duration: 0.2 }}>
                                                    <Check className="h-6 w-6 text-green-600" />
                                                </motion.div>
                                                <span className="text-slate-700 transition-colors duration-200 group-hover:text-slate-800">
                                                    {benefit}
                                                </span>
                                            </motion.div>
                                        ))}
                                    </div>
                                </div>
                            </motion.div>
                        </div>

                        {/* Formulario Section - PDF más grande y como ventana */}
                        <motion.div
                            className="space-y-12"
                            initial={{ y: 60, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ duration: 0.8, delay: 0.5, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <motion.div
                                className="space-y-6 text-center"
                                initial={{ y: 20, opacity: 0 }}
                                whileInView={{ y: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.6, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                <div className="space-y-4">
                                    <motion.div
                                        className="inline-flex items-center justify-center rounded-full border border-green-200/50 bg-green-100/80 px-6 py-2 backdrop-blur-sm"
                                        initial={{ scale: 0.8, opacity: 0 }}
                                        whileInView={{ scale: 1, opacity: 1 }}
                                        transition={{ duration: 0.6, delay: 0.7, ease: 'easeOut' }}
                                        viewport={{ once: true, amount: 0.1 }}
                                    >
                                        <Download className="mr-2 h-4 w-4 text-green-600" />
                                        <span className="text-sm font-medium text-green-700">Documento oficial</span>
                                    </motion.div>

                                    <h2 className="text-3xl font-bold text-slate-800 md:text-4xl">FORMULARIO OFICIAL DE AFILIACIÓN</h2>
                                    <div className="mx-auto h-0.5 w-24 rounded-full bg-gradient-to-r from-green-600 to-green-700"></div>
                                </div>

                                <p className="mx-auto max-w-3xl text-lg leading-relaxed text-slate-600">
                                    Puedes revisar y descargar el formulario oficial que deberás llenar y entregar para completar tu proceso de
                                    afiliación.
                                </p>
                            </motion.div>

                            <motion.div
                                className="mx-auto max-w-6xl"
                                initial={{ y: 30, opacity: 0 }}
                                whileInView={{ y: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.7, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                {/* PDF Viewer como ventana */}
                                <motion.div
                                    className="relative overflow-hidden rounded-2xl border-2 border-gray-300 bg-gray-100"
                                    initial={{ scale: 0.95, opacity: 0 }}
                                    whileInView={{ scale: 1, opacity: 1 }}
                                    transition={{ duration: 0.8, delay: 0.8, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                >
                                    {/* PDF Header */}
                                    <div className="flex items-center justify-between border-b border-gray-300 bg-gray-200 p-4">
                                        <div className="flex items-center space-x-4">
                                            <div className="flex space-x-2">
                                                <div className="h-3 w-3 rounded-full bg-red-500"></div>
                                                <div className="h-3 w-3 rounded-full bg-yellow-500"></div>
                                                <div className="h-3 w-3 rounded-full bg-green-500"></div>
                                            </div>
                                            <div className="flex items-center space-x-3">
                                                <div className="h-6 w-6 rounded-full bg-green-500"></div>
                                                <div className="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                                                    <div className="h-3 w-3 rounded-full bg-white"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="text-gray-600">
                                            <span className="font-semibold">Solicitud de Afiliación</span>
                                        </div>
                                    </div>

                                    {/* PDF Content - Más grande */}
                                    <div className="h-[700px] bg-white">
                                        <iframe
                                            src="/assets/pdf/SolicitudAfiliacion.pdf"
                                            className="h-full w-full"
                                            title="Formulario de Afiliación ASODAT"
                                        />
                                    </div>
                                </motion.div>

                                <motion.div
                                    className="mt-8 flex justify-center"
                                    initial={{ y: 20, opacity: 0 }}
                                    whileInView={{ y: 0, opacity: 1 }}
                                    transition={{ duration: 0.8, delay: 0.9, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                >
                                    <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                                        <Button
                                            size="lg"
                                            className="bg-gradient-to-r from-green-600 to-green-700 px-8 py-4 text-lg font-semibold text-white transition-all duration-300 hover:from-green-700 hover:to-green-800"
                                        >
                                            <Download className="mr-3 h-6 w-6" />
                                            Descargar PDF
                                        </Button>
                                    </motion.div>
                                </motion.div>
                            </motion.div>
                        </motion.div>
                    </motion.div>
                </div>
            </section>
        </AppLayout>
    );
}
