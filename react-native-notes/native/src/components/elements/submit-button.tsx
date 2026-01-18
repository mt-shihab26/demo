import { Button } from '@/components/ui/button';
import { Text } from '@/components/ui/text';
import { Spinner } from './spinner';

export const SubmitButton = ({
    label,
    loading,
    disabled,
    onPress,
}: {
    label: string;
    loading?: boolean;
    disabled?: boolean;
    onPress: () => void;
}) => {
    return (
        <Button className="w-full" onPress={onPress} disabled={loading || disabled}>
            {loading && <Spinner />}
            <Text>{label}</Text>
        </Button>
    );
};
