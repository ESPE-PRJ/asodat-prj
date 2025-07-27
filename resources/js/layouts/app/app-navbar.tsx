import { Button } from '@/components/ui/button';
import { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Menu, Users, X } from 'lucide-react';
import { useState } from 'react';

export default function AppNavbar() {
    const { auth } = usePage<SharedData>().props;

    const [isMenuOpen, setIsMenuOpen] = useState(false);

    return (
        <nav className="fixed top-0 z-50 w-full border-b border-blue-100 bg-white/95 backdrop-blur-md transition-all duration-300">
            <div className="container mx-auto px-4 lg:px-6">
                <div className="flex h-16 items-center justify-between">
                    <div className="flex items-center space-x-2">
                        <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-800">
                            <Users className="h-6 w-6 text-white" />
                        </div>
                        <span className="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-xl font-bold text-transparent">ASODAT</span>
                    </div>

                    <div className="hidden items-center space-x-8 md:flex">
                        <a href="#inicio" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                            Inicio
                        </a>
                        <a href="#historia" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                            Servicios
                        </a>
                        <a href="#beneficios" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                            Beneficios
                        </a>
                        <Link href="/afiliacion" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                            Afiliación
                        </Link>
                        <Link href="/noticias" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                            Noticias
                        </Link>
                        <a href="/admin">
                            <Button>{auth.user ? 'Dashboard' : 'Log in'}</Button>
                        </a>
                    </div>

                    <Button className="md:hidden" onClick={() => setIsMenuOpen(!isMenuOpen)}>
                        {isMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
                    </Button>
                </div>

                {/* Mobile Menu */}
                {isMenuOpen && (
                    <div className="absolute top-16 right-0 left-0 border-b border-blue-100 bg-white shadow-lg md:hidden">
                        <div className="flex flex-col space-y-4 p-4">
                            <a href="#inicio" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                                Inicio
                            </a>
                            <a href="#historia" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                                Servicios
                            </a>
                            <a href="#beneficios" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                                Beneficios
                            </a>
                            <Link href="/afiliacion" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                                Afiliación
                            </Link>
                            <Link href="/noticias" className="font-medium text-slate-700 transition-colors hover:text-blue-600">
                                Noticias
                            </Link>
                            <a href="/admin">
                                <Button>{auth.user ? 'Dashboard' : 'Log in'}</Button>
                            </a>
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
}
