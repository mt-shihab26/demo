<script setup lang="ts">
import { computed, ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Error, Input } from '@/components/ui/input';
import { PinInput, PinInputGroup, PinInputSlot } from '@/components/ui/pin-input';
import { AuthLayout } from '@/layouts/auth-layout';
import { Form } from '@inertiajs/vue3';

const authConfigContent = computed<{
    title: string;
    description: string;
    toggleText: string;
}>(() => {
    if (showRecoveryInput.value) {
        return {
            title: 'Recovery Code',
            description: 'Please confirm access to your account by entering one of your emergency recovery codes.',
            toggleText: 'login using an authentication code',
        };
    }

    return {
        title: 'Authentication Code',
        description: 'Enter the authentication code provided by your authenticator application.',
        toggleText: 'login using a recovery code',
    };
});

const showRecoveryInput = ref<boolean>(false);

const toggleRecoveryMode = (clearErrors: () => void): void => {
    showRecoveryInput.value = !showRecoveryInput.value;
    clearErrors();
    code.value = [];
};

const code = ref<number[]>([]);
const codeValue = computed<string>(() => code.value.join(''));
</script>

<template>
    <AuthLayout title="Two-Factor Authentication" :label="authConfigContent.title" :description="authConfigContent.description">
        <div class="space-y-6">
            <template v-if="!showRecoveryInput">
                <Form
                    method="post"
                    :action="route('two-factor.login.store')"
                    class="space-y-4"
                    reset-on-error
                    @error="code = []"
                    #default="{ errors, processing, clearErrors }"
                >
                    <input type="hidden" name="code" :value="codeValue" />
                    <div class="flex flex-col items-center justify-center space-y-3 text-center">
                        <div class="flex w-full items-center justify-center">
                            <PinInput id="otp" placeholder="○" v-model="code" type="number" otp>
                                <PinInputGroup>
                                    <PinInputSlot v-for="(id, index) in 6" :key="id" :index="index" :disabled="processing" autofocus />
                                </PinInputGroup>
                            </PinInput>
                        </div>
                        <Error :message="errors.code" />
                    </div>
                    <Button type="submit" class="w-full" :disabled="processing">Continue</Button>
                    <div class="text-center text-sm text-muted-foreground">
                        <span>or you can </span>
                        <button
                            type="button"
                            class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            @click="() => toggleRecoveryMode(clearErrors)"
                        >
                            {{ authConfigContent.toggleText }}
                        </button>
                    </div>
                </Form>
            </template>

            <template v-else>
                <Form
                    method="post"
                    :action="route('two-factor.login.store')"
                    class="space-y-4"
                    reset-on-error
                    #default="{ errors, processing, clearErrors }"
                >
                    <Input name="recovery_code" type="text" placeholder="Enter recovery code" :autofocus="showRecoveryInput" required />
                    <Error :message="errors.recovery_code" />
                    <Button type="submit" class="w-full" :disabled="processing">Continue</Button>

                    <div class="text-center text-sm text-muted-foreground">
                        <span>or you can </span>
                        <button
                            type="button"
                            class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            @click="() => toggleRecoveryMode(clearErrors)"
                        >
                            {{ authConfigContent.toggleText }}
                        </button>
                    </div>
                </Form>
            </template>
        </div>
    </AuthLayout>
</template>
