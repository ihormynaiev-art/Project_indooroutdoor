import { test as base } from '@playwright/test';
import { UserClient } from 'api/user.client';

type ApiFixtures = {
    userClient: UserClient;
};

export const test = base.extend<ApiFixtures>({
    userClient: async ({}, use) => {
        const userClientInstance = new UserClient();
        await userClientInstance.initialize();
        await use(userClientInstance);
        await userClientInstance.dispose();
    },
});

export { expect } from '@playwright/test';
