<script setup lang="ts">
import type { TIndexCategory } from '@/types/props';

import { computed, ref } from 'vue';

import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Search } from 'lucide-vue-next';
import { Item } from '.';

const props = defineProps<{
    categories: TIndexCategory[];
    edit: (category: TIndexCategory) => void;
}>();

const searchTerm = ref('');
const typeFilter = ref('all');

const filteredCategories = computed(() =>
    props.categories.filter((category) => {
        const matchesSearch = category.name.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesType = typeFilter.value === 'all' || category.kind === typeFilter.value;
        return matchesSearch && matchesType;
    }),
);
</script>

<template>
    <div class="flex gap-4">
        <div class="relative flex-1">
            <Search class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 transform text-muted-foreground" />
            <Input v-model="searchTerm" placeholder="Search categories..." class="pl-10" />
        </div>
        <Select v-model="typeFilter">
            <SelectTrigger class="w-40">
                <SelectValue />
            </SelectTrigger>
            <SelectContent>
                <SelectItem value="all">All Types</SelectItem>
                <SelectItem value="income">Income</SelectItem>
                <SelectItem value="expense">Expense</SelectItem>
            </SelectContent>
        </Select>
    </div>

    <div>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold">Your Categories</h2>
            <p class="text-sm text-muted-foreground">Showing {{ filteredCategories.length }} of {{ categories.length }} categories</p>
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <Item v-for="category in filteredCategories" :key="category.id" :category="category" :edit="edit" />
        </div>
        <div v-if="filteredCategories.length === 0" class="py-8 text-center text-muted-foreground">
            <p>
                {{
                    searchTerm || typeFilter !== 'all'
                        ? 'No categories found matching your criteria.'
                        : 'No categories created yet. Create your first category to start organizing your transactions.'
                }}
            </p>
        </div>
    </div>
</template>
