<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed } from 'vue';

import * as icons from 'lucide-vue-next';

const props = withDefaults(
    defineProps<{
        name: string;
        class?: string;
        size?: number | string;
        color?: string;
        strokeWidth?: number | string;
    }>(),
    {
        class: '',
        size: 16,
        strokeWidth: 2,
    },
);

const className = computed(() => cn('h-4 w-4', props.class));

const icon = computed(() => {
    const iconName = props.name.charAt(0).toUpperCase() + props.name.slice(1);
    return (icons as Record<string, any>)[iconName];
});
</script>

<template>
    <component :is="icon" :class="className" :size="size" :stroke-width="strokeWidth" :color="color" />
</template>
