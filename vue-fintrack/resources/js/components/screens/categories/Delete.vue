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

import type { TIndexCategory } from '@/types/props';

import { buttonVariants } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { router } from '@inertiajs/vue3';

import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Trash2 } from 'lucide-vue-next';

defineProps<{
    category: TIndexCategory;
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
                <AlertDialogTitle>Delete Category</AlertDialogTitle>
                <AlertDialogDescription>
                    Are you sure you want to delete the category "{{ category.name }}"? This action cannot be undone.
                    <span v-if="category.transaction_count > 0" class="mt-2 block text-destructive">
                        This category has {{ category.transaction_count }} transaction(s) associated with it.
                    </span>
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction
                    :class="cn(buttonVariants({ variant: 'destructive' }))"
                    @click="() => router.delete(route('app.categories.destroy', category), { preserveScroll: true })"
                >
                    Delete Category
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
