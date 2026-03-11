import { test as setup } from '@playwright/test';
import * as path from 'path';

const ADMIN_STORAGE_STATE_PATH = path.resolve(__dirname, '../../storage-states/admin-state.json');
const USER_STORAGE_STATE_PATH = path.resolve(__dirname, '../../storage-states/user-state.json');

setup('authenticate as admin', async ({ page }) => {
    await page.goto('/login');
    await page.locator('[data-testid="email-input"]').fill(process.env.ADMIN_EMAIL!);
    await page.locator('[data-testid="password-input"]').fill(process.env.ADMIN_PASSWORD!);
    await page.locator('[data-testid="login-button"]').click();
    await page.waitForURL('**/dashboard');
    await page.context().storageState({ path: ADMIN_STORAGE_STATE_PATH });
});

setup('authenticate as user', async ({ page }) => {
    await page.goto('/login');
    await page.locator('[data-testid="email-input"]').fill(process.env.USER_EMAIL!);
    await page.locator('[data-testid="password-input"]').fill(process.env.USER_PASSWORD!);
    await page.locator('[data-testid="login-button"]').click();
    await page.waitForURL('**/dashboard');
    await page.context().storageState({ path: USER_STORAGE_STATE_PATH });
});
