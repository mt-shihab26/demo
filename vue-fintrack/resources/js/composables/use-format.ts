import type { TAppProps } from '@/types';

import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export const useFormat = () => {
    const page = usePage<TAppProps>();

    const currency = computed(() => {
        return (amount: number) => {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: page.props.auth.user.currency,
                currencyDisplay: 'narrowSymbol',
            }).format(amount);
        };
    });

    return {
        currency,
    };
};
