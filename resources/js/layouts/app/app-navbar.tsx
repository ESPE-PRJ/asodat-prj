import { Button } from '@/components/ui/button';
import { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Menu, Users, X } from 'lucide-react';
import { useState } from 'react';

export default function AppNavbar() {
    const { auth } = usePage<SharedData>().props;

    const [isMenuOpen, setIsMenuOpen] = useState(false);

    return (
        <nav className="fixed top-0 z-50 w-full bg-gradient-to-br from-slate-800 to-slate-900 backdrop-blur-md transition-all duration-300">
            <div className="container mx-auto px-4 lg:px-6">
                <div className="flex h-16 items-center justify-between">
                    <div className="flex items-center space-x-2">
                        <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-800">
                            <Users className="h-6 w-6 text-white" />
                        </div>
                        <span className="text-xl font-bold text-white">ASODAT</span>
                    </div>

                    <div className="hidden items-center space-x-8 md:flex">
                        <a href="/#inicio" className="font-medium text-slate-300 transition-colors hover:text-white">
                            Inicio
                        </a>
                        <Link href={route('services')} className="font-medium text-slate-300 transition-colors hover:text-white">
                            Servicios
                        </Link>
                        <Link href={route('memberships')} className="font-medium text-slate-300 transition-colors hover:text-white">
                            Afiliación
                        </Link>
                        <Link href={route('news')} className="font-medium text-slate-300 transition-colors hover:text-white">
                            Noticias
                        </Link>
                        <a href="/sys">
                            <Button>{auth.user ? 'Dashboard' : 'Iniciar sesión'}</Button>
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
                            <a href="/#inicio" className="font-medium text-slate-300 transition-colors hover:text-white">
                                Inicio
                            </a>
                            <Link href={route('services')} className="font-medium text-slate-300 transition-colors hover:text-white">
                                Servicios
                            </Link>
                            <Link href={route('memberships')} className="font-medium text-slate-300 transition-colors hover:text-white">
                                Afiliación
                            </Link>
                            <Link href={route('news')} className="font-medium text-slate-300 transition-colors hover:text-white">
                                Noticias
                            </Link>
                            <a href="/sys">
                                <Button>{auth.user ? 'Dashboard' : 'Iniciar sesión'}</Button>
                            </a>
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
}
