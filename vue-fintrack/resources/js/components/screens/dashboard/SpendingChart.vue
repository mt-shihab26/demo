<script setup lang="ts">
import { categories } from '@/lib/mock-data';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { DonutChart } from '@/components/ui/chart-donut';

const expenseCategories = categories.filter((cat) => cat.kind === 'expense');

const data = expenseCategories.map((cat) => ({
    name: cat.name,
    total: cat.total_amount,
}));

const colors = expenseCategories.map((cat) => cat.color);
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Spending by Category</CardTitle>
        </CardHeader>
        <CardContent>
            <DonutChart index="name" :category="'total'" :data="data" :colors="colors" :type="'pie'" />

            <!-- Color Legend -->
            <div class="mt-4 grid grid-cols-2 gap-2">
                <div v-for="category in expenseCategories" :key="category.id" class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full" :style="{ backgroundColor: category.color }"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ category.name }}</span>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
