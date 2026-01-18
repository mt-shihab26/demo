import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';
import type { TUser } from './models';

export type TBreadcrumb = {
    title?: string;
    href?: string;
    home?: boolean;
};

export type TNavItem = {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
};

type TFlashItem = { message: string; timestamp: string };

export type TAppProps = {
    name: string;
    auth: { user: TUser };
    flash: { success: TFlashItem | null; error: TFlashItem | null };
};
