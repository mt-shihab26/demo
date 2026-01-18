import { useEffect, useRef } from 'react';

import { Loader2 } from 'lucide-react-native';
import { Animated, Easing } from 'react-native';

export const Spinner = () => {
    const spinValue = useRef(new Animated.Value(0)).current;

    useEffect(() => {
        const spinAnimation = Animated.loop(
            Animated.timing(spinValue, {
                toValue: 1,
                duration: 1000,
                easing: Easing.linear,
                useNativeDriver: true,
            }),
        );
        spinAnimation.start();

        return () => spinAnimation.stop();
    }, [spinValue]);

    const spin = spinValue.interpolate({
        inputRange: [0, 1],
        outputRange: ['0deg', '360deg'],
    });

    return (
        <Animated.View style={{ transform: [{ rotate: spin }] }}>
            <Loader2 size={20} color="currentColor" />
        </Animated.View>
    );
};
