<script setup lang="ts">
import { Error } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';

defineProps<{
    id: string;
    name: string;
    label: string;
    description: string;
    modelValue: boolean;
    error?: string;
}>();

defineEmits<{
    (e: 'update:modelValue', value: boolean): void;
}>();
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="space-y-0.5">
            <Label :for="id">{{ label }}</Label>
            <p class="text-sm text-muted-foreground">{{ description }}</p>
        </div>
        <div class="flex flex-col gap-2">
            <Switch :id="id" :name="name" :model-value="modelValue" @update:model-value="(value: boolean) => $emit('update:modelValue', value)" />
            <Error v-if="error" :message="error" />
        </div>
    </div>
</template>
