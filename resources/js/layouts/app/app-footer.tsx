import { Mail, MapPin, Phone, Users } from 'lucide-react';

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
                            <span className="text-xl font-bold">Asociación Pro</span>
                        </div>
                        <p className="leading-relaxed text-slate-300">
                            Construyendo el futuro profesional a través de la excelencia, innovación y colaboración.
                        </p>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Enlaces Rápidos</h3>
                        <div className="space-y-2">
                            <a href="#inicio" className="block text-slate-300 transition-colors hover:text-white">
                                Inicio
                            </a>
                            <a href="#historia" className="block text-slate-300 transition-colors hover:text-white">
                                Historia
                            </a>
                            <a href="#mision" className="block text-slate-300 transition-colors hover:text-white">
                                Misión y Visión
                            </a>
                            <a href="#objetivos" className="block text-slate-300 transition-colors hover:text-white">
                                Objetivos
                            </a>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Servicios</h3>
                        <div className="space-y-2">
                            <p className="text-slate-300">Desarrollo Profesional</p>
                            <p className="text-slate-300">Networking</p>
                            <p className="text-slate-300">Certificaciones</p>
                            <p className="text-slate-300">Eventos Exclusivos</p>
                        </div>
                    </div>

                    <div className="space-y-4">
                        <h3 className="text-lg font-semibold">Contacto</h3>
                        <div className="space-y-3">
                            <div className="flex items-center space-x-3">
                                <Mail className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">info@asociacionpro.com</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <Phone className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">+1 (555) 123-4567</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <MapPin className="h-5 w-5 text-blue-400" />
                                <span className="text-slate-300">Ciudad Empresarial, CP 12345</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="mt-12 border-t border-slate-700 pt-8 text-center">
                    <p className="text-slate-300">© {new Date().getFullYear()} Asociación Pro. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    );
}
