<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Error, Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { AuthLayout } from '@/layouts/auth-layout';
import { Form } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthLayout
        title="Confirm password"
        label="Confirm your password"
        description="This is a secure area of the application. Please confirm your password before continuing."
    >
        <Form method="post" :action="route('password.confirm.store')" reset-on-success v-slot="{ errors, processing }">
            <div class="space-y-6">
                <div class="grid gap-2">
                    <Label htmlFor="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="current-password"
                        autofocus
                    />

                    <Error :message="errors.password" />
                </div>

                <div class="flex items-center">
                    <Button class="w-full" :disabled="processing" data-test="confirm-password-button">
                        <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                        Confirm Password
                    </Button>
                </div>
            </div>
        </Form>
    </AuthLayout>
</template>
