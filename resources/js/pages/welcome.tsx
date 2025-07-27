import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Award, ChevronRight, Heart, Shield, Star, Target, Users } from 'lucide-react';
import { useEffect, useState } from 'react';

export default function Welcome() {
    const [isVisible, setIsVisible] = useState<{
        inicio?: boolean;
        historia?: boolean;
        mision?: boolean;
        objetivos?: boolean;
        beneficios?: boolean;
        galeria?: boolean;
    }>({});

    useEffect(() => {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setIsVisible((prev) => ({
                            ...prev,
                            [entry.target.id]: true,
                        }));
                    }
                });
            },
            { threshold: 0.1 },
        );

        const sections = document.querySelectorAll('section[id]');
        sections.forEach((section) => observer.observe(section));

        return () => observer.disconnect();
    }, []);

    const objectives = [
        {
            title: 'Desarrollo Profesional',
            description: 'Promover el crecimiento y desarrollo continuo de nuestros miembros a través de programas especializados.',
            icon: Target,
        },
        {
            title: 'Networking Estratégico',
            description: 'Facilitar conexiones valiosas entre profesionales del sector para crear oportunidades de colaboración.',
            icon: Users,
        },
        {
            title: 'Excelencia Operativa',
            description: 'Establecer estándares de calidad y mejores prácticas en la industria.',
            icon: Award,
        },
    ];

    const benefits = [
        {
            title: 'Acceso Exclusivo',
            description: 'Recursos, eventos y oportunidades disponibles únicamente para miembros de la asociación.',
            icon: Shield,
        },
        {
            title: 'Comunidad Activa',
            description: 'Forma parte de una red de profesionales comprometidos con la excelencia y el crecimiento mutuo.',
            icon: Heart,
        },
        {
            title: 'Reconocimiento',
            description: 'Certificaciones y reconocimientos que validan tu expertise y compromiso profesional.',
            icon: Star,
        },
    ];

    const galleryImages = [
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
        'https://picsum.photos/200/300.webp',
    ];

    return (
        <AppLayout title="Inicio">
            {/* Hero Section */}
            <section id="inicio" className="relative flex min-h-screen items-center overflow-hidden pt-16">
                <div className="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-blue-600/10"></div>
                <div className="relative z-10 container mx-auto px-4 lg:px-6">
                    <div className="grid items-center gap-12 lg:grid-cols-2">
                        <div
                            className={`space-y-8 transition-all duration-1000 ${isVisible.inicio ? 'translate-x-0 opacity-100' : '-translate-x-10 opacity-0'}`}
                        >
                            <div className="space-y-4">
                                <h1 className="text-4xl leading-tight font-bold text-slate-800 md:text-6xl">
                                    Construyendo el
                                    <span className="block bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                        Futuro Profesional
                                    </span>
                                </h1>
                                <p className="text-xl leading-relaxed text-slate-600">
                                    Únete a la asociación líder que impulsa la excelencia, fomenta la innovación y conecta a los mejores profesionales
                                    del sector.
                                </p>
                            </div>
                            <div className="flex flex-col gap-4 sm:flex-row">
                                <Button
                                    size="lg"
                                    className="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 text-lg text-white hover:from-blue-700 hover:to-blue-800"
                                >
                                    Conoce Más
                                    <ChevronRight className="ml-2 h-5 w-5" />
                                </Button>
                                <Button
                                    size="lg"
                                    variant="outline"
                                    className="border-blue-600 bg-transparent px-8 py-3 text-lg text-blue-600 hover:bg-blue-50"
                                >
                                    Ver Galería
                                </Button>
                            </div>
                        </div>
                        <div
                            className={`relative transition-all delay-300 duration-1000 ${isVisible.inicio ? 'translate-x-0 opacity-100' : 'translate-x-10 opacity-0'}`}
                        >
                            <div className="relative">
                                <img
                                    src="https://picsum.photos/500/600.webp"
                                    alt="Asociación Profesional"
                                    width={500}
                                    height={600}
                                    className="rounded-2xl shadow-2xl"
                                />
                                <div className="absolute inset-0 rounded-2xl bg-gradient-to-t from-blue-900/20 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Historia Section */}
            <section id="historia" className="bg-white py-20">
                <div className="container mx-auto px-4 lg:px-6">
                    <div
                        className={`mx-auto max-w-4xl space-y-8 text-center transition-all duration-1000 ${isVisible.historia ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}
                    >
                        <div className="space-y-4">
                            <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestra Historia</h2>
                            <div className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
                        </div>
                        <div className="grid items-center gap-12 md:grid-cols-2">
                            <div className="space-y-6 text-left">
                                <p className="text-lg leading-relaxed text-slate-600">
                                    Fundada en 1995, nuestra asociación nació de la visión compartida de un grupo de profesionales comprometidos con
                                    la excelencia y el desarrollo continuo del sector.
                                </p>
                                <p className="text-lg leading-relaxed text-slate-600">
                                    Durante más de 25 años, hemos sido pioneros en establecer estándares de calidad, promover la innovación y crear
                                    oportunidades de crecimiento para miles de profesionales.
                                </p>
                                <p className="text-lg leading-relaxed text-slate-600">
                                    Hoy, somos reconocidos como la asociación líder en el sector, con más de 10,000 miembros activos y una red global
                                    de colaboradores estratégicos.
                                </p>
                            </div>
                            <div className="relative">
                                <img
                                    src="https://picsum.photos/500/400.webp"
                                    alt="Historia de la Asociación"
                                    width={500}
                                    height={400}
                                    className="rounded-xl shadow-lg"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Misión y Visión Section */}
            <section id="mision" className="bg-gradient-to-br from-blue-50 to-slate-50 py-20">
                <div className="container mx-auto px-4 lg:px-6">
                    <div
                        className={`space-y-16 text-center transition-all duration-1000 ${isVisible.mision ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}
                    >
                        <div className="space-y-4">
                            <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Misión y Visión</h2>
                            <div className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
                        </div>

                        <div className="mx-auto grid max-w-6xl gap-8 md:grid-cols-2">
                            <Card className="group border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                                <CardContent className="space-y-6 p-8 text-center">
                                    <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800 transition-transform duration-300 group-hover:scale-110">
                                        <Target className="h-8 w-8 text-white" />
                                    </div>
                                    <h3 className="text-2xl font-bold text-slate-800">Misión</h3>
                                    <p className="leading-relaxed text-slate-600">
                                        Empoderar a los profesionales del sector mediante programas de desarrollo, networking estratégico y acceso a
                                        recursos de vanguardia, promoviendo la excelencia y la innovación continua.
                                    </p>
                                </CardContent>
                            </Card>

                            <Card className="group border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                                <CardContent className="space-y-6 p-8 text-center">
                                    <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800 transition-transform duration-300 group-hover:scale-110">
                                        <Star className="h-8 w-8 text-white" />
                                    </div>
                                    <h3 className="text-2xl font-bold text-slate-800">Visión</h3>
                                    <p className="leading-relaxed text-slate-600">
                                        Ser la asociación profesional de referencia a nivel global, reconocida por liderar la transformación del
                                        sector y por formar a los profesionales más competentes y éticos del mercado.
                                    </p>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>
            </section>

            {/* Objetivos Section */}
            <section id="objetivos" className="bg-white py-20">
                <div className="container mx-auto px-4 lg:px-6">
                    <div
                        className={`space-y-16 transition-all duration-1000 ${isVisible.objetivos ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}
                    >
                        <div className="space-y-4 text-center">
                            <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestros Objetivos</h2>
                            <div className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
                            <p className="mx-auto max-w-3xl text-xl text-slate-600">
                                Trabajamos constantemente para alcanzar metas ambiciosas que beneficien a toda nuestra comunidad profesional.
                            </p>
                        </div>

                        <div className="grid gap-8 md:grid-cols-3">
                            {objectives.map((objective, index) => (
                                <Card
                                    key={index}
                                    className="group border-0 bg-gradient-to-br from-white to-blue-50/50 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                                >
                                    <CardContent className="space-y-6 p-8 text-center">
                                        <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800 transition-transform duration-300 group-hover:scale-110">
                                            <objective.icon className="h-8 w-8 text-white" />
                                        </div>
                                        <h3 className="text-xl font-bold text-slate-800">{objective.title}</h3>
                                        <p className="leading-relaxed text-slate-600">{objective.description}</p>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* Beneficios Section */}
            <section id="beneficios" className="bg-gradient-to-br from-slate-50 to-blue-50 py-20">
                <div className="container mx-auto px-4 lg:px-6">
                    <div
                        className={`space-y-16 transition-all duration-1000 ${isVisible.beneficios ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}
                    >
                        <div className="space-y-4 text-center">
                            <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Beneficios Exclusivos</h2>
                            <div className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
                            <p className="mx-auto max-w-3xl text-xl text-slate-600">
                                Descubre las ventajas únicas que ofrecemos a nuestros miembros para impulsar su crecimiento profesional.
                            </p>
                        </div>

                        <div className="grid gap-8 md:grid-cols-3">
                            {benefits.map((benefit, index) => (
                                <Card
                                    key={index}
                                    className="group border-0 bg-white/80 shadow-lg backdrop-blur-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                                >
                                    <CardContent className="space-y-6 p-8 text-center">
                                        <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-800 transition-transform duration-300 group-hover:scale-110">
                                            <benefit.icon className="h-8 w-8 text-white" />
                                        </div>
                                        <h3 className="text-xl font-bold text-slate-800">{benefit.title}</h3>
                                        <p className="leading-relaxed text-slate-600">{benefit.description}</p>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* Galería Section */}
            <section id="galeria" className="overflow-hidden bg-white py-20">
                <div className="container mx-auto px-4 lg:px-6">
                    <div className="mb-16 space-y-4 text-center">
                        <h2 className="text-3xl font-bold text-slate-800 md:text-5xl">Nuestra Galería</h2>
                        <div className="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
                    </div>
                </div>

                <div className="relative">
                    <div className="animate-scroll flex space-x-6">
                        {[...galleryImages, ...galleryImages].map((image, index) => (
                            <div key={index} className="group relative h-60 w-80 flex-shrink-0">
                                <img
                                    src={image || '/placeholder.svg'}
                                    alt={`Galería ${index + 1}`}
                                    width={320}
                                    height={240}
                                    className="h-full w-full rounded-xl object-cover shadow-lg transition-transform duration-300 group-hover:scale-105"
                                />
                                <div className="absolute inset-0 rounded-xl bg-gradient-to-t from-blue-900/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
