<script setup lang="ts">
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

defineProps<{
    id: string;
    name: string;
    label: string;
    type?: string;
    modelValue: string;
    placeholder?: string;
    required?: boolean;
    autocomplete?: string;
    error?: string;
}>();

defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();
</script>

<template>
    <div class="flex flex-col gap-2">
        <Label :for="id">{{ label }}</Label>
        <Input
            :id="id"
            :name="name"
            :type="type || 'text'"
            :model-value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :autocomplete="autocomplete"
            class="mt-1 block w-full"
            @update:model-value="$emit('update:modelValue', $event as any)"
        />
        <Error v-if="error" class="mt-2" :message="error" />
    </div>
</template>
