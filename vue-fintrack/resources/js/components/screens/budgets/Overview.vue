<script setup lang="ts">
import type { TIndexBudget } from '@/types/props';

import { useFormat } from '@/composables/use-format';
import { formatPercentage, formatProgressValue } from '@/lib/format';
import { computed } from 'vue';

import { AlertTriangle, Target, TrendingDown, TrendingUp } from 'lucide-vue-next';
import { Stat } from '.';

const props = defineProps<{
    budgets: TIndexBudget[];
}>();

const { currency } = useFormat();

const budget = computed(() => props.budgets.reduce((sum, b) => sum + (Number(b.amount) || 0), 0));
const spent = computed(() => props.budgets.reduce((sum, b) => sum + (Number(b.spent) || 0), 0));
const percentage = computed(() => (budget.value > 0 ? (spent.value / budget.value) * 100 : 0));

const remaining = computed(() => budget.value - spent.value);

const onTrackCount = computed(
    () =>
        props.budgets.filter((b) => {
            const amount = Number(b.amount) || 0;
            const spent = Number(b.spent) || 0;
            return amount > 0 && (spent / amount) * 100 <= 80;
        }).length,
);

const overBudgetCount = computed(
    () =>
        props.budgets.filter((b) => {
            const amount = Number(b.amount) || 0;
            const spent = Number(b.spent) || 0;
            return amount > 0 && (spent / amount) * 100 > 100;
        }).length,
);

const nearLimitCount = computed(
    () =>
        props.budgets.filter((b) => {
            const amount = Number(b.amount) || 0;
            const spent = Number(b.spent) || 0;
            if (amount <= 0) return false;
            const percentage = (spent / amount) * 100;
            return percentage > 80 && percentage <= 100;
        }).length,
);
</script>

<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Stat
            title="Total Budget"
            :value="currency(budget)"
            :icon="Target"
            :progressValue="formatProgressValue(percentage)"
            :description="`${currency(spent)} spent (${formatPercentage(percentage)})`"
        />

        <Stat
            title="Remaining"
            :value="currency(Math.abs(remaining))"
            :icon="remaining >= 0 ? TrendingDown : TrendingUp"
            :iconClass="remaining >= 0 ? 'h-4 w-4 text-primary' : 'h-4 w-4 text-destructive'"
            :description="remaining >= 0 ? 'Under budget' : 'Over budget'"
        />

        <Stat
            title="On Track"
            :value="onTrackCount.toString()"
            :icon="TrendingDown"
            iconClass="h-4 w-4 text-primary"
            description="Budgets under 80%"
        />

        <Stat
            title="Alerts"
            :value="(overBudgetCount + nearLimitCount).toString()"
            :icon="AlertTriangle"
            iconClass="h-4 w-4 text-destructive"
            :description="`${overBudgetCount} over, ${nearLimitCount} near limit`"
        />
    </div>
</template>
