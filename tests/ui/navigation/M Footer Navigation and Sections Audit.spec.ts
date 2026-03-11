import { test, expect } from '@playwright/test';
import { checkStyles, checkUIUX } from './helpers/ui-ux-helpers';

test.describe('Footer and Links Validation @regression', () => {
  test.beforeEach(async ({ page }) => {
    await page.setViewportSize({ width: 1920, height: 1080 });
    await page.goto('https://dev.indooroutdoor.com/');
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Проверка элементов футера и навигационных ссылок', async ({ page }) => {
    await test.step('Проверка контента футера', async () => {
      await expect(page.getByRole('contentinfo')).toContainText('Michigan Independently Owned and Operated with Pride.');
      await expect(page.getByRole('link', { name: 'logo', exact: true })).toBeVisible();
      await expect(page.getByRole('heading', { name: 'Quick Links' })).toBeVisible();
      await expect(page.getByRole('heading', { name: 'Contact Us' })).toBeVisible();
      
      // Контакты
      await expect(page.getByRole('link', { name: '734.453.6900' })).toBeVisible();
      await expect(page.locator('#copyEmailButton')).toContainText('info@indooroutdoor.com');
    });

    await test.step('Проверка юридических ссылок', async () => {
      await expect(page.getByRole('link', { name: 'Privacy Policy' })).toBeVisible();
      await expect(page.getByRole('link', { name: 'Terms & Conditions' })).toBeVisible();
    });

    await test.step('Проверка навигации по ссылкам футера', async () => {
      // Кликаем по основным ссылкам для проверки их работоспособности
      await page.getByRole('contentinfo').getByRole('link', { name: 'Home' }).click();
      await page.getByRole('contentinfo').getByRole('link', { name: 'E-dition' }).click();
      await page.getByRole('link', { name: 'Services', exact: true }).click();
      await page.getByRole('link', { name: 'Are you a Qualified' }).click();
      await page.getByRole('link', { name: 'About Us' }).click();
      await page.getByRole('link', { name: 'Privacy Policy' }).click();
      await page.getByRole('link', { name: 'Terms & Conditions' }).click();
    });

    // ОБЯЗАТЕЛЬНО: Проверка стилей (CSS) согласно README.md
    await test.step('Проверка стилей (CSS)', async () => {
      await checkStyles(page);
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});
