<script setup lang="ts">
import type { TBreadcrumb } from '@/types';

import { computed } from 'vue';

import { BaseLayout } from '@/layouts/base-layout';
import { Head } from '@inertiajs/vue3';

import Header from './Header.vue';

const props = defineProps<{
    breadcrumbs: TBreadcrumb[];
}>();

const title = computed(() => {
    return props.breadcrumbs && props.breadcrumbs.length > 0 ? props.breadcrumbs[props.breadcrumbs.length - 1].title : '';
});
</script>

<template>
    <BaseLayout>
        <Head :title="title" />
        <div class="flex min-h-screen w-full flex-col">
            <Header :breadcrumbs="breadcrumbs" />
            <main class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">
                <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl px-4 py-8">
                    <slot />
                </div>
            </main>
        </div>
    </BaseLayout>
</template>
