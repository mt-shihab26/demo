import { Text } from '@/components/ui/text';

export const RequiredSignal = ({ value }: { value?: boolean }) => {
    if (!value) {
        return null;
    }

    return <Text className="text-destructive"> *</Text>;
};
