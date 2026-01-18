<script setup lang="ts">
import type { TIndexBudget } from '@/types/props';

import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';

const budgets: TIndexBudget[] = [];
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Budget Progress</CardTitle>
        </CardHeader>
        <CardContent>
            <div class="space-y-4">
                <div v-for="budget in budgets" :key="budget.id" class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="font-medium">{{ budget.category.name }}</span>
                            <Badge v-if="(budget.spent / budget.amount) * 100 > 100" variant="destructive" class="text-xs"> Over Budget </Badge>
                            <Badge v-else-if="(budget.spent / budget.amount) * 100 > 80" variant="secondary" class="text-xs"> Near Limit </Badge>
                        </div>
                        <span class="text-sm text-muted-foreground">
                            ${{ budget.spent.toLocaleString() }} / ${{ budget.amount.toLocaleString() }}
                        </span>
                    </div>
                    <Progress :value="Math.min((budget.spent / budget.amount) * 100, 100)" class="h-2" />
                    <div class="flex justify-between text-xs text-muted-foreground">
                        <span>{{ ((budget.spent / budget.amount) * 100).toFixed(1) }}% used</span>
                        <span>${{ (budget.amount - budget.spent).toLocaleString() }} remaining</span>
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
