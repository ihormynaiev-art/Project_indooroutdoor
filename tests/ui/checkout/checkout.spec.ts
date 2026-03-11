import { test, expect } from 'fixtures/app.fixture';

test.describe('Checkout Flow', () => {
    test('should display checkout page', async ({ page }) => {
        await page.goto('/checkout');
        await expect(page).toHaveURL(/.*checkout/);
    });
});
