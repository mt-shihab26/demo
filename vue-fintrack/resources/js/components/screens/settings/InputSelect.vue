<script setup lang="ts">
import type { AcceptableValue } from 'reka-ui';

import { Error } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

defineProps<{
    id: string;
    name: string;
    label: string;
    modelValue: AcceptableValue;
    options: { value: string; label: string }[];
    error?: string;
}>();

defineEmits<{
    (e: 'update:modelValue', value: AcceptableValue): void;
}>();
</script>

<template>
    <div class="flex flex-col gap-2">
        <Label :for="id">{{ label }}</Label>
        <Select :model-value="modelValue" :name="name" @update:model-value="$emit('update:modelValue', $event)">
            <SelectTrigger>
                <SelectValue />
            </SelectTrigger>
            <SelectContent>
                <SelectItem v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </SelectItem>
            </SelectContent>
        </Select>
        <Error v-if="error" class="mt-2" :message="error" />
    </div>
</template>
