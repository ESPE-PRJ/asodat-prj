import AppLayout from '@/layouts/app-layout';

export default function ServicesPage() {
    return (
        <AppLayout title="Servicios">
            <div className="container mx-auto px-4 py-8">
                <h1 className="mb-6 text-3xl font-bold text-gray-900">Servicios</h1>

                <div className="rounded-lg bg-white p-6 shadow">
                    <p className="text-gray-600">Esta es tu página de servicios. Aquí puedes agregar las funciones que necesites.</p>
                </div>
            </div>
        </AppLayout>
    );
}
