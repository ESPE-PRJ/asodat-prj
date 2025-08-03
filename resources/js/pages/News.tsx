import AppLayout from '@/layouts/app-layout';
import { ArrowRight, Calendar, FileText, Star, Users } from 'lucide-react';
import { motion } from 'motion/react';

interface Noticia {
    id: number;
    titulo: string;
    contenido: string;
    categoria: string;
    imagen_path?: string;
    publicar_desde: string;
    publicar_hasta?: string;
}

interface Props {
    noticias: Noticia[];
}

export default function NewsPage({ noticias }: Props) {
    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    const getCategoryColor = (categoria: string) => {
        const colors = {
            Eventos: 'from-blue-600 to-blue-700 bg-blue-50 border-blue-200',
            Anuncios: 'from-green-600 to-green-700 bg-green-50 border-green-200',
            Noticias: 'from-purple-600 to-purple-700 bg-purple-50 border-purple-200',
            Comunicados: 'from-orange-600 to-orange-700 bg-orange-50 border-orange-200',
            General: 'from-gray-600 to-gray-700 bg-gray-50 border-gray-200',
        };
        return colors[categoria as keyof typeof colors] || colors['General'];
    };

    const getCategoryIcon = (categoria: string) => {
        const icons = {
            Eventos: Users,
            Anuncios: FileText,
            Noticias: Star,
            Comunicados: FileText,
            General: FileText,
        };
        return icons[categoria as keyof typeof icons] || FileText;
    };

    return (
        <AppLayout title="Noticias">
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
                            className="flex min-h-[40vh] flex-col justify-center space-y-8 text-center"
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
                                    <FileText className="mr-2 h-3 w-3 text-blue-600" />
                                    <span className="text-xs font-medium text-blue-700">Información actualizada</span>
                                </motion.div>

                                <h1 className="text-3xl font-bold text-slate-800 md:text-4xl lg:text-5xl">
                                    <span className="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 bg-clip-text text-transparent">
                                        NOTICIAS
                                    </span>
                                    <br />
                                    <span className="text-slate-700">Y COMUNICADOS</span>
                                </h1>

                                <motion.div
                                    className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800"
                                    initial={{ scaleX: 0 }}
                                    whileInView={{ scaleX: 1 }}
                                    transition={{ duration: 0.8, delay: 0.3, ease: 'easeOut' }}
                                    viewport={{ once: true, amount: 0.1 }}
                                />

                                <p className="mx-auto max-w-2xl text-base leading-relaxed text-slate-600">
                                    Mantente informado sobre las últimas noticias, eventos y comunicados de nuestra asociación.
                                </p>
                            </div>
                        </motion.div>

                        {/* Noticias Grid */}
                        {noticias.length > 0 ? (
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
                                {noticias.map((noticia) => {
                                    const CategoryIcon = getCategoryIcon(noticia.categoria);
                                    const colorClasses = getCategoryColor(noticia.categoria).split(' ');

                                    return (
                                        <motion.div
                                            key={noticia.id}
                                            variants={{
                                                hidden: { y: 80, opacity: 0 },
                                                visible: { y: 0, opacity: 1 },
                                            }}
                                            transition={{ duration: 0.8, ease: 'easeOut' }}
                                            className={`relative overflow-hidden rounded-2xl border bg-white/95 backdrop-blur-sm transition-all duration-500 hover:scale-[1.01] hover:shadow-lg ${colorClasses[2]} ${colorClasses[3]}`}
                                        >
                                            <div className="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-white/20"></div>
                                            <div className="relative p-6">
                                                <div className="grid items-start gap-6 lg:grid-cols-3">
                                                    {/* Imagen */}
                                                    {noticia.imagen_path && (
                                                        <div className="lg:col-span-1">
                                                            <motion.div
                                                                className="h-48 w-full overflow-hidden rounded-xl lg:h-64"
                                                                whileHover={{ scale: 1.02 }}
                                                                transition={{ duration: 0.3 }}
                                                            >
                                                                <img
                                                                    src={noticia.imagen_path}
                                                                    alt={noticia.titulo}
                                                                    className="h-full w-full object-cover"
                                                                />
                                                            </motion.div>
                                                        </div>
                                                    )}

                                                    {/* Contenido */}
                                                    <div className={`space-y-4 ${noticia.imagen_path ? 'lg:col-span-2' : 'lg:col-span-3'}`}>
                                                        {/* Header */}
                                                        <div className="space-y-3">
                                                            <div className="flex items-center justify-between">
                                                                <motion.div
                                                                    className={`inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br ${colorClasses[0]} ${colorClasses[1]} shadow-md`}
                                                                    whileHover={{ scale: 1.1, rotate: -5 }}
                                                                    transition={{ duration: 0.3 }}
                                                                >
                                                                    <CategoryIcon className="h-6 w-6 text-white" />
                                                                </motion.div>
                                                                <div className="flex items-center space-x-2 text-xs text-slate-500">
                                                                    <Calendar className="h-3 w-3" />
                                                                    <span>{formatDate(noticia.publicar_desde)}</span>
                                                                </div>
                                                            </div>

                                                            <div className="space-y-2">
                                                                <h3 className="text-xl font-bold text-slate-800">{noticia.titulo}</h3>
                                                                <div className="flex items-center space-x-4">
                                                                    <span
                                                                        className={`inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ${colorClasses[0]} ${colorClasses[1]} bg-opacity-10 text-opacity-80`}
                                                                    >
                                                                        {noticia.categoria}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {/* Contenido */}
                                                        <div className="space-y-4">
                                                            <p className="line-clamp-3 text-sm leading-relaxed text-slate-600">{noticia.contenido}</p>

                                                            <motion.div
                                                                className="flex cursor-pointer items-center space-x-2 font-semibold text-blue-600"
                                                                whileHover={{ x: 5 }}
                                                                transition={{ duration: 0.3 }}
                                                            >
                                                                <span className="text-sm">Leer más</span>
                                                                <ArrowRight className="h-3 w-3" />
                                                            </motion.div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </motion.div>
                                    );
                                })}
                            </motion.div>
                        ) : (
                            /* Estado vacío */
                            <motion.div
                                className="space-y-8 text-center"
                                initial={{ y: 40, opacity: 0 }}
                                whileInView={{ y: 0, opacity: 1 }}
                                transition={{ duration: 0.8, delay: 0.5, ease: 'easeOut' }}
                                viewport={{ once: true, amount: 0.1 }}
                            >
                                <div className="space-y-6">
                                    <motion.div
                                        className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-blue-100"
                                        initial={{ scale: 0.8, opacity: 0 }}
                                        whileInView={{ scale: 1, opacity: 1 }}
                                        transition={{ duration: 0.6, delay: 0.6, ease: 'easeOut' }}
                                        viewport={{ once: true, amount: 0.1 }}
                                    >
                                        <FileText className="h-10 w-10 text-blue-600" />
                                    </motion.div>

                                    <div className="space-y-4">
                                        <h2 className="text-2xl font-bold text-slate-800">No hay noticias disponibles</h2>
                                        <p className="mx-auto max-w-md text-sm text-slate-600">
                                            En este momento no hay noticias publicadas. Vuelve más tarde para ver las últimas actualizaciones.
                                        </p>
                                    </div>
                                </div>
                            </motion.div>
                        )}
                    </motion.div>
                </div>
            </section>
        </AppLayout>
    );
}
