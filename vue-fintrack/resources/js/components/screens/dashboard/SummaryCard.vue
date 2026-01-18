<script setup lang="ts">
import type { Component } from 'vue';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

defineProps<{
    title: string;
    value: string;
    subtitle: string;
    icon: Component;
    iconClass?: string;
    valueClass?: string;
}>();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle class="text-sm font-medium">{{ title }}</CardTitle>
            <component :is="icon" :class="`h-4 w-4 ${iconClass || ''}`" />
        </CardHeader>
        <CardContent>
            <div :class="`text-2xl font-bold ${valueClass || ''}`">{{ value }}</div>
            <p class="text-xs text-muted-foreground">{{ subtitle }}</p>
        </CardContent>
    </Card>
</template>
