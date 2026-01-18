import { ThemeSwitcher } from '@/components/elements/theme-switcher';
import { AuthGuard } from '@/components/guards/auth-guard';
import { View } from 'react-native';

const Index = () => {
    return (
        <AuthGuard>
            <View className="flex-1 items-center justify-center">
                <ThemeSwitcher />
            </View>
        </AuthGuard>
    );
};

export default Index;
