import { ChevronRight } from 'lucide-react';
import { motion } from 'motion/react';
import { Button } from '../ui/button';

export default function HeroSection() {
    return (
        <section id="inicio" className="relative flex min-h-screen items-center overflow-hidden pt-16">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-blue-600/10"></div>
            <div className="relative z-10 container mx-auto px-4 lg:px-6">
                <div className="grid items-center gap-12 lg:grid-cols-2">
                    <motion.div
                        className="space-y-8"
                        initial={{ x: -40, opacity: 0 }}
                        whileInView={{ x: 0, opacity: 1 }}
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
                            <h1 className="text-4xl leading-tight font-bold text-slate-800 md:text-6xl">
                                Construyendo el
                                <span className="block bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                    Futuro Profesional
                                </span>
                            </h1>
                            <p className="text-xl leading-relaxed text-slate-600">
                                Únete a la asociación líder que impulsa la excelencia, fomenta la innovación y conecta a los mejores profesionales del
                                sector.
                            </p>
                        </motion.div>
                        <motion.div
                            className="flex flex-col gap-4 sm:flex-row"
                            initial={{ y: 20, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.2, ease: 'easeOut' }}
                            viewport={{ once: true, amount: 0.1 }}
                        >
                            <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                                <a href="#historia">
                                    <Button size="lg">
                                        Conoce Más
                                        <ChevronRight className="ml-2 h-5 w-5" />
                                    </Button>
                                </a>
                            </motion.div>
                        </motion.div>
                    </motion.div>
                    <motion.div
                        className="relative"
                        initial={{ x: 40, opacity: 0 }}
                        whileInView={{ x: 0, opacity: 1 }}
                        transition={{ duration: 0.6, delay: 0.15, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    >
                        <motion.div className="relative" whileHover={{ scale: 1.02 }} transition={{ duration: 0.3 }}>
                            <img
                                src="https://picsum.photos/700/400.webp"
                                alt="Asociación Profesional"
                                width={700}
                                height={400}
                                className="rounded-2xl shadow-2xl"
                            />
                        </motion.div>
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
