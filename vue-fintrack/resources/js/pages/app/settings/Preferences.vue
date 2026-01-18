<script setup lang="ts">
import type { TAppProps } from '@/types';
import type { TCurrency } from '@/types/enums';

import { currencyOptions } from '@/lib/options';
import { useForm, usePage } from '@inertiajs/vue3';

import { HeadingSmall } from '@/components/elements';
import { InputSelect, InputToggle, SubmitButton, WarningAlert } from '@/components/screens/settings';
import { AppLayout, SettingLayout } from '@/layouts/app-layout';

const page = usePage<TAppProps>();

const user = page.props.auth.user;

const form = useForm<{
    currency: TCurrency;
    email_notifications: boolean;
    push_notifications: boolean;
    budget_alerts: boolean;
    weekly_reports: boolean;
}>({
    currency: user.currency ?? 'BDT',
    push_notifications: user.push_notifications ?? true,
    email_notifications: user.email_notifications ?? false,
    budget_alerts: user.budget_alerts ?? false,
    weekly_reports: user.weekly_reports ?? false,
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
                title: 'Preferences settings',
            },
        ]"
    >
        <SettingLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Preferences" description="Update your general and notification preferences" />

                <form
                    @submit.prevent="form.patch(route('app.settings.preferences.update'), { preserveScroll: true, preserveState: false })"
                    class="space-y-6"
                >
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">General</h3>
                            <div class="space-y-4">
                                <InputSelect
                                    id="currency"
                                    name="currency"
                                    label="Currency"
                                    v-model="form.currency"
                                    :options="currencyOptions"
                                    :error="form.errors.currency"
                                />
                                <WarningAlert
                                    title="Important"
                                    message="Changing your currency will only update the display format for future transactions. Existing transaction amounts will not be converted. For best results, set your preferred currency immediately after registration, before adding any transactions."
                                />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">Notifications</h3>
                            <div class="space-y-4">
                                <InputToggle
                                    id="push-notifications"
                                    name="push_notifications"
                                    label="Push Notifications"
                                    description="Receive push notifications in browser"
                                    v-model="form.push_notifications"
                                    :error="form.errors.push_notifications"
                                />

                                <InputToggle
                                    id="email-notifications"
                                    name="email_notifications"
                                    label="Email Notifications"
                                    description="Receive notifications via email"
                                    v-model="form.email_notifications"
                                    :error="form.errors.email_notifications"
                                />

                                <InputToggle
                                    id="budget-alerts"
                                    name="budget_alerts"
                                    label="Budget Alerts"
                                    description="Get notified when approaching budget limits"
                                    v-model="form.budget_alerts"
                                    :error="form.errors.budget_alerts"
                                />

                                <InputToggle
                                    id="weekly-reports"
                                    name="weekly_reports"
                                    label="Weekly Reports"
                                    description="Receive weekly spending summaries"
                                    v-model="form.weekly_reports"
                                    :error="form.errors.weekly_reports"
                                />
                            </div>
                        </div>
                    </div>

                    <SubmitButton
                        :processing="form.processing"
                        :recently-successful="form.recentlySuccessful"
                        button-text="Save Preferences"
                        success-text="Preferences saved."
                        test-id="save-preferences-button"
                    />
                </form>
            </div>
        </SettingLayout>
    </AppLayout>
</template>
