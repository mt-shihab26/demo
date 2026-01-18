<script setup lang="ts">
import type { TBreadcrumb } from '@/types';

import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb';
import { Link } from '@inertiajs/vue3';
import { Home } from 'lucide-vue-next';

defineProps<{
    breadcrumbs: TBreadcrumb[];
}>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="item.home">
                        <BreadcrumbLink as-child>
                            <Link :href="item.href ?? route('dashboard')">
                                <Home v-if="item.home" class="h-4 w-4" />
                                <span v-else>{{ item.title }}</span>
                            </Link>
                        </BreadcrumbLink>
                    </template>
                    <template v-else>
                        <BreadcrumbPage>
                            <Link :href="item.href">
                                <Home v-if="item.home" class="h-4 w-4" />
                                <span v-else>{{ item.title }}</span>
                            </Link>
                        </BreadcrumbPage>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
