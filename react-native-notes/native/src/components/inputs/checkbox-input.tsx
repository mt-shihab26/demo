import type { RootRef } from '@rn-primitives/checkbox';
import type { ComponentPropsWithoutRef, RefObject } from 'react';

import { RequiredSignal } from '@/components/elements/required-signal';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { InputWrapper } from '@/components/wrappers/input-wrapper';
import { View } from 'react-native';

export const CheckboxInput = ({
    ref,
    label,
    id,
    required,
    error,
    value,
    onChange,
    ...props
}: Omit<ComponentPropsWithoutRef<typeof Checkbox>, 'id' | 'name' | 'checked' | 'onCheckedChange'> & {
    ref?: RefObject<RootRef>;
    id: string;
    label?: string;
    required?: boolean;
    error?: string;
    value: boolean;
    onChange: (value: boolean) => void;
}) => {
    return (
        <InputWrapper htmlFor={id} error={error}>
            <View className="flex flex-row items-center gap-1">
                <Checkbox ref={ref} id={id} checked={value} onCheckedChange={onChange} {...props} />
                <Label htmlFor={id} onPress={() => onChange(!value)}>
                    {label}
                    <RequiredSignal value={required} />
                </Label>
            </View>
        </InputWrapper>
    );
};
