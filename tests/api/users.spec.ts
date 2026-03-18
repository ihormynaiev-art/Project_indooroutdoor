import { test, expect } from '@playwright/test';

test.describe('API Users Test', () => {
    test('should get users list', async ({ request }) => {
        const response = await request.get('/api/users');
        expect(response.ok()).toBeTruthy();
    });
});
