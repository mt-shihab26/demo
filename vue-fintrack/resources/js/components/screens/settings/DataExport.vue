<script setup lang="ts">
import { HeadingSmall } from '@/components/elements';
import { Button } from '@/components/ui/button';
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <div class="space-y-6">
        <HeadingSmall title="Export data" description="Download all your account data" />
        <div class="space-y-4 rounded-lg border border-blue-100 bg-blue-50 p-4 dark:border-blue-200/10 dark:bg-blue-700/10">
            <div class="relative space-y-0.5 text-blue-600 dark:text-blue-100">
                <p class="font-medium">Data Export</p>
                <p class="text-sm">Download a copy of all your account data including transactions, budgets, and categories.</p>
            </div>
            <Form :action="route('app.settings.profile.export')" method="post" v-slot="{ processing }">
                <Button :disabled="processing" data-test="export-data-button">
                    {{ processing ? 'Exporting...' : 'Export data' }}
                </Button>
            </Form>
        </div>
    </div>
</template>
