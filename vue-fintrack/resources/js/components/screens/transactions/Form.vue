<script setup lang="ts">
import type { TCategory, TTransaction } from '@/types/models';

import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Plus, X } from 'lucide-vue-next';

const props = defineProps<{
    open: boolean;
    transaction?: TTransaction | null;
    categories: TCategory[];
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
    'update:transaction': [value: TTransaction | null];
}>();

const form = useForm<{
    kind: 'income' | 'expense';
    amount: string;
    category: string;
    description: string;
    date: string;
    tags: string[];
}>({
    kind: 'expense',
    amount: '',
    category: '',
    description: '',
    date: new Date().toISOString().split('T')[0],
    tags: [],
});

const newTag = ref('');

watch(
    () => props.transaction,
    (transaction) => {
        if (!transaction) return;
        form.kind = transaction.kind;
        form.amount = transaction.amount.toString();
        form.category = transaction.category;
        form.description = transaction.description;
        form.date = transaction.date;
        form.tags = [...(transaction.tags || [])];
    },
    {
        immediate: true,
    },
);

const cancel = () => {
    emit('update:open', false);
    emit('update:transaction', null);
    form.reset();
    newTag.value = '';
};

const submit = () => {
    if (props.transaction) {
        form.patch(route('app.transactions.update', { transaction: props.transaction }), { onSuccess: cancel, preserveScroll: true });
    } else {
        form.post(route('app.transactions.store'), { onSuccess: cancel, preserveScroll: true });
    }
};

const addTag = () => {
    if (newTag.value.trim() && !form.tags.includes(newTag.value.trim())) {
        form.tags.push(newTag.value.trim());
        newTag.value = '';
    }
};

const removeTag = (tagToRemove: string) => {
    form.tags = form.tags.filter((tag) => tag !== tagToRemove);
};

const handleKeyPress = (e: KeyboardEvent) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        addTag();
    }
};

const availableCategories = computed(() => props.categories.filter((cat) => cat.kind === form.kind));
</script>

<template>
    <Dialog :open="open" @update:open="cancel">
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>{{ transaction ? 'Edit Transaction' : 'Add New Transaction' }}</DialogTitle>
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
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="kind">Type</Label>
                        <Select v-model="form.kind" id="kind" name="kind">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="income">Income</SelectItem>
                                <SelectItem value="expense">Expense</SelectItem>
                            </SelectContent>
                        </Select>
                        <Error :message="form.errors.kind" />
                    </div>

                    <div class="space-y-2">
                        <Label for="amount">Amount</Label>
                        <Input v-model="form.amount" id="amount" name="amount" type="number" step="0.01" placeholder="0.00" :required="true" />
                        <Error :message="form.errors.amount" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="category">Category</Label>
                        <Select v-model="form.category" id="category" name="category">
                            <SelectTrigger>
                                <SelectValue placeholder="Select category" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="cat in availableCategories" :key="cat.id" :value="cat.name">
                                    <div class="flex items-center gap-2">
                                        <div class="h-4 w-4 rounded-full" :style="`background-color: ${cat.color}`" />
                                        {{ cat.name }}
                                    </div>
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <Error :message="form.errors.category" />
                    </div>

                    <div class="space-y-2">
                        <Label for="date">Date</Label>
                        <Input v-model="form.date" id="date" name="date" type="date" :required="true" />
                        <Error :message="form.errors.date" />
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        name="description"
                        class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                        placeholder="Enter transaction description"
                        required
                    />
                    <Error :message="form.errors.description" />
                </div>

                <div class="space-y-2">
                    <Label>Tags</Label>
                    <div class="mb-2 flex flex-wrap gap-2">
                        <Badge v-for="tag in form.tags" :key="tag" variant="secondary" class="flex items-center gap-1">
                            {{ tag }}
                            <X class="h-3 w-3 cursor-pointer" @click="removeTag(tag)" />
                        </Badge>
                    </div>
                    <div class="flex gap-2">
                        <Input placeholder="Add tag" v-model="newTag" @keypress="handleKeyPress" />
                        <Button type="button" variant="outline" size="sm" @click="addTag">
                            <Plus class="h-4 w-4" />
                        </Button>
                    </div>
                    <Error :message="form.errors.tags" />
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Button type="button" variant="outline" @click="cancel"> Cancel </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{
                            transaction
                                ? form.processing
                                    ? 'Updating Transaction...'
                                    : 'Update Transaction'
                                : form.processing
                                  ? 'Adding Transaction...'
                                  : 'Add Transaction'
                        }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
