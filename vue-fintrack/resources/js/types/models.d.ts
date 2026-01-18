import type { TCurrency, TKind, TPeriod } from './enums';

export type TId = number;

export type TUser = {
    id: TId;
    name: string;
    email: string;
    email_verified_at: string | null;
    avatar: string | null;
    currency: TCurrency;
    email_notifications: boolean;
    push_notifications: boolean;
    budget_alerts: boolean;
    weekly_reports: boolean;
    created_at: string;
    updated_at: string;
};

export type TCategory = {
    id: TId;
    user_id: TId;
    name: string;
    kind: TKind;
    color: string;
};

export type TBudget = {
    id: TId;
    category_id: TId;
    amount: number;
    period: TPeriod;
};

export type TTransaction = {
    id: TId;
    kind: TKind;
    amount: number;
    category: string;
    description: string;
    date: string;
    tags?: string[];
};
