<script setup lang="ts">
import type { Component } from 'vue';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';

defineProps<{
    title: string;
    value: string;
    description?: string;
    icon: Component;
    iconClass?: string;
    progressValue?: number;
    progressClass?: string;
}>();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle class="text-sm font-medium">{{ title }}</CardTitle>
            <component :is="icon" :class="iconClass || 'h-4 w-4 text-muted-foreground'" />
        </CardHeader>
        <CardContent>
            <div class="text-2xl font-bold">{{ value }}</div>
            <div v-if="progressValue" class="mt-2 space-y-2">
                <Progress :modelValue="progressValue" :class="progressClass || 'h-2'" />
                <p v-if="description" class="text-xs text-muted-foreground">{{ description }}</p>
            </div>
            <p v-else-if="description" class="text-xs text-muted-foreground">{{ description }}</p>
        </CardContent>
    </Card>
</template>
