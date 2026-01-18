<script setup lang="ts">
import { ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { AuthLayout } from '@/layouts/auth-layout';
import { Form } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <AuthLayout title="Reset password" label="Reset password" description="Please enter your new password below">
        <Form
            :action="route('password.store')"
            method="post"
            :transform="(data) => ({ ...data, token: props.token, email: props.email })"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" type="email" name="email" autocomplete="email" v-model="inputEmail" class="mt-1 block w-full" readonly />
                    <Error :message="errors.email" class="mt-2" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        autofocus
                        placeholder="Password"
                    />
                    <Error :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"> Confirm Password </Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Confirm password"
                    />
                    <Error :message="errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-4 w-full" :disabled="processing" data-test="reset-password-button">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                    Reset password
                </Button>
            </div>
        </Form>
    </AuthLayout>
</template>
