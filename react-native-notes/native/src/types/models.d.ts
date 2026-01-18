export type TId = number;

export type TUser = {
    id: TId;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
};
