<script setup lang="ts">
import type { TCategory, TTransaction } from '@/types/models';
import type { TTransactionFilters } from '@/types/utils';

import { ref } from 'vue';

import { Filters, Form, List } from '@/components/screens/transactions';
import { Button } from '@/components/ui/button';
import { AppLayout } from '@/layouts/app-layout';
import { Plus } from 'lucide-vue-next';

defineProps<{
    transactions: TTransaction[];
    categories: TCategory[];
}>();

const open = ref(false);
const transaction = ref<TTransaction | null>(null);

const filters = ref<TTransactionFilters>({
    search: '',
    kind: '',
    category: '',
    dateRange: 'all',
    dateFrom: '',
    dateTo: '',
    minAmount: '',
    maxAmount: '',
});

const edit = (t: TTransaction) => {
    transaction.value = t;
    open.value = true;
};
</script>

<template>
    <AppLayout :breadcrumbs="[{ home: true }, { title: 'Transactions' }]">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-balance">Transactions</h1>
                    <p class="text-pretty text-muted-foreground">Manage your income and expenses with detailed tracking and filtering.</p>
                </div>
                <Button @click="open = true">
                    <Plus class="mr-2 h-4 w-4" />
                    Add Transaction
                </Button>
            </div>
            <Filters :filters="filters" :categories="categories" @filters-change="filters = $event" />
            <List :transactions="transactions" :filters="filters" :edit="edit" />
        </div>
        <Form v-model:open="open" v-model:transaction="transaction" :categories="categories" />
    </AppLayout>
</template>
