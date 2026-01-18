<script setup lang="ts">
import type { TKind } from '@/types/enums';
import type { TCategory } from '@/types/models';

import { colorOptions } from '@/lib/options';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const props = defineProps<{
    open: boolean;
    category?: TCategory | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
    'update:category': [value: TCategory | null];
}>();

const form = useForm<{
    name: string;
    kind: TKind;
    color: string;
}>({
    name: '',
    kind: 'expense',
    color: colorOptions[0].value,
});

watch(
    () => props.category,
    (category) => {
        if (!category) return;
        form.name = category.name;
        form.kind = category.kind;
        form.color = category.color;
    },
    {
        immediate: true,
    },
);

const cancel = () => {
    emit('update:open', false);
    emit('update:category', null);
};

const submit = () => {
    if (props.category) {
        form.patch(route('app.categories.update', { category: props.category }), { onSuccess: cancel, preserveScroll: true });
    } else {
        form.post(route('app.categories.store'), { onSuccess: cancel, preserveScroll: true });
    }
};
</script>

<template>
    <Dialog :open="open" @update:open="cancel">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>{{ category ? 'Edit Category' : 'Create New Category' }}</DialogTitle>
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
                    <Label for="name">Category Name</Label>
                    <Input v-model="form.name" id="name" name="name" placeholder="Enter category name" :required="true" />
                    <Error :message="form.errors.name" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="kind">Kind</Label>
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
                        <Label for="color">Color</Label>
                        <Select v-model="form.color" id="color" name="color">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="color in colorOptions" :key="color.value" :value="color.value">
                                    <div class="flex items-center gap-2">
                                        <div class="h-4 w-4 rounded-full" :style="`background-color: ${color.value}`" />
                                        {{ color.label }}
                                    </div>
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <Error :message="form.errors.color" />
                    </div>
                </div>

                <div class="flex items-center gap-2 rounded-lg bg-muted p-3">
                    <div class="h-6 w-6 rounded-full" :style="`background-color: ${form.color}`" />
                    <span class="font-medium">{{ form.name || 'Category Name' }}</span>
                    <span class="text-sm text-muted-foreground capitalize">({{ form.kind }})</span>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Button type="button" variant="outline" @click="cancel"> Cancel </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{
                            category
                                ? form.processing
                                    ? 'Updating Category...'
                                    : 'Update Category'
                                : form.processing
                                  ? 'Creating Category...'
                                  : 'Create Category'
                        }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
