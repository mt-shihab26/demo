<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Link } from '@inertiajs/vue3';

import Heading from '@/components/elements/Heading.vue';

const sidebarNavItems: { title: string; route: string }[] = [
    {
        title: 'Profile',
        route: 'app.settings.profile.edit',
    },
    {
        title: 'Preferences',
        route: 'app.settings.preferences.edit',
    },
    {
        title: 'Password',
        route: 'app.settings.password.edit',
    },
    {
        title: 'Two-Factor',
        route: 'app.settings.two-factor.show',
    },
    {
        title: 'Appearance',
        route: 'app.settings.appearance.edit',
    },
];
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Settings" description="Manage your profile and account settings" />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.route"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': route().current(item.route) }]"
                        as-child
                    >
                        <Link :href="route(item.route)">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
