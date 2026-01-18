<script setup lang="ts">
import type { TIndexCategory } from '@/types/props';

import { useFormat } from '@/composables/use-format';
import { computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Actions } from '.';

const { currency } = useFormat();

const props = defineProps<{
    category: TIndexCategory;
    edit: (category: TIndexCategory) => void;
}>();

const averagePerTransaction = computed(() => {
    return props.category.transaction_count > 0 ? props.category.total_amount / props.category.transaction_count : 0;
});
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <div class="flex items-center space-x-2">
                <div class="h-4 w-4 rounded-full" :style="{ 'background-color': category.color }" />
                <CardTitle class="text-base font-medium">{{ category.name }}</CardTitle>
            </div>
            <Actions :category="category" :edit="edit" />
        </CardHeader>
        <CardContent class="space-y-4">
            <div class="flex items-center justify-between">
                <Badge :variant="category.kind === 'income' ? 'default' : 'destructive'" class="capitalize">
                    {{ category.kind }}
                </Badge>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center space-x-2">
                    <div>
                        <p class="text-sm text-muted-foreground">Transactions</p>
                        <p class="font-semibold">{{ category.transaction_count }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div>
                        <p class="text-sm text-muted-foreground">Total Amount</p>
                        <p :class="`font-semibold ${category.kind === 'income' ? 'text-primary' : 'text-destructive'}`">
                            {{ currency(category.total_amount) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-xs text-muted-foreground">Avg: {{ currency(averagePerTransaction) }} per transaction</div>
        </CardContent>
    </Card>
</template>
