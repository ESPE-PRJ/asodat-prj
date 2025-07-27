import { Card, CardContent } from '@/components/ui/card';
import { Star, Target } from 'lucide-react';
import { motion } from 'motion/react';

export default function TargetSection() {
    return (
        <section id="mision" className="bg-gradient-to-br from-blue-50 to-slate-50 py-20">
            <div className="container mx-auto px-4 lg:px-6">
                <motion.div
                    className="space-y-16 text-center"
                    initial={{ y: 40, opacity: 0 }}
                    whileInView={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.6, ease: 'easeOut' }}
                    viewport={{ once: true, amount: 0.1 }}
                >
                    <motion.div
                        className="space-y-4"
                        initial={{ y: 20, opacity: 0 }}
                        whileInView={{ y: 0, opacity: 1 }}
                        transition={{ duration: 0.6, delay: 0.1, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    >
                        <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Misión y Visión</h2>
                        <motion.div
                            className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                            initial={{ scaleX: 0 }}
                            whileInView={{ scaleX: 1 }}
                            transition={{ duration: 0.5, delay: 0.2, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        />
                    </motion.div>

                    <div className="mx-auto grid max-w-6xl gap-8 md:grid-cols-2">
                        <motion.div
                            initial={{ x: -40, opacity: 0 }}
                            whileInView={{ x: 0, opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.25, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                            whileHover={{ y: -8, scale: 1.02 }}
                        >
                            <Card className="border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300">
                                <CardContent className="space-y-6 p-8 text-center">
                                    <motion.div
                                        className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800"
                                        whileHover={{ scale: 1.1, rotate: 5 }}
                                        transition={{ duration: 0.3 }}
                                    >
                                        <Target className="h-8 w-8 text-white" />
                                    </motion.div>
                                    <h3 className="text-2xl font-bold text-slate-800">Misión</h3>
                                    <p className="leading-relaxed text-slate-600">
                                        Fomentar el espíritu de unidad, solidaridad, pertenencia y compañerismo entre los socios, para coadyuvar en el
                                        desarrollo y progreso de la Universidad, promoviendo el mejoramiento laboral, económico, social y cultural.
                                    </p>
                                </CardContent>
                            </Card>
                        </motion.div>

                        <motion.div
                            initial={{ x: 40, opacity: 0 }}
                            whileInView={{ x: 0, opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.35, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                            whileHover={{ y: -8, scale: 1.02 }}
                        >
                            <Card className="border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300">
                                <CardContent className="space-y-6 p-8 text-center">
                                    <motion.div
                                        className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800"
                                        whileHover={{ scale: 1.1, rotate: -5 }}
                                        transition={{ duration: 0.3 }}
                                    >
                                        <Star className="h-8 w-8 text-white" />
                                    </motion.div>
                                    <h3 className="text-2xl font-bold text-slate-800">Visión</h3>
                                    <p className="leading-relaxed text-slate-600">
                                        Ser una organización sólida y representativa que defienda los derechos de sus miembros, brinde servicios de
                                        calidad y contribuya activamente al fortalecimiento institucional de la UFA-ESPE sede Latacunga.
                                    </p>
                                </CardContent>
                            </Card>
                        </motion.div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
}
