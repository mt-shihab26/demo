<script setup lang="ts">
import type { TIndexCategory } from '@/types/props';

import { ref } from 'vue';

import { Form, List, Stats } from '@/components/screens/categories';
import { Button } from '@/components/ui/button';
import { AppLayout } from '@/layouts/app-layout';
import { Plus } from 'lucide-vue-next';

defineProps<{
    categories: TIndexCategory[];
}>();

const open = ref(false);
const category = ref<TIndexCategory | null>(null);

const edit = (c: TIndexCategory) => {
    category.value = c;
    open.value = true;
};
</script>

<template>
    <AppLayout :breadcrumbs="[{ home: true }, { title: 'Categories' }]">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-balance">Categories</h1>
                    <p class="text-pretty text-muted-foreground">Organize your transactions with custom categories and track usage statistics.</p>
                </div>
                <Button @click="open = true">
                    <Plus class="mr-2 h-4 w-4" />
                    Add Category
                </Button>
            </div>
            <Stats :categories="categories" />
            <List :categories="categories" :edit="edit" />
        </div>
        <Form v-model:open="open" v-model:category="category" />
    </AppLayout>
</template>
