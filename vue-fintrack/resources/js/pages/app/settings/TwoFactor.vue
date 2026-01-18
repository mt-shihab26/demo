<script setup lang="ts">
import { useTwoFactorAuth } from '@/composables/use-two-factor-auth';
import { onUnmounted, ref } from 'vue';

import { HeadingSmall, TwoFactorRecoveryCodes, TwoFactorSetupModal } from '@/components/elements';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { AppLayout, SettingLayout } from '@/layouts/app-layout';
import { Form } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';

withDefaults(
    defineProps<{
        requiresConfirmation?: boolean;
        twoFactorEnabled?: boolean;
    }>(),
    {
        requiresConfirmation: false,
        twoFactorEnabled: false,
    },
);

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();

const showSetupModal = ref<boolean>(false);

onUnmounted(() => clearTwoFactorAuthData());
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
                title: 'Two-Factor settings',
            },
        ]"
    >
        <SettingLayout>
            <div class="space-y-6">
                <HeadingSmall title="Two-Factor Authentication" description="Manage your two-factor authentication settings" />

                <div v-if="!twoFactorEnabled" class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="destructive">Disabled</Badge>

                    <p class="text-muted-foreground">
                        When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from
                        a TOTP-supported application on your phone.
                    </p>

                    <div>
                        <Button v-if="hasSetupData" @click="showSetupModal = true"> <ShieldCheck />Continue Setup </Button>
                        <Form v-else method="post" :action="route('two-factor.enable')" @success="showSetupModal = true" #default="{ processing }">
                            <Button type="submit" :disabled="processing"> <ShieldCheck />Enable 2FA</Button></Form
                        >
                    </div>
                </div>

                <div v-else class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="default">Enabled</Badge>

                    <p class="text-muted-foreground">
                        With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve
                        from the TOTP-supported application on your phone.
                    </p>

                    <TwoFactorRecoveryCodes />

                    <div class="relative inline">
                        <Form method="delete" :action="route('two-factor.disable')" #default="{ processing }">
                            <Button variant="destructive" type="submit" :disabled="processing">
                                <ShieldBan />
                                Disable 2FA
                            </Button>
                        </Form>
                    </div>
                </div>

                <TwoFactorSetupModal
                    v-model:isOpen="showSetupModal"
                    :requiresConfirmation="requiresConfirmation"
                    :twoFactorEnabled="twoFactorEnabled"
                />
            </div>
        </SettingLayout>
    </AppLayout>
</template>
