import type { TUser } from '@/types/models';
import type { UseMutationResult } from '@tanstack/react-query';

import { client } from '@/lib/client';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { router } from 'expo-router';

import { QUERY_KEYS } from '@/lib/keys';

export type TLogin = UseMutationResult<void, null, { email: string; password: string }>;
export type TRegister = UseMutationResult<void, null, { name: string; email: string; password: string }>;
export type TLogout = UseMutationResult<void, unknown, void>;

const csrf = async () => {
    return client.get('/sanctum/csrf-cookie');
};

export const useAuthQuery = () => {
    const query = useQueryClient();

    const fetchUser = () => {
        return useQuery({
            queryKey: QUERY_KEYS.user,
            retry: false,
            queryFn: async () => {
                try {
                    const response = await client.get<TUser>('/api/user');
                    return response.data;
                } catch (e: any) {
                    console.error('Error:', e);
                    throw e;
                }
            },
        });
    };

    const register: TRegister = useMutation({
        mutationFn: async (payload) => {
            await csrf();
            const response = await client.post('/register', payload);
            return response.data;
        },
        onSuccess: () => {
            query.invalidateQueries({ queryKey: QUERY_KEYS.user });
        },
    });

    const login: TLogin = useMutation({
        mutationFn: async (payload) => {
            await csrf();
            const response = await client.post('/login', payload);
            return response.data;
        },
        onSuccess: () => {
            query.invalidateQueries({ queryKey: QUERY_KEYS.user });
        },
    });

    const logout: TLogout = useMutation({
        mutationFn: async () => {
            await client.post('/logout');
        },
        onSuccess: () => {
            query.setQueryData(QUERY_KEYS.user, null);
            router.push('/login');
        },
    });

    return {
        fetchUser,
        register,
        login,
        logout,
    };
};
