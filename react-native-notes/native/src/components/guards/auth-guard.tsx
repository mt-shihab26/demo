import type { Href } from 'expo-router';
import type { ReactNode } from 'react';

import { Redirect } from 'expo-router';

import { useAuth } from '@/providers/auth';

export const AuthGuard = ({ children, redirect = '/login' }: { children: ReactNode; redirect?: Href }) => {
    const { user } = useAuth();

    // Redirect to login if user is not authenticated
    if (!user) {
        return <Redirect href={redirect} />;
    }

    return <>{children}</>;
};
