<script setup lang="ts">
import { AppLayout } from '@/layouts/app-layout';

import BudgetProgress from '@/components/screens/dashboard/BudgetProgress.vue';
import RecentTransactions from '@/components/screens/dashboard/RecentTransactions.vue';
import SpendingChart from '@/components/screens/dashboard/SpendingChart.vue';
import SummaryCards from '@/components/screens/dashboard/SummaryCards.vue';
</script>

<template>
    <AppLayout :breadcrumbs="[{ title: 'Dashboard' }]">
        <div class="space-y-8">
            <div>
                <h1 class="text-3xl font-bold text-balance">Financial Dashboard</h1>
                <p class="text-pretty text-muted-foreground">Track your spending, manage budgets, and monitor your financial health.</p>
            </div>

            <SummaryCards />

            <div class="grid gap-6 lg:grid-cols-2">
                <SpendingChart />
                <BudgetProgress />
            </div>

            <RecentTransactions />
        </div>
    </AppLayout>
</template>
