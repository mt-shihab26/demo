import type { TAppProps } from '@/types';

import { formatToastTimestamp } from '@/lib/format';
import { toast } from '@/lib/toast';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

export const useFlash = () => {
    const page = usePage<TAppProps>();

    watch(
        () => page.props.flash.success,
        (success) => {
            if (success?.message) {
                const timeString = success.timestamp ? formatToastTimestamp(success.timestamp) : '';
                toast.success(success.message, {
                    description: timeString ? `at ${timeString}` : undefined,
                    action: {
                        label: 'Close',
                        onClick: () => {},
                    },
                });
            }
        },
        { immediate: true },
    );

    watch(
        () => page.props.flash.error,
        (error) => {
            if (error?.message) {
                const timeString = error.timestamp ? formatToastTimestamp(error.timestamp) : '';
                toast.error(error.message, {
                    description: timeString ? `at ${timeString}` : undefined,
                    action: {
                        label: 'Close',
                        onClick: () => {},
                    },
                });
            }
        },
        { immediate: true },
    );
};
