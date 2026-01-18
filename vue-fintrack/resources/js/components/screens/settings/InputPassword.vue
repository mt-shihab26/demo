<script setup lang="ts">
import { ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Eye, EyeOff } from 'lucide-vue-next';

defineProps<{
    id: string;
    name: string;
    label: string;
    placeholder?: string;
    autocomplete?: string;
    error?: string;
    modelValue: string;
    required?: boolean;
}>();

defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

defineExpose({
    focus: () => {},
});

const showPassword = ref(false);
</script>

<template>
    <div class="flex flex-col gap-2">
        <Label :for="id">{{ label }}</Label>
        <div class="relative">
            <Input
                :id="id"
                :name="name"
                :type="showPassword ? 'text' : 'password'"
                :model-value="modelValue"
                class="block w-full pr-10"
                :autocomplete="autocomplete"
                :placeholder="placeholder"
                :required="required"
                @update:model-value="$emit('update:modelValue', $event as any)"
            />
            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="absolute top-0 right-0 h-full cursor-pointer px-3 py-2 hover:bg-transparent"
                @click="showPassword = !showPassword"
            >
                <Eye v-if="!showPassword" class="h-4 w-4 text-muted-foreground" />
                <EyeOff v-else class="h-4 w-4 text-muted-foreground" />
            </Button>
        </div>
        <Error v-if="error" class="mt-2" :message="error" />
    </div>
</template>
