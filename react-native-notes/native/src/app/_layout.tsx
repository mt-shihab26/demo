import './../../global.css';

import { AuthProvider } from '@/providers/auth';
import { QueryProvider } from '@/providers/query';
import { ThemeProvider } from '@/providers/theme';
import { PortalHost } from '@rn-primitives/portal';
import { Stack } from 'expo-router';

// Catch any errors thrown by the Layout component.
export { ErrorBoundary } from 'expo-router';

const Layout = () => {
    return (
        <QueryProvider>
            <AuthProvider>
                <ThemeProvider>
                    <Stack>
                        <Stack.Screen name="(tabs)" options={{ headerShown: false }} />
                        <Stack.Screen name="(auth)" options={{ headerShown: false }} />
                    </Stack>
                    <PortalHost />
                </ThemeProvider>
            </AuthProvider>
        </QueryProvider>
    );
};

export default Layout;
