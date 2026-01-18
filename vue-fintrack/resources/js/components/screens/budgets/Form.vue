<script setup lang="ts">
import type { TPeriod } from '@/types/enums';
import type { TCategory, TId } from '@/types/models';
import type { TIndexBudget } from '@/types/props';

import { useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const props = defineProps<{
    open: boolean;
    budget?: TIndexBudget | null;
    categories: TCategory[];
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
    'update:budget': [value: TIndexBudget | null];
}>();

const form = useForm<{
    category_id: TId | null;
    amount: string;
    period: TPeriod;
}>({
    category_id: null,
    amount: '',
    period: 'monthly',
});

watch(
    () => props.budget,
    (budget) => {
        if (!budget) return;
        form.category_id = budget.category_id;
        form.amount = budget.amount.toString();
        form.period = budget.period;
    },
    {
        immediate: true,
    },
);

const cancel = () => {
    emit('update:open', false);
    emit('update:budget', null);
    form.reset();
};

const submit = () => {
    if (props.budget) {
        form.patch(route('app.budgets.update', { budget: props.budget }), { onSuccess: cancel, preserveScroll: true });
    } else {
        form.post(route('app.budgets.store'), { onSuccess: cancel, preserveScroll: true });
    }
};

const categories = computed(() => (props.budget ? [props.budget.category, ...props.categories] : props.categories));
</script>

<template>
    <Dialog :open="open" @update:open="cancel">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>{{ budget ? 'Edit Budget' : 'Create New Budget' }}</DialogTitle>
            </DialogHeader>
            <form
                @submit="
                    (e) => {
                        e.preventDefault();
                        submit();
                    }
                "
                class="space-y-4"
            >
                <div class="space-y-2">
                    <Label for="category_id">Category</Label>
                    <Select v-model="form.category_id" id="category_id" name="category_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                <div class="flex items-center gap-2">
                                    <div class="h-4 w-4 rounded-full" :style="`background-color: ${category.color}`" />
                                    {{ category.name }}
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <Error :message="form.errors.category_id" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="amount">Budget Amount</Label>
                        <Input v-model="form.amount" id="amount" name="amount" type="number" step="0.01" placeholder="0.00" :required="true" />
                        <Error :message="form.errors.amount" />
                    </div>

                    <div class="space-y-2">
                        <Label for="period">Period</Label>
                        <Select v-model="form.period" id="period" name="period">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="weekly">Weekly</SelectItem>
                                <SelectItem value="monthly">Monthly</SelectItem>
                            </SelectContent>
                        </Select>
                        <Error :message="form.errors.period" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Button type="button" variant="outline" @click="cancel"> Cancel </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{
                            budget
                                ? form.processing
                                    ? 'Updating Budget...'
                                    : 'Update Budget'
                                : form.processing
                                  ? 'Creating Budget...'
                                  : 'Create Budget'
                        }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
