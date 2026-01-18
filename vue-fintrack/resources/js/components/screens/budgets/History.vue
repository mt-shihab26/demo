<script setup lang="ts">
import type { TIndexBudget } from '@/types/props';

import { useFormat } from '@/composables/use-format';
import { ref } from 'vue';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { LineChart } from '@/components/ui/chart-line';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

defineProps<{
    budgets?: TIndexBudget[];
}>();

const mockHistoryData = [
    { month: 'Jan', Food: 450, Transport: 180, Entertainment: 280, Utilities: 120 },
    { month: 'Feb', Food: 520, Transport: 160, Entertainment: 320, Utilities: 110 },
    { month: 'Mar', Food: 480, Transport: 200, Entertainment: 250, Utilities: 130 },
    { month: 'Apr', Food: 510, Transport: 190, Entertainment: 290, Utilities: 125 },
    { month: 'May', Food: 470, Transport: 170, Entertainment: 310, Utilities: 115 },
    { month: 'Jun', Food: 490, Transport: 185, Entertainment: 275, Utilities: 140 },
];

const selectedPeriod = ref('6months');

const categories = ['Food', 'Transport', 'Entertainment', 'Utilities'] as any;
const colors = ['#f59e0b', '#059669', '#7c3aed', '#4b5563'];

const { currency } = useFormat();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between">
            <CardTitle>Budget Performance History</CardTitle>
            <Select v-model="selectedPeriod">
                <SelectTrigger class="w-32">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="3months">3 Months</SelectItem>
                    <SelectItem value="6months">6 Months</SelectItem>
                    <SelectItem value="1year">1 Year</SelectItem>
                </SelectContent>
            </Select>
        </CardHeader>
        <CardContent>
            <div class="h-[300px] w-full">
                <LineChart
                    :data="mockHistoryData"
                    :categories="categories"
                    index="month"
                    :colors="colors"
                    :y-formatter="(tick: number | Date) => (typeof tick === 'number' ? currency(tick) : ('' as any))"
                    :show-grid-line="true"
                    :show-legend="true"
                    :show-tooltip="true"
                    class="h-full"
                />
            </div>
        </CardContent>
    </Card>
</template>
