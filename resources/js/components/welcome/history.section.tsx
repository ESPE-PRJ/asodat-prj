import { motion } from 'motion/react';

export default function HistorySection() {
    return (
        <section id="historia" className="bg-white py-20">
            <div className="container mx-auto px-4 lg:px-6">
                <motion.div
                    className="mx-auto max-w-4xl space-y-8 text-center"
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
                        <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestra Historia</h2>
                        <motion.div
                            className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                            initial={{ scaleX: 0 }}
                            whileInView={{ scaleX: 1 }}
                            transition={{ duration: 0.5, delay: 0.2, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        />
                    </motion.div>
                    <div className="grid items-center gap-12 md:grid-cols-2">
                        <motion.div
                            className="space-y-6 text-left"
                            initial={{ x: -30, opacity: 0 }}
                            whileInView={{ x: 0, opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.25, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <motion.p
                                className="text-lg leading-relaxed text-slate-600"
                                initial={{ y: 20, opacity: 0 }}
                                whileInView={{ y: 0, opacity: 1 }}
                                transition={{ duration: 0.5, delay: 0.3, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                La Asociación de Docentes, Personal Administrativo y Trabajadores de la Universidad de las Fuerzas Armadas “ESPE” sede
                                Latacunga fue constituida con el objetivo de fortalecer la unidad y el bienestar de sus miembros. Surgió del
                                compromiso y esfuerzo colectivo de sus fundadores el 23 de octubre de 2023.
                            </motion.p>
                        </motion.div>
                        <motion.div
                            className="relative"
                            initial={{ x: 30, opacity: 0 }}
                            whileInView={{ x: 0, opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.35, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                            whileHover={{ scale: 1.05 }}
                        >
                            <img
                                src="https://picsum.photos/500/400.webp"
                                alt="Historia de la Asociación"
                                width={500}
                                height={400}
                                className="rounded-xl shadow-lg"
                            />
                        </motion.div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
}
