<script setup lang="ts">
import { Alert, AlertDescription } from '@/components/ui/alert';
import { AlertTriangle } from 'lucide-vue-next';

defineProps<{
    title?: string;
    message: string;
}>();
</script>

<template>
    <Alert class="border-yellow-200 bg-yellow-50 dark:border-yellow-200/20 dark:bg-yellow-950/50">
        <AlertTriangle class="h-4 w-4 text-yellow-600 dark:text-yellow-500" />
        <AlertDescription class="text-yellow-800 dark:text-yellow-300">
            <strong v-if="title">{{ title }}</strong> {{ message }}
        </AlertDescription>
    </Alert>
</template>
