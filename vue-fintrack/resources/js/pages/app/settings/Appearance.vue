<script setup lang="ts">
import { HeadingSmall } from '@/components/elements';
import { AppearanceTabs } from '@/components/screens/settings';
import { AppLayout, SettingLayout } from '@/layouts/app-layout';
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
                title: 'Appearance settings',
            },
        ]"
    >
        <SettingLayout>
            <div class="space-y-6">
                <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                <AppearanceTabs />
            </div>
        </SettingLayout>
    </AppLayout>
</template>
