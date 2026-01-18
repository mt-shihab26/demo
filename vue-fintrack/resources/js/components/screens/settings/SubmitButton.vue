<script setup lang="ts">
import { Button } from '@/components/ui/button';

defineProps<{
    processing: boolean;
    recentlySuccessful: boolean;
    buttonText?: string;
    successText?: string;
    testId?: string;
}>();
</script>

<template>
    <div class="flex items-center gap-4">
        <Button type="submit" :disabled="processing" :data-test="testId">
            {{ processing ? 'Saving...' : buttonText || 'Save' }}
        </Button>

        <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
        >
            <p v-show="recentlySuccessful" class="text-sm text-neutral-600">{{ successText || 'Saved.' }}</p>
        </Transition>
    </div>
</template>
