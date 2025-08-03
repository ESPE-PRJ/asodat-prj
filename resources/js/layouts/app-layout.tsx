import AppSimpleLayout from './app/app-layout-template';

export default function AppLayout({ children, title, ...props }: { children: React.ReactNode; title: string; description?: string }) {
    return (
        <AppSimpleLayout title={title} {...props}>
            {children}
        </AppSimpleLayout>
    );
}
