<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import { HeadingSmall } from '@/components/elements';
import { InputPassword, SubmitButton } from '@/components/screens/settings';
import { AppLayout, SettingLayout } from '@/layouts/app-layout';

const form = useForm<{
    current_password: string;
    password: string;
    password_confirmation: string;
}>({
    current_password: '',
    password: '',
    password_confirmation: '',
});
</script>

<template>
    <AppLayout
        :breadcrumbs="[
            {
                home: true,
            },
            {
                title: 'Settings',
                href: route('app.settings.index'),
            },
            {
                title: 'Password settings',
            },
        ]"
    >
        <SettingLayout>
            <div class="space-y-6">
                <HeadingSmall title="Update password" description="Ensure your account is using a long, random password to stay secure" />

                <form
                    @submit.prevent="() => form.put(route('app.settings.password.update'), { preserveScroll: true, onSuccess: () => form.reset() })"
                    class="space-y-6"
                >
                    <InputPassword
                        id="current_password"
                        name="current_password"
                        label="Current password"
                        placeholder="Current password"
                        autocomplete="current-password"
                        v-model="form.current_password"
                        :error="form.errors.current_password"
                        required
                    />

                    <InputPassword
                        id="password"
                        name="password"
                        label="New password"
                        placeholder="New password"
                        autocomplete="new-password"
                        v-model="form.password"
                        :error="form.errors.password"
                        required
                    />

                    <InputPassword
                        id="password_confirmation"
                        name="password_confirmation"
                        label="Confirm password"
                        placeholder="Confirm password"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        required
                    />

                    <SubmitButton
                        :processing="form.processing"
                        :recently-successful="form.recentlySuccessful"
                        test-id="update-password-button"
                        button-text="Save password"
                    />
                </form>
            </div>
        </SettingLayout>
    </AppLayout>
</template>
