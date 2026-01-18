<script setup lang="ts">
import { TextLink } from '@/components/elements';
import { Button } from '@/components/ui/button';
import { AuthLayout } from '@/layouts/auth-layout';
import { Form } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout
        title="Email verification"
        label="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
    >
        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <Form :action="route('verification.send')" method="post" class="space-y-6 text-center" v-slot="{ processing }">
            <Button :disabled="processing" variant="secondary">
                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                Resend verification email
            </Button>

            <TextLink :href="route('logout')" as="button" class="mx-auto block text-sm"> Log out </TextLink>
        </Form>
    </AuthLayout>
</template>
