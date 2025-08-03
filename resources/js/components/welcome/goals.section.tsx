import { Card, CardContent } from '@/components/ui/card';
import { Award, Target, Users } from 'lucide-react';
import { motion } from 'motion/react';

export default function GoalsSection() {
    const objectives = [
        {
            title: 'Unidad y solidaridad',
            description:
                'Fomentar la unidad y solidaridad entre los miembros para contribuir al desarrollo y progreso de la Universidad de las Fuerzas Armadas ESPE (UFA-ESPE) Sede Latacunga.',
            icon: Target,
        },
        {
            title: 'Mejoramiento de condiciones',
            description:
                'Mejorar las condiciones laborales, económicas, sociales, deportivas y culturales de los miembros a través de programas y actividades específicas.',
            icon: Users,
        },
        {
            title: 'Defensa de derechos',
            description:
                'Defender los derechos laborales, constitucionales y legales de los asociados, brindándoles asesoría administrativa y legal.',
            icon: Award,
        },
        {
            title: 'Cooperativas y servicios',
            description: 'Crear cooperativas y servicios de asistencia para el beneficio de los miembros de la Asociación.',
            icon: Award,
        },
        {
            title: 'Colaboración académica y administrativa',
            description:
                'Colaborar con la gestión académica y administrativa de la UFA-ESPE Sede Latacunga a través de la interacción directa con sus autoridades y presentación de proyectos.',
            icon: Award,
        },
        {
            title: 'Participación activa',
            description:
                'Participar activamente en eventos académicos, culturales, deportivos y de vinculación organizados por la Universidad o por la Asociación.',
            icon: Award,
        },
    ];
    return (
        <section id="objetivos" className="bg-white py-20">
            <div className="container mx-auto px-4 lg:px-6">
                <motion.div
                    className="space-y-16"
                    initial={{ y: 40, opacity: 0 }}
                    whileInView={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.6, ease: 'easeOut' }}
                    viewport={{ once: true, amount: 0.1 }}
                >
                    <motion.div
                        className="space-y-4 text-center"
                        initial={{ y: 20, opacity: 0 }}
                        whileInView={{ y: 0, opacity: 1 }}
                        transition={{ duration: 0.6, delay: 0.1, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    >
                        <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestros Objetivos</h2>
                        <motion.div
                            className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                            initial={{ scaleX: 0 }}
                            whileInView={{ scaleX: 1 }}
                            transition={{ duration: 0.5, delay: 0.2, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        />
                        <p className="mx-auto max-w-3xl text-xl text-slate-600">
                            Trabajamos constantemente para alcanzar metas ambiciosas que beneficien a toda nuestra comunidad profesional.
                        </p>
                    </motion.div>

                    <motion.div
                        className="grid gap-8 md:grid-cols-3"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, amount: 0.1 }}
                        variants={{
                            hidden: {},
                            visible: {
                                transition: {
                                    staggerChildren: 0.1,
                                    delayChildren: 0.25,
                                },
                            },
                        }}
                    >
                        {objectives.map((objective, index) => (
                            <motion.div
                                key={index}
                                variants={{
                                    hidden: { y: 60, opacity: 0 },
                                    visible: { y: 0, opacity: 1 },
                                }}
                                transition={{ duration: 0.5, ease: 'easeOut' }}
                                whileHover={{ y: -8, scale: 1.02 }}
                            >
                                <Card className="h-full border-0 bg-gradient-to-br from-white to-blue-50/50 shadow-lg transition-all duration-300">
                                    <CardContent className="flex h-full flex-col justify-between space-y-6 p-8 text-center">
                                        <div className="space-y-6">
                                            <motion.div
                                                className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800"
                                                whileHover={{ scale: 1.1, rotate: 10 }}
                                                transition={{ duration: 0.3 }}
                                            >
                                                <objective.icon className="h-8 w-8 text-white" />
                                            </motion.div>
                                            <h3 className="text-xl font-bold text-slate-800">{objective.title}</h3>
                                        </div>
                                        <p className="leading-relaxed text-slate-600">{objective.description}</p>
                                    </CardContent>
                                </Card>
                            </motion.div>
                        ))}
                    </motion.div>
                </motion.div>
            </div>
        </section>
    );
}
