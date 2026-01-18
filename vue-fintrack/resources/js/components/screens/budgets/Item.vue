<script setup lang="ts">
import type { TIndexBudget } from '@/types/props';

import { useFormat } from '@/composables/use-format';
import { formatPercentage, formatProgressValue } from '@/lib/format';
import { computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { AlertTriangle, TrendingDown, TrendingUp } from 'lucide-vue-next';
import { Actions } from '.';

const { currency } = useFormat();

const props = defineProps<{
    budget: TIndexBudget;
    edit: (budget: TIndexBudget) => void;
}>();

const percentage = computed(() => (props.budget.spent / props.budget.amount) * 100);
const remaining = computed(() => props.budget.amount - props.budget.spent);
const isOverBudget = computed(() => percentage.value > 100);
const isNearLimit = computed(() => percentage.value > 80 && percentage.value <= 100);

const getStatusColor = computed(() => {
    if (isOverBudget.value) return 'text-destructive';
    if (isNearLimit.value) return 'text-chart-3';
    return 'text-primary';
});

const getStatusIcon = computed(() => {
    if (isOverBudget.value) return AlertTriangle;
    if (isNearLimit.value) return TrendingUp;
    return TrendingDown;
});

const getStatusIconClass = computed(() => {
    if (isOverBudget.value) return 'h-4 w-4 text-destructive';
    if (isNearLimit.value) return 'h-4 w-4 text-chart-3';
    return 'h-4 w-4 text-primary';
});

const getStatusBadgeVariant = computed(() => {
    if (isOverBudget.value) return 'destructive';
    if (isNearLimit.value) return 'secondary';
    return 'default';
});

const getStatusBadgeText = computed(() => {
    if (isOverBudget.value) return 'Over Budget';
    if (isNearLimit.value) return 'Near Limit';
    return 'On Track';
});
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <div class="flex items-center space-x-2">
                <div class="h-4 w-4 rounded-full" :style="{ 'background-color': budget.category.color }" />
                <CardTitle class="text-base font-medium">{{ budget.category.name }}</CardTitle>
            </div>
            <Actions :budget="budget" :edit="edit" />
        </CardHeader>
        <CardContent class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <component :is="getStatusIcon" :class="getStatusIconClass" />
                    <span :class="`text-2xl font-bold ${getStatusColor}`">{{ currency(budget.spent) }}</span>
                </div>
                <Badge :variant="getStatusBadgeVariant">{{ getStatusBadgeText }}</Badge>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Progress</span>
                    <span>{{ formatPercentage(percentage) }}</span>
                </div>
                <Progress :modelValue="formatProgressValue(percentage)" class="h-2" />
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-muted-foreground">Budget</p>
                    <p class="font-semibold">{{ currency(budget.amount) }}</p>
                </div>
                <div>
                    <p class="text-muted-foreground">Remaining</p>
                    <p :class="`font-semibold ${remaining >= 0 ? 'text-primary' : 'text-destructive'}`">
                        {{ currency(Math.abs(remaining)) }}
                        <span v-if="remaining < 0"> over</span>
                    </p>
                </div>
            </div>

            <div class="text-xs text-muted-foreground capitalize">{{ budget.period }} budget</div>
        </CardContent>
    </Card>
</template>
