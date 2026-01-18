import type { TBudget, TCategory } from './models';

export type TIndexCategory = TCategory & {
    transaction_count: number;
    total_amount: number;
};

export type TIndexBudget = TBudget & {
    category: TCategory;
    spent: number;
};
