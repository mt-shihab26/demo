import type { TTransaction } from '@/types/models';
import type { TIndexBudget, TIndexCategory } from '@/types/props';

export const transactions: TTransaction[] = [
    {
        id: 1,
        kind: 'expense',
        amount: 85.5,
        category: 'Food',
        description: 'Grocery shopping at Whole Foods',
        date: '2024-01-15',
        tags: ['groceries', 'essential'],
    },
    {
        id: 2,
        kind: 'income',
        amount: 3500.0,
        category: 'Salary',
        description: 'Monthly salary',
        date: '2024-01-01',
        tags: ['work'],
    },
    {
        id: 3,
        kind: 'expense',
        amount: 1200.0,
        category: 'Rent',
        description: 'Monthly rent payment',
        date: '2024-01-01',
        tags: ['housing', 'fixed'],
    },
    {
        id: 4,
        kind: 'expense',
        amount: 45.0,
        category: 'Transportation',
        description: 'Gas for car',
        date: '2024-01-10',
        tags: ['fuel', 'transport'],
    },
    {
        id: 5,
        kind: 'expense',
        amount: 25.0,
        category: 'Entertainment',
        description: 'Movie tickets',
        date: '2024-01-12',
        tags: ['leisure', 'cinema'],
    },
    {
        id: 6,
        kind: 'income',
        amount: 500.0,
        category: 'Freelance',
        description: 'Web development project',
        date: '2024-01-08',
        tags: ['freelance', 'work'],
    },
    {
        id: 7,
        kind: 'expense',
        amount: 75.0,
        category: 'Utilities',
        description: 'Electricity bill',
        date: '2024-01-05',
        tags: ['bills', 'utilities'],
    },
    {
        id: 8,
        kind: 'expense',
        amount: 120.0,
        category: 'Food',
        description: 'Dinner at restaurant',
        date: '2024-01-14',
        tags: ['dining', 'food'],
    },
    {
        id: 9,
        kind: 'expense',
        amount: 30.0,
        category: 'Healthcare',
        description: 'Pharmacy purchase',
        date: '2024-01-11',
        tags: ['health', 'medicine'],
    },
    {
        id: 10,
        kind: 'income',
        amount: 200.0,
        category: 'Investment',
        description: 'Dividend payment',
        date: '2024-01-03',
        tags: ['investment', 'dividend'],
    },
];

export const categories: TIndexCategory[] = [];

export const budgets: TIndexBudget[] = [];
