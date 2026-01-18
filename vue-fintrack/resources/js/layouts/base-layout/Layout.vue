<script setup lang="ts">
import 'vue-sonner/style.css';

import { useFlash } from '@/composables/use-flash';

import { Toaster } from '@/components/ui/sonner';

useFlash();
</script>

<template>
    <Toaster />
    <slot />
</template>
