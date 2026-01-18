export const formatToastTimestamp = (timestamp: string): string => {
    const date = new Date(timestamp);
    return date.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
    });
};

export const formatProgressValue = (percentage: number): number => {
    return Math.min(percentage, 100);
};

export const formatPercentage = (Percentage: number): string => {
    return `${Percentage.toFixed(1)}%`;
};
