import { Head } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';
import AppFooter from './app-footer';
import AppNavbar from './app-navbar';

interface AppLayoutProps {
    name?: string;
    title?: string;
    description?: string;
}

export default function AppSimpleLayout({ ...props }: PropsWithChildren<AppLayoutProps>) {
    return (
        <>
            <Head title={props.title} />
            <div className="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
                <AppNavbar />
                {props.children}
                <AppFooter />
            </div>
        </>
    );
}
