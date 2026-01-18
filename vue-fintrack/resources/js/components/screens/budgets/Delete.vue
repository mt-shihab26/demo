<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';

import type { TIndexBudget } from '@/types/props';

import { buttonVariants } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { router } from '@inertiajs/vue3';

import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Trash2 } from 'lucide-vue-next';

defineProps<{
    budget: TIndexBudget;
}>();
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger as-child>
            <DropdownMenuItem @select="(event: Event) => event.preventDefault()" class="text-destructive focus:text-destructive">
                <Trash2 class="mr-2 h-4 w-4 text-destructive" />
                Delete
            </DropdownMenuItem>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Delete Budget</AlertDialogTitle>
                <AlertDialogDescription>
                    Are you sure you want to delete the budget for "{{ budget.category.name }}" (${{ budget.amount.toLocaleString() }}/{{
                        budget.period
                    }})? This action cannot be undone.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction
                    :class="cn(buttonVariants({ variant: 'destructive' }))"
                    @click="() => router.delete(route('app.budgets.destroy', budget), { preserveScroll: true })"
                >
                    Delete Budget
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
