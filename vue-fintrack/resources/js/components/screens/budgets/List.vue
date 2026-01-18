<script setup lang="ts">
import type { TIndexBudget } from '@/types/props';

import { computed, ref } from 'vue';

import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Search } from 'lucide-vue-next';
import { Item } from '.';

const props = defineProps<{
    budgets: TIndexBudget[];
    edit: (budget: TIndexBudget) => void;
}>();

const searchTerm = ref('');
const periodFilter = ref('all');

const filteredBudgets = computed(() =>
    props.budgets.filter((budget) => {
        const matchesSearch = budget.category.name.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesPeriod = periodFilter.value === 'all' || budget.period === periodFilter.value;
        return matchesSearch && matchesPeriod;
    }),
);
</script>

<template>
    <div class="space-y-6">
        <div class="flex gap-4">
            <div class="relative flex-1">
                <Search class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 transform text-muted-foreground" />
                <Input v-model="searchTerm" placeholder="Search budgets..." class="pl-10" />
            </div>
            <Select v-model="periodFilter">
                <SelectTrigger class="w-40">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">All Periods</SelectItem>
                    <SelectItem value="weekly">Weekly</SelectItem>
                    <SelectItem value="monthly">Monthly</SelectItem>
                </SelectContent>
            </Select>
        </div>

        <div>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold">Your Budgets</h2>
                <p class="text-sm text-muted-foreground">Showing {{ filteredBudgets.length }} of {{ budgets.length }} budgets</p>
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <Item v-for="budget in filteredBudgets" :key="budget.id" :budget="budget" :edit="edit" />
            </div>
            <div v-if="filteredBudgets.length === 0" class="py-8 text-center text-muted-foreground">
                <p>
                    {{
                        searchTerm || periodFilter !== 'all'
                            ? 'No budgets found matching your criteria.'
                            : 'No budgets created yet. Create your first budget to start tracking your spending limits.'
                    }}
                </p>
            </div>
        </div>
    </div>
</template>
