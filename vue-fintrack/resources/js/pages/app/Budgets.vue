<script setup lang="ts">
import type { TCategory } from '@/types/models';
import type { TIndexBudget } from '@/types/props';

import { ref } from 'vue';

import { Form, History, List, Overview } from '@/components/screens/budgets';
import { Button } from '@/components/ui/button';
import { AppLayout } from '@/layouts/app-layout';
import { Plus } from 'lucide-vue-next';

defineProps<{
    budgets: TIndexBudget[];
    categories: TCategory[];
}>();

const open = ref(false);
const budget = ref<TIndexBudget | null>(null);

const edit = (b: TIndexBudget) => {
    budget.value = b;
    open.value = true;
};
</script>

<template>
    <AppLayout :breadcrumbs="[{ home: true }, { title: 'Budgets' }]">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-balance">Budget Management</h1>
                    <p class="text-pretty text-muted-foreground">Set spending limits, track progress, and stay on top of your financial goals.</p>
                </div>
                <Button @click="open = true">
                    <Plus class="mr-2 h-4 w-4" />
                    Create Budget
                </Button>
            </div>
            <Overview :budgets="budgets" />
            <List :budgets="budgets" :edit="edit" />
            <History v-if="budgets.length > 0" :budgets="budgets" />
        </div>
        <Form v-model:open="open" v-model:budget="budget" :categories="categories" />
    </AppLayout>
</template>
