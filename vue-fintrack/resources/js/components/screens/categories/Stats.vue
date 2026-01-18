<script setup lang="ts">
import type { TIndexCategory } from '@/types/props';

import { useFormat } from '@/composables/use-format';
import { computed } from 'vue';

import { Activity, FolderOpen, TrendingDown, TrendingUp } from 'lucide-vue-next';
import { Stat } from '.';

const props = defineProps<{ categories: TIndexCategory[] }>();

const { currency } = useFormat();

const incomeCategories = computed(() => props.categories.filter((cat) => cat.kind === 'income'));
const expenseCategories = computed(() => props.categories.filter((cat) => cat.kind === 'expense'));

const totalIncome = computed(() => incomeCategories.value.reduce((sum, cat) => sum + cat.total_amount, 0));
const totalExpenses = computed(() => expenseCategories.value.reduce((sum, cat) => sum + cat.total_amount, 0));
const totalAmount = computed(() => props.categories.reduce((sum, cat) => sum + cat.total_amount, 0));

const countIncomeTransactions = computed(() => incomeCategories.value.reduce((sum, cat) => sum + cat.transaction_count, 0));
const countExpensesTransactions = computed(() => expenseCategories.value.reduce((sum, cat) => sum + cat.transaction_count, 0));
const countTransactions = computed(() => props.categories.reduce((sum, cat) => sum + cat.transaction_count, 0));
</script>

<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Stat
            title="Total Categories"
            :value="categories.length"
            :description="`${incomeCategories.length} income, ${expenseCategories.length} expense`"
            :icon="FolderOpen"
        />

        <Stat
            title="Income Categories"
            :value="currency(totalIncome)"
            :description="`${incomeCategories.length} categories, ${countIncomeTransactions} transactions`"
            :icon="TrendingUp"
            value-class="text-primary"
            icon-class="text-primary"
        />

        <Stat
            title="Expense Categories"
            :value="currency(totalExpenses)"
            :description="`${expenseCategories.length} categories, ${countExpensesTransactions} transactions`"
            :icon="TrendingDown"
            value-class="text-destructive"
            icon-class="text-destructive"
        />

        <Stat
            title="Total Transactions"
            :value="currency(totalAmount)"
            :description="`${countTransactions} Transactions Across all categories`"
            :icon="Activity"
        />
    </div>
</template>
