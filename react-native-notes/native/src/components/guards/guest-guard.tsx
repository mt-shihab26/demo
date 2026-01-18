import type { Href } from 'expo-router';
import type { ReactNode } from 'react';

import { Redirect } from 'expo-router';

import { useAuth } from '@/providers/auth';

export const GuestGuard = ({ children, redirect = '/' }: { children: ReactNode; redirect?: Href }) => {
    const { user } = useAuth();

    // Redirect to home if user is already authenticated
    if (user) {
        return <Redirect href={redirect} />;
    }

    return <>{children}</>;
};
