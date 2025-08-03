import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import AppLayout from '@/layouts/app-layout';
import { FileText, Star, Users, X } from 'lucide-react';
import { motion } from 'motion/react';
import { useEffect, useState } from 'react';

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
    const [selectedNoticia, setSelectedNoticia] = useState<Noticia | null>(noticias.length > 0 ? noticias[0] : null);
    const [searchTerm, setSearchTerm] = useState('');
    const [isMobile, setIsMobile] = useState(false);
    const [mobileDialogOpen, setMobileDialogOpen] = useState(false);

    useEffect(() => {
        const checkIsMobile = () => {
            setIsMobile(window.innerWidth < 1024);
        };

        checkIsMobile();
        window.addEventListener('resize', checkIsMobile);

        return () => window.removeEventListener('resize', checkIsMobile);
    }, []);

    useEffect(() => {
        if (selectedNoticia && isMobile) {
            setMobileDialogOpen(true);
        } else {
            setMobileDialogOpen(false);
        }
    }, [selectedNoticia, isMobile]);

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        const now = new Date();
        const diffTime = Math.abs(now.getTime() - date.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 1) return 'hace 1 día';
        if (diffDays < 7) return `hace ${diffDays} días`;
        if (diffDays < 30) return `hace ${Math.floor(diffDays / 7)} semanas`;
        if (diffDays < 365) return `hace ${Math.floor(diffDays / 30)} meses`;
        return `hace ${Math.floor(diffDays / 365)} años`;
    };

    const getCategoryColor = (categoria: string) => {
        const colors = {
            Eventos: 'bg-blue-100 text-blue-800 border-blue-200',
            Anuncios: 'bg-green-100 text-green-800 border-green-200',
            Noticias: 'bg-purple-100 text-purple-800 border-purple-200',
            Comunicados: 'bg-orange-100 text-orange-800 border-orange-200',
            General: 'bg-gray-100 text-gray-800 border-gray-200',
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

    const getInitials = (titulo: string) => {
        return titulo
            .split(' ')
            .map((word) => word[0])
            .join('')
            .toUpperCase()
            .slice(0, 2);
    };

    // Filtrar noticias basado solo en el título
    const filteredNoticias = noticias.filter((noticia) => noticia.titulo.toLowerCase().includes(searchTerm.toLowerCase()));

    return (
        <AppLayout title="Noticias">
            {/* Vista Desktop */}
            <div className="hidden h-[100dvh] bg-gradient-to-br from-blue-50 via-blue-100/50 to-blue-50 p-6 lg:flex lg:p-24">
                {/* Panel Lateral - Lista de Noticias */}
                <div className="flex w-full flex-col rounded-l-2xl border border-gray-200 bg-white/90 backdrop-blur-sm lg:w-1/3">
                    {/* Header del Panel Lateral */}
                    <div className="border-b border-gray-200 p-4 lg:p-6">
                        <div className="mb-4">
                            <h1 className="text-lg font-bold text-gray-800 lg:text-xl">Noticias</h1>
                        </div>
                        <div className="relative">
                            <input
                                type="text"
                                placeholder="Buscar noticias..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none lg:px-4 lg:py-2"
                            />
                        </div>
                    </div>

                    {/* Lista de Noticias */}
                    <div className="flex-1 overflow-y-auto p-2 lg:p-4">
                        {filteredNoticias.length > 0 ? (
                            filteredNoticias.map((noticia) => {
                                const CategoryIcon = getCategoryIcon(noticia.categoria);
                                const isSelected = selectedNoticia?.id === noticia.id;

                                return (
                                    <motion.div
                                        key={noticia.id}
                                        className={`cursor-pointer rounded-lg border border-gray-200 p-3 transition-all duration-200 lg:p-4 ${
                                            isSelected ? 'border-blue-500 bg-blue-50 shadow-md' : 'bg-white hover:border-gray-300 hover:shadow-sm'
                                        }`}
                                        onClick={() => setSelectedNoticia(noticia)}
                                        whileHover={{ scale: 1.01 }}
                                        transition={{ duration: 0.2 }}
                                    >
                                        <div className="flex items-start space-x-2 lg:space-x-3">
                                            <div className="flex-shrink-0">
                                                <div className="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-700 shadow-md lg:h-10 lg:w-10">
                                                    <span className="text-xs font-semibold text-white lg:text-sm">{getInitials(noticia.titulo)}</span>
                                                </div>
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <div className="flex items-center justify-between">
                                                    <h3 className="truncate text-xs font-medium text-gray-900 lg:text-sm">{noticia.titulo}</h3>
                                                    <span className="text-xs text-gray-500">{formatDate(noticia.publicar_desde)}</span>
                                                </div>
                                                <p className="mt-1 line-clamp-2 text-xs text-gray-600">{noticia.contenido}</p>
                                                <div className="mt-2 flex items-center space-x-2">
                                                    <span
                                                        className={`inline-flex items-center rounded-full border px-2 py-1 text-xs font-medium ${getCategoryColor(noticia.categoria)}`}
                                                    >
                                                        <CategoryIcon className="mr-1 h-3 w-3" />
                                                        {noticia.categoria}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </motion.div>
                                );
                            })
                        ) : (
                            <div className="py-8 text-center">
                                <FileText className="mx-auto mb-4 h-12 w-12 text-gray-400" />
                                <p className="text-sm text-gray-500 lg:text-base">No se encontraron noticias que coincidan con tu búsqueda.</p>
                            </div>
                        )}
                    </div>
                </div>

                {/* Panel Principal - Contenido de la Noticia */}
                <div className="hidden flex-1 flex-col rounded-r-2xl border border-gray-200 bg-white p-4 lg:flex">
                    {selectedNoticia ? (
                        <>
                            {/* Información Adicional - Compacta en la parte superior */}
                            <div className="mb-4 flex items-center justify-between rounded-lg bg-gray-50 px-4 py-2 text-xs lg:text-sm">
                                <div className="flex items-center space-x-4">
                                    <span className="font-medium text-gray-600">Categoría:</span>
                                    <span className="font-semibold text-blue-800">{selectedNoticia.categoria}</span>
                                </div>
                                <div className="flex items-center space-x-4">
                                    <span className="font-medium text-gray-600">Publicado:</span>
                                    <span className="text-gray-800">
                                        {new Date(selectedNoticia.publicar_desde).toLocaleDateString('es-ES', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric',
                                        })}
                                    </span>
                                    {selectedNoticia.publicar_hasta && (
                                        <>
                                            <span className="text-gray-400">•</span>
                                            <span className="font-medium text-gray-600">Válido hasta:</span>
                                            <span className="text-gray-800">
                                                {new Date(selectedNoticia.publicar_hasta).toLocaleDateString('es-ES', {
                                                    year: 'numeric',
                                                    month: 'short',
                                                    day: 'numeric',
                                                })}
                                            </span>
                                        </>
                                    )}
                                </div>
                            </div>

                            {/* Contenido de la Noticia */}
                            <div className="flex-1 overflow-y-auto">
                                <div className="mx-auto max-w-4xl">
                                    {/* Header de la Noticia */}
                                    <div className="mb-8">
                                        <div className="flex items-start space-x-6">
                                            <div className="flex-shrink-0">
                                                <div className="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-700 shadow-lg">
                                                    <span className="text-xl font-bold text-white">{getInitials(selectedNoticia.titulo)}</span>
                                                </div>
                                            </div>
                                            <div className="flex-1">
                                                <h1 className="mb-3 text-2xl font-bold text-gray-900 lg:text-3xl">{selectedNoticia.titulo}</h1>
                                                <div className="flex items-center space-x-4 text-sm text-gray-600">
                                                    <span className="font-medium">ASODAT</span>
                                                    <span>•</span>
                                                    <span>{formatDate(selectedNoticia.publicar_desde)}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Imagen de la Noticia */}
                                    {selectedNoticia.imagen_path && (
                                        <div className="mb-8">
                                            <img
                                                src={selectedNoticia.imagen_path}
                                                alt={selectedNoticia.titulo}
                                                className="h-64 w-full rounded-xl object-cover shadow-lg lg:h-80"
                                            />
                                        </div>
                                    )}

                                    {/* Contenido de la Noticia */}
                                    <div className="prose prose-lg max-w-none">
                                        <div className="rounded-xl bg-gray-50 p-6 lg:p-8">
                                            <p className="leading-relaxed whitespace-pre-wrap text-gray-700">{selectedNoticia.contenido}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </>
                    ) : (
                        /* Estado vacío */
                        <div className="flex flex-1 items-center justify-center">
                            <div className="text-center">
                                <FileText className="mx-auto mb-4 h-16 w-16 text-gray-400" />
                                <h2 className="mb-2 text-xl font-semibold text-gray-600">No hay noticias disponibles</h2>
                                <p className="text-gray-500">Selecciona una noticia de la lista para ver su contenido.</p>
                            </div>
                        </div>
                    )}
                </div>
            </div>

            {/* Vista Móvil - Lista simple */}
            <div className="lg:hidden">
                <div className="bg-white p-4">
                    {/* Header */}
                    <div className="mb-4">
                        <h1 className="text-xl font-bold text-gray-800">Noticias</h1>
                    </div>

                    {/* Buscador */}
                    <div className="mb-4">
                        <input
                            type="text"
                            placeholder="Buscar noticias..."
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            className="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    {/* Lista de noticias */}
                    <div className="space-y-3">
                        {filteredNoticias.length > 0 ? (
                            filteredNoticias.map((noticia) => {
                                const CategoryIcon = getCategoryIcon(noticia.categoria);
                                const isSelected = selectedNoticia?.id === noticia.id;

                                return (
                                    <motion.div
                                        key={noticia.id}
                                        className={`cursor-pointer rounded-lg border border-gray-200 p-4 transition-all duration-200 ${
                                            isSelected ? 'border-blue-500 bg-blue-50 shadow-md' : 'bg-white hover:border-gray-300 hover:shadow-sm'
                                        }`}
                                        onClick={() => setSelectedNoticia(noticia)}
                                        whileHover={{ scale: 1.01 }}
                                        transition={{ duration: 0.2 }}
                                    >
                                        <div className="flex items-start space-x-3">
                                            <div className="flex-shrink-0">
                                                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-700 shadow-md">
                                                    <span className="text-sm font-semibold text-white">{getInitials(noticia.titulo)}</span>
                                                </div>
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <div className="flex items-center justify-between">
                                                    <h3 className="truncate text-sm font-medium text-gray-900">{noticia.titulo}</h3>
                                                    <span className="text-xs text-gray-500">{formatDate(noticia.publicar_desde)}</span>
                                                </div>
                                                <p className="mt-1 line-clamp-2 text-sm text-gray-600">{noticia.contenido}</p>
                                                <div className="mt-2 flex items-center space-x-2">
                                                    <span
                                                        className={`inline-flex items-center rounded-full border px-2 py-1 text-xs font-medium ${getCategoryColor(noticia.categoria)}`}
                                                    >
                                                        <CategoryIcon className="mr-1 h-3 w-3" />
                                                        {noticia.categoria}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </motion.div>
                                );
                            })
                        ) : (
                            <div className="py-8 text-center">
                                <FileText className="mx-auto mb-4 h-12 w-12 text-gray-400" />
                                <p className="text-gray-500">No se encontraron noticias que coincidan con tu búsqueda.</p>
                            </div>
                        )}
                    </div>
                </div>

                {/* Dialog para contenido de noticia - Solo móvil */}
                <Dialog open={mobileDialogOpen} onOpenChange={setMobileDialogOpen}>
                    <DialogContent className="max-h-[90vh] overflow-y-auto bg-white p-0 sm:max-w-[95vw]">
                        <DialogHeader className="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <DialogTitle className="flex items-center justify-between text-lg font-semibold text-gray-900">
                                <span>Noticia</span>
                                <button
                                    onClick={() => setMobileDialogOpen(false)}
                                    className="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-200 hover:text-gray-700"
                                >
                                    <X className="h-5 w-5" />
                                </button>
                            </DialogTitle>
                        </DialogHeader>

                        {selectedNoticia && (
                            <div className="space-y-6 p-6">
                                {/* Metadata */}
                                <div className="flex flex-wrap items-center gap-3 rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm">
                                    <div className="flex items-center gap-2">
                                        <span className="font-medium text-gray-700">Categoría:</span>
                                        <span className="font-semibold text-blue-800">{selectedNoticia.categoria}</span>
                                    </div>
                                    <span className="text-blue-300">•</span>
                                    <div className="flex items-center gap-2">
                                        <span className="font-medium text-gray-700">Publicado:</span>
                                        <span className="text-gray-800">
                                            {new Date(selectedNoticia.publicar_desde).toLocaleDateString('es-ES', {
                                                year: 'numeric',
                                                month: 'short',
                                                day: 'numeric',
                                            })}
                                        </span>
                                    </div>
                                    {selectedNoticia.publicar_hasta && (
                                        <>
                                            <span className="text-blue-300">•</span>
                                            <div className="flex items-center gap-2">
                                                <span className="font-medium text-gray-700">Válido:</span>
                                                <span className="text-gray-800">
                                                    {new Date(selectedNoticia.publicar_hasta).toLocaleDateString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: 'numeric',
                                                    })}
                                                </span>
                                            </div>
                                        </>
                                    )}
                                </div>

                                {/* Título */}
                                <div>
                                    <h1 className="text-2xl leading-tight font-bold text-gray-900">{selectedNoticia.titulo}</h1>
                                </div>

                                {/* Autor y fecha */}
                                <div className="flex items-center gap-2 border-b border-gray-100 pb-4 text-sm text-gray-600">
                                    <span className="font-medium text-gray-700">ASODAT</span>
                                    <span className="text-gray-400">•</span>
                                    <span>{formatDate(selectedNoticia.publicar_desde)}</span>
                                </div>

                                {/* Imagen */}
                                {selectedNoticia.imagen_path && (
                                    <div className="overflow-hidden rounded-xl shadow-lg">
                                        <img src={selectedNoticia.imagen_path} alt={selectedNoticia.titulo} className="h-64 w-full object-cover" />
                                    </div>
                                )}

                                {/* Contenido */}
                                <div className="rounded-xl border border-gray-100 bg-gray-50 p-6">
                                    <p className="text-base leading-relaxed whitespace-pre-wrap text-gray-700">{selectedNoticia.contenido}</p>
                                </div>
                            </div>
                        )}
                    </DialogContent>
                </Dialog>
            </div>
        </AppLayout>
    );
}
