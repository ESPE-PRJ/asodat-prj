import { Link } from '@inertiajs/react';
import { Mail, MapPin, Users } from 'lucide-react';

export default function AppFooter() {
    return (
        <footer className="bg-gradient-to-br from-slate-800 to-slate-900 py-16 text-white">
            <div className="container mx-auto px-4 lg:px-6">
                <div className="grid gap-8 md:grid-cols-4">
                    <div className="space-y-4">
                        <div className="flex items-center space-x-2">
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-800">
                                <Users className="h-6 w-6 text-white" />
                            </div>
                            <span className="text-xl font-bold">ASODAT</span>
                        </div>
                        <p className="leading-relaxed text-slate-300">
                            Construyendo el futuro profesional a través de la excelencia, innovación y colaboración.
                        </p>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Enlaces Rápidos</h3>
                        <div className="space-y-2">
                            <a href="/#inicio" className="block text-slate-300 transition-colors hover:text-white">
                                Inicio
                            </a>
                            <a href="/#historia" className="block text-slate-300 transition-colors hover:text-white">
                                Historia
                            </a>
                            <a href="/#mision" className="block text-slate-300 transition-colors hover:text-white">
                                Misión y Visión
                            </a>
                            <a href="/#objetivos" className="block text-slate-300 transition-colors hover:text-white">
                                Objetivos
                            </a>
                            <a href="/#galeria" className="block text-slate-300 transition-colors hover:text-white">
                                Galería
                            </a>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Recursos</h3>
                        <div className="space-y-2">
                            <Link href={route('services')} className="block text-slate-300 transition-colors hover:text-white">
                                Servicios
                            </Link>
                            <Link href={route('memberships')} className="block text-slate-300 transition-colors hover:text-white">
                                Afiliación
                            </Link>
                            <Link href={route('news')} className="block text-slate-300 transition-colors hover:text-white">
                                Noticias
                            </Link>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Contacto</h3>
                        <div className="space-y-3">
                            <div className="flex items-center space-x-3">
                                <Mail className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">asodat@espe.edu.ec</span>
                            </div>
                            {/* <div className="flex items-center space-x-3">
                                <Phone className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">+1 (555) 123-4567</span>
                            </div> */}
                            <div className="flex items-center space-x-3">
                                <MapPin className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">Universidad de las Fuerzas Armadas ESPE - Sede Latacunga</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="mt-12 border-t border-slate-700 pt-8 text-center">
                    <p className="text-slate-300">
                        © {new Date().getFullYear()} ASODAT - Asociación de Docentes, Personal Administrativo y Trabajadores de la ESPE sede
                        Latacunga.
                    </p>
                </div>
            </div>
        </footer>
    );
}
