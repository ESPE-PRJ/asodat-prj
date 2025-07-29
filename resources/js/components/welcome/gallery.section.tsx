import { motion } from 'motion/react';

export default function GallerySection() {
    const galleryImages = [
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
    ];

    return (
        <section id="galeria" className="overflow-hidden bg-white py-20">
            <div className="container mx-auto px-4 lg:px-6">
                <motion.div
                    className="mb-16 space-y-4 text-center"
                    initial={{ y: 40, opacity: 0 }}
                    whileInView={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.6, ease: 'easeOut' }}
                    viewport={{ once: true, amount: 0.1 }}
                >
                    <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestra Galería</h2>
                    <motion.div
                        className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                        initial={{ scaleX: 0 }}
                        whileInView={{ scaleX: 1 }}
                        transition={{ duration: 0.5, delay: 0.15, ease: 'easeOut' }}
                        viewport={{ once: true, amount: 0.1 }}
                    />
                </motion.div>
            </div>

            <div className="relative">
                <motion.div
                    className="animate-scroll flex space-x-6"
                    initial={{ x: -100, opacity: 0 }}
                    whileInView={{ x: 0, opacity: 1 }}
                    transition={{ duration: 0.8, delay: 0.25, ease: 'easeOut' }}
                    viewport={{ once: true, amount: 0.1 }}
                >
                    {[...galleryImages, ...galleryImages].map((image, index) => (
                        <motion.div
                            key={index}
                            className="relative h-60 w-80 flex-shrink-0"
                            initial={{ scale: 0.8, opacity: 0 }}
                            whileInView={{ scale: 1, opacity: 1 }}
                            transition={{
                                duration: 0.5,
                                delay: 0.35 + index * 0.05,
                                ease: 'easeOut',
                            }}
                            viewport={{ once: true, amount: 0.1 }}
                            whileHover={{
                                scale: 1.05,
                                y: -10,
                                transition: { duration: 0.3 },
                            }}
                        >
                            <img
                                src={image || '/placeholder.svg'}
                                alt={`Galería ${index + 1}`}
                                width={320}
                                height={240}
                                className="h-full w-full rounded-xl object-cover shadow-lg"
                            />
                            <motion.div
                                className="absolute inset-0 rounded-xl bg-gradient-to-t from-blue-900/50 to-transparent opacity-0"
                                whileHover={{ opacity: 1 }}
                                transition={{ duration: 0.3 }}
                            />
                        </motion.div>
                    ))}
                </motion.div>
            </div>
        </section>
    );
}
