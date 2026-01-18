export type TDateRangeFilter = 'all' | 'today' | 'this-week' | 'this-month' | 'this-year' | 'custom';

export type TTransactionFilters = {
    search: string;
    kind: string;
    category: string;
    dateRange: TDateRangeFilter;
    dateFrom: string;
    dateTo: string;
    minAmount: string;
    maxAmount: string;
};
