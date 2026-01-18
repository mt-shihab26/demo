import type { TNavItem } from '@/types';

import { FolderOpen, LayoutDashboard, Receipt, Target } from 'lucide-vue-next';

export const mainNavLinks: TNavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Transactions',
        href: '/transactions',
        icon: Receipt,
    },
    {
        title: 'Budgets',
        href: '/budgets',
        icon: Target,
    },
    {
        title: 'Categories',
        href: '/categories',
        icon: FolderOpen,
    },
];

export const rightNavLinks: TNavItem[] = [
    //
];
