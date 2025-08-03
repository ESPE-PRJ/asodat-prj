import { Card, CardContent } from '@/components/ui/card';
import { Heart, Shield, Star } from 'lucide-react';
import { motion } from 'motion/react';

export default function BenefitsSection() {
    const benefits = [
        {
            title: 'Asistencia Legal y Administrativa',
            description: 'Asesoría en temas laborales, administrativos y legales para nuestros miembros.',
            icon: Shield,
        },
        {
            title: 'Defensa de los Derechos Laborales',
            description: 'Defensa activa de los derechos laborales de nuestros miembros ante las autoridades.',
            icon: Heart,
        },
        {
            title: 'Asesoría Financiera y Económica',
            description: 'Asesoría y apoyo económico en la gestión financiera, acceso a cooperativas y préstamos.',
            icon: Star,
        },
        {
            title: 'Acceso a Créditos y Préstamos',
            description: 'Condiciones preferenciales en préstamos personales y beneficios asociados.',
            icon: Star,
        },
        {
            title: 'Beneficios Sociales y Culturales',
            description: 'Participación en eventos culturales, sociales y recreativos organizados por la asociación.',
            icon: Star,
        },
        {
            title: 'Solidaridad y Apoyo entre Miembros',
            description: 'Fomento de la colaboración, solidaridad y el espíritu de comunidad dentro de la asociación.',
            icon: Star,
        },
        {
            title: 'Participación Activa en Decisiones',
            description: 'Derecho a elegir y ser elegido para cargos directivos, participando en decisiones importantes.',
            icon: Star,
        },
        {
            title: 'Acceso a Reembolsos y Viáticos',
            description: 'Reembolsos de gastos para miembros de la directiva y comisiones al realizar actividades institucionales.',
            icon: Star,
        },
    ];

    return (
        <section id="beneficios" className="bg-gradient-to-br from-slate-50 to-blue-50 py-20">
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
                        <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Beneficios Exclusivos</h2>
                        <motion.div
                            className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                            initial={{ scaleX: 0 }}
                            whileInView={{ scaleX: 1 }}
                            transition={{ duration: 0.5, delay: 0.2, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        />
                        <p className="mx-auto max-w-3xl text-xl text-slate-600">
                            Descubre las ventajas únicas que ofrecemos a nuestros miembros para impulsar su crecimiento profesional.
                        </p>
                    </motion.div>

                    <motion.div
                        className="grid gap-8 md:grid-cols-4"
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
                        {benefits.map((benefit, index) => (
                            <motion.div
                                key={index}
                                variants={{
                                    hidden: { y: 60, opacity: 0 },
                                    visible: { y: 0, opacity: 1 },
                                }}
                                transition={{ duration: 0.5, ease: 'easeOut' }}
                                whileHover={{ y: -8, scale: 1.02 }}
                            >
                                <Card className="h-full border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300">
                                    <CardContent className="flex h-full flex-col justify-between space-y-6 p-8 text-center">
                                        <div className="space-y-6">
                                            <motion.div
                                                className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800"
                                                whileHover={{ scale: 1.1, rotate: -10 }}
                                                transition={{ duration: 0.3 }}
                                            >
                                                <benefit.icon className="h-8 w-8 text-white" />
                                            </motion.div>
                                            <h3 className="text-xl font-bold text-slate-800">{benefit.title}</h3>
                                        </div>
                                        <p className="leading-relaxed text-slate-600">{benefit.description}</p>
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
