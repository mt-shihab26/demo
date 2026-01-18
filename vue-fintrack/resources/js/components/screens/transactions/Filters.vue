<script setup lang="ts">
import type { TCategory } from '@/types/models';
import type { TDateRangeFilter, TTransactionFilters } from '@/types/utils';

import { computed, ref } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { CalendarDays, Filter, SlidersHorizontal, X } from 'lucide-vue-next';

interface Props {
    filters: TTransactionFilters;
    categories: TCategory[];
}

const props = defineProps<Props>();

const emit = defineEmits<{
    filtersChange: [filters: TTransactionFilters];
}>();

const updateFilter = (key: keyof TTransactionFilters, value: string | number) => {
    emit('filtersChange', { ...props.filters, [key]: String(value) });
};

const handleStringFilter = (key: keyof TTransactionFilters) => (value: string) => {
    updateFilter(key, value);
};

const handleNumberFilter = (key: keyof TTransactionFilters) => (value: string | number) => {
    updateFilter(key, value);
};

const hasActiveFilters = computed(() => {
    return Object.values(props.filters).some((value) => value !== '');
});

const showAdvancedFilters = ref(false);

const dateRangeOptions = [
    { value: 'all', label: 'All Time' },
    { value: 'today', label: 'Today' },
    { value: 'this-week', label: 'This Week' },
    { value: 'this-month', label: 'This Month' },
    { value: 'this-year', label: 'This Year' },
    { value: 'custom', label: 'Custom Range' },
] as const;

const getDateRangeFromFilter = (dateRange: TDateRangeFilter) => {
    const now = new Date();
    const today = now.toISOString().split('T')[0];

    switch (dateRange) {
        case 'today':
            return { from: today, to: today };
        case 'this-week': {
            const startOfWeek = new Date(now);
            startOfWeek.setDate(now.getDate() - now.getDay());
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            return {
                from: startOfWeek.toISOString().split('T')[0],
                to: endOfWeek.toISOString().split('T')[0],
            };
        }
        case 'this-month': {
            const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
            const endOfMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            return {
                from: startOfMonth.toISOString().split('T')[0],
                to: endOfMonth.toISOString().split('T')[0],
            };
        }
        case 'this-year': {
            const startOfYear = new Date(now.getFullYear(), 0, 1);
            const endOfYear = new Date(now.getFullYear(), 11, 31);
            return {
                from: startOfYear.toISOString().split('T')[0],
                to: endOfYear.toISOString().split('T')[0],
            };
        }
        default:
            return { from: '', to: '' };
    }
};

const handleDateRangeChange = (dateRange: TDateRangeFilter) => {
    const { from, to } = getDateRangeFromFilter(dateRange);
    const updatedFilters: TTransactionFilters = {
        ...props.filters,
        dateRange,
        dateFrom: dateRange === 'custom' ? props.filters.dateFrom : from,
        dateTo: dateRange === 'custom' ? props.filters.dateTo : to,
    };
    emit('filtersChange', updatedFilters);
};

const clearFilters = () => {
    const clearedFilters: TTransactionFilters = {
        search: '',
        kind: '',
        category: '',
        dateRange: 'all',
        dateFrom: '',
        dateTo: '',
        minAmount: '',
        maxAmount: '',
    };
    emit('filtersChange', clearedFilters);
    showAdvancedFilters.value = false;
};
</script>

<template>
    <div class="space-y-4">
        <!-- Date Range Tabs -->
        <Card>
            <CardHeader class="pb-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <CalendarDays class="h-4 w-4" />
                        <CardTitle class="text-base">Time Period</CardTitle>
                    </div>
                    <Badge v-if="hasActiveFilters" variant="secondary" class="text-xs">
                        {{ Object.values(filters).filter((v) => v !== '' && v !== 'all').length }} Active
                    </Badge>
                </div>
            </CardHeader>
            <CardContent>
                <Tabs
                    :model-value="filters.dateRange"
                    @update:model-value="(value: string | number) => handleDateRangeChange(String(value) as TDateRangeFilter)"
                >
                    <TabsList class="grid w-full grid-cols-6">
                        <TabsTrigger v-for="option in dateRangeOptions" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </TabsTrigger>
                    </TabsList>
                </Tabs>

                <!-- Custom Date Range -->
                <div v-if="filters.dateRange === 'custom'" class="mt-4 grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">From Date</label>
                        <Input type="date" :model-value="filters.dateFrom" @update:model-value="handleStringFilter('dateFrom')" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">To Date</label>
                        <Input type="date" :model-value="filters.dateTo" @update:model-value="handleStringFilter('dateTo')" />
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Quick Filters -->
        <Card>
            <CardHeader class="pb-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Filter class="h-4 w-4" />
                        <CardTitle class="text-base">Quick Filters</CardTitle>
                    </div>
                    <div class="flex gap-2">
                        <Button variant="ghost" size="sm" @click="showAdvancedFilters = !showAdvancedFilters">
                            <SlidersHorizontal class="mr-1 h-4 w-4" />
                            {{ showAdvancedFilters ? 'Hide' : 'Show' }} Advanced
                        </Button>
                        <Button v-if="hasActiveFilters" variant="ghost" size="sm" @click="clearFilters">
                            <X class="mr-1 h-4 w-4" />
                            Clear All
                        </Button>
                    </div>
                </div>
            </CardHeader>
            <CardContent>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <Input placeholder="Search transactions..." :model-value="filters.search" @update:model-value="handleStringFilter('search')" />

                    <Select :model-value="filters.kind" @update:model-value="handleStringFilter('kind')">
                        <SelectTrigger>
                            <SelectValue placeholder="All types" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="">All types</SelectItem>
                            <SelectItem value="income">Income</SelectItem>
                            <SelectItem value="expense">Expense</SelectItem>
                        </SelectContent>
                    </Select>

                    <Select :model-value="filters.category" @update:model-value="handleStringFilter('category')">
                        <SelectTrigger>
                            <SelectValue placeholder="All categories" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="">All categories</SelectItem>
                            <SelectItem v-for="cat in categories" :key="cat.id" :value="cat.name">
                                <div class="flex items-center gap-2">
                                    <div class="h-3 w-3 rounded-full" :style="`background-color: ${cat.color}`" />
                                    {{ cat.name }}
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </CardContent>
        </Card>

        <!-- Advanced Filters -->
        <Card>
            <CardHeader class="pb-3">
                <CardTitle class="text-base">Advanced Filters</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Amount Range</label>
                        <div class="grid grid-cols-2 gap-4">
                            <Input
                                type="number"
                                placeholder="Min amount"
                                :model-value="filters.minAmount"
                                @update:model-value="handleNumberFilter('minAmount')"
                            />
                            <Input
                                type="number"
                                placeholder="Max amount"
                                :model-value="filters.maxAmount"
                                @update:model-value="handleNumberFilter('maxAmount')"
                            />
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
