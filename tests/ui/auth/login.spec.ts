import { test, expect } from 'fixtures/app.fixture';

test.describe('Login Page', () => {
    test('should display login form elements', async ({ loginPage }) => {
        await loginPage.navigateTo('/login');
        await expect(loginPage.emailInput).toBeVisible();
        await expect(loginPage.passwordInput).toBeVisible();
        await expect(loginPage.loginButton).toBeVisible();
    });

    test('should show error for invalid credentials', async ({ loginPage }) => {
        await loginPage.navigateTo('/login');
        await loginPage.login('invalid@email.com', 'wrong_password');
        await expect(loginPage.errorMessage).toBeVisible();
    });
});
