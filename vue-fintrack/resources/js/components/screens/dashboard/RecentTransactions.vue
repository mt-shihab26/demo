<script setup lang="ts">
import { transactions } from '@/lib/mock-data';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowDownRight, ArrowUpRight, MoreHorizontal } from 'lucide-vue-next';

const recentTransactions = computed(() => transactions.sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime()).slice(0, 5));

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString();
};

const formatAmount = (amount: number) => {
    return amount.toLocaleString();
};
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between">
            <CardTitle>Recent Transactions</CardTitle>
            <Button variant="outline" size="sm" @click="router.visit(route('app.transactions'))"> View All </Button>
        </CardHeader>
        <CardContent>
            <div class="space-y-4">
                <div v-for="transaction in recentTransactions" :key="transaction.id" class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            :class="[
                                'rounded-full p-2',
                                transaction.kind === 'income' ? 'bg-primary/10 text-primary' : 'bg-destructive/10 text-destructive',
                            ]"
                        >
                            <ArrowUpRight v-if="transaction.kind === 'income'" class="h-4 w-4" />
                            <ArrowDownRight v-else class="h-4 w-4" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ transaction.description }}</p>
                            <div class="flex items-center space-x-2">
                                <Badge variant="secondary" class="text-xs">
                                    {{ transaction.category }}
                                </Badge>
                                <span class="text-xs text-muted-foreground">
                                    {{ formatDate(transaction.date) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span :class="['font-semibold', transaction.kind === 'income' ? 'text-primary' : 'text-foreground']">
                            {{ transaction.kind === 'income' ? '+' : '-' }}${{ formatAmount(transaction.amount) }}
                        </span>
                        <Button variant="ghost" size="sm">
                            <MoreHorizontal class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
