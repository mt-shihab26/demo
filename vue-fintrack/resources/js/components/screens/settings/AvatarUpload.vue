<script setup lang="ts">
import type { TUser } from '@/types/models';

import { getInitials } from '@/lib/utils';
import { computed, ref, watch } from 'vue';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Error } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Upload } from 'lucide-vue-next';

const props = defineProps<{
    user: TUser;
    error?: string;
    modelValue?: File | null;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', file: File | null): void;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(null);

watch(
    () => props.modelValue,
    (newFile) => {
        if (previewUrl.value) {
            URL.revokeObjectURL(previewUrl.value);
            previewUrl.value = null;
        }

        if (newFile) {
            previewUrl.value = URL.createObjectURL(newFile);
        }
    },
    { immediate: true },
);

const avatarSrc = computed(() => {
    if (previewUrl.value) {
        return previewUrl.value;
    }
    return props.user.avatar || '';
});

const handleFileSelect = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0] || null;
    emit('update:modelValue', file);
};
</script>

<template>
    <div class="grid gap-4">
        <Label>Profile Avatar</Label>
        <div class="flex items-center gap-6">
            <Avatar class="h-20 w-20">
                <AvatarImage :src="avatarSrc" :alt="user.name" />
                <AvatarFallback class="text-lg">{{ getInitials(user.name || 'U') }}</AvatarFallback>
            </Avatar>

            <div class="flex flex-col gap-2">
                <input ref="fileInput" type="file" accept="image/*" class="hidden" @input="handleFileSelect" />
                <Button type="button" variant="outline" @click="fileInput?.click()" class="flex items-center gap-2" data-test="upload-avatar-button">
                    <Upload class="h-4 w-4" />
                    {{ modelValue ? 'Change photo' : 'Choose photo' }}
                </Button>
                <p class="text-xs text-muted-foreground">JPG, PNG or GIF. Max 2MB.</p>
            </div>
        </div>
        <Error v-if="error" :message="error" />
    </div>
</template>
