import type { TextInput } from 'react-native';

import { useAuth } from '@/providers/auth';
import { useRef, useState } from 'react';

import { PromptLink } from '@/components/elements/prompt-link';
import { SubmitButton } from '@/components/elements/submit-button';
import { GuestGuard } from '@/components/guards/guest-guard';
import { CheckboxInput } from '@/components/inputs/checkbox-input';
import { EmailInput } from '@/components/inputs/email-input';
import { PasswordInput } from '@/components/inputs/password-input';
import { Text } from '@/components/ui/text';
import { AuthWrapper } from '@/components/wrappers/auth-wrapper';
import { Link } from 'expo-router';

const Login = () => {
    const { login } = useAuth();

    const [email, setEmail] = useState('text@example.com');
    const [password, setPassword] = useState('12345678');
    const [remember, setRemember] = useState(false);

    const passwordInputRef = useRef<TextInput>(null);

    const handleSubmit = () => {
        if (!email || !password) return;
        login.mutate({ email, password });
    };

    const error = login.isError ? 'Invalid credentials' : '';

    return (
        <GuestGuard>
            <AuthWrapper title="Sign in to your app" description="Welcome back! Please sign in to continue">
                <EmailInput
                    id="email"
                    required={true}
                    value={email}
                    onChangeText={setEmail}
                    onSubmitEditing={passwordInputRef.current?.focus}
                    error={error}
                />
                <PasswordInput
                    id="password"
                    ref={passwordInputRef}
                    required={true}
                    value={password}
                    onChangeText={setPassword}
                    onSubmitEditing={handleSubmit}
                    error={error}
                    labelRight={
                        <Link href="/forgot-password">
                            <Text className="text-sm leading-4 font-normal">Forgot your password?</Text>
                        </Link>
                    }
                />
                <CheckboxInput id="remember" value={remember} onChange={setRemember} label="Remember Me" />
                <SubmitButton label="Continue" loading={login.isPending} onPress={handleSubmit} />
                <PromptLink message="Don't have an account?" label="Sign up" href="/register" />
            </AuthWrapper>
        </GuestGuard>
    );
};

export default Login;
