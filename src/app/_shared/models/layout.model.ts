export interface LayoutType {
    id: string;
    name: string;
}

export interface Layout {
    id: string;
    title: string;
    description: string;
    createdAt: Date;
    user: {
        id: string;
        username: string;
        firstName: string;
        middleName: string;
        lastName: string;
        mobile: string;
        email: string;
    },
    layoutType: LayoutType;
}