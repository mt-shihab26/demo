import type { TLogin, TLogout, TRegister } from '@/queries/auth';
import type { TUser } from '@/types/models';
import type { ReactNode } from 'react';

import { useAuthQuery } from '@/queries/auth';
import { router } from 'expo-router';
import { createContext, useContext, useEffect } from 'react';

import { ActivityIndicator, View } from 'react-native';

type TAuthContext = {
    user: TUser | null;
    register: TRegister;
    login: TLogin;
    logout: TLogout;
};

const AuthContext = createContext<TAuthContext | null>(null);

export const AuthProvider = ({ children }: { children: ReactNode }) => {
    const { fetchUser, register, login, logout } = useAuthQuery();

    const { data: user, isLoading, isError } = fetchUser();

    useEffect(() => {
        if (isError || (!isLoading && !user)) {
            router.push('/login');
        }
    }, [isError, isLoading, user]);

    return (
        <AuthContext.Provider
            value={{
                user: user ?? null,
                register,
                login,
                logout,
            }}
        >
            {isLoading ? (
                <View className="bg-background flex-1 items-center justify-center">
                    <ActivityIndicator size="large" />
                </View>
            ) : (
                children
            )}
        </AuthContext.Provider>
    );
};

export const useAuth = (): TAuthContext => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within AuthProvider');
    }
    return context;
};
