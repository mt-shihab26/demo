<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';

import { HeadingSmall } from '@/components/elements';
import { AvatarUpload, DangerZone, DataExport, InputString, SubmitButton } from '@/components/screens/settings';
import { AppLayout, SettingLayout } from '@/layouts/app-layout';
import { Link } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail: boolean;
    status?: string;
}>();

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    _method: 'PATCH',
    name: user.name,
    email: user.email,
    avatar: null as File | null,
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
                title: 'Profile settings',
            },
        ]"
    >
        <SettingLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Update your profile picture, name and email address" />

                <form
                    @submit.prevent="
                        () => form.post(route('app.settings.profile.update'), { preserveScroll: true, preserveState: false, forceFormData: true })
                    "
                    class="space-y-6"
                >
                    <AvatarUpload :user="user" v-model="form.avatar" :error="form.errors.avatar" />

                    <InputString
                        id="name"
                        name="name"
                        label="Name"
                        v-model="form.name"
                        placeholder="Full name"
                        autocomplete="name"
                        required
                        :error="form.errors.name"
                    />

                    <InputString
                        id="email"
                        name="email"
                        label="Email address"
                        type="email"
                        v-model="form.email"
                        placeholder="Email address"
                        autocomplete="username"
                        required
                        :error="form.errors.email"
                    />

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <SubmitButton :processing="form.processing" :recently-successful="form.recentlySuccessful" test-id="update-profile-button" />
                </form>
            </div>

            <DataExport />
            <DangerZone />
        </SettingLayout>
    </AppLayout>
</template>
