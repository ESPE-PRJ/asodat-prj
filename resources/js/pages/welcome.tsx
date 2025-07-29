import BenefitsSection from '@/components/welcome/benefits.section';
import GallerySection from '@/components/welcome/gallery.section';
import GoalsSection from '@/components/welcome/goals.section';
import HeroSection from '@/components/welcome/hero.section';
import HistorySection from '@/components/welcome/history.section';
import TargetSection from '@/components/welcome/targets.section';
import AppLayout from '@/layouts/app-layout';

export default function Welcome() {
    return (
        <AppLayout title="Inicio">
            <HeroSection />
            <HistorySection />
            <TargetSection />
            <GoalsSection />
            <BenefitsSection />
            <GallerySection />
        </AppLayout>
    );
}
