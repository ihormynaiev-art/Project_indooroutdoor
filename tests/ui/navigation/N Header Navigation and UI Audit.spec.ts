import { test, expect } from '@playwright/test';
import { checkUIUX, checkStyles } from 'utils/ui.ux.helper';

test.describe('Header Navigation Audit @regression', () => {
  test.beforeEach(async ({ page }) => {
    // Установка стандартного viewport и переход на главную страницу
    await page.setViewportSize({ width: 1920, height: 1080 });
    await page.goto('https://dev.indooroutdoor.com/');
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста для очистки ресурсов
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Комплексная проверка элементов хедера и навигации', async ({ page }) => {
    await test.step('Проверка логотипа и основных ссылок навигации', async () => {
      // Логотип
      await expect(page.getByRole('link', { name: 'Logo', exact: true })).toBeVisible();
      
      // Home
      await expect(page.getByRole('navigation')).toContainText('Home');
      const homeLink = page.getByRole('navigation').getByRole('link', { name: 'Home' });
      await expect(homeLink).toBeVisible();
      await homeLink.click();
    });

    await test.step('Проверка функционала Request Quote и Services', async () => {
      // Request Quote
      await expect(page.getByRole('navigation')).toContainText('Request Quote');
      await expect(page.getByRole('link', { name: 'Request Quote' })).toBeVisible();
      
      // Обработка модального окна, если оно появилось (на основе исходного теста)
      const closeButton = page.getByRole('button', { name: 'Close' });
      if (await closeButton.isVisible()) {
        await closeButton.click();
      }

      // Services
      await expect(page.locator('#menu-services')).toContainText('Services');
      // Использование точного селектора для иконки/ссылки
      await expect(page.getByRole('link', { name: 'Services ' })).toBeVisible();
    });

    await test.step('Проверка ссылок E-dition, Login и Sign Up', async () => {
      // E-dition
      await expect(page.getByRole('navigation')).toContainText('E-dition');
      await expect(page.getByRole('navigation').getByRole('link', { name: 'E-dition' })).toBeVisible();

      // Login
      await expect(page.getByRole('navigation')).toContainText('Login');
      const loginLink = page.getByRole('link', { name: 'Log In ImageLogin' });
      await expect(loginLink).toBeVisible();

      // Sign Up
      await expect(page.getByRole('navigation')).toContainText('Sign Up');
      const signUpLink = page.getByRole('link', { name: 'Sign Up' });
      await expect(signUpLink).toBeVisible();
      
      // Разделитель
      await expect(page.getByText('/', { exact: true })).toBeVisible();
    });

    await test.step('Проверка переходов на страницы Login и Sign Up', async () => {
      // Переход на Login
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await expect(page).toHaveURL(/.*login.*/);
      
      // Возврат и переход на Sign Up
      await page.goto('https://dev.indooroutdoor.com/');
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await expect(page).toHaveURL(/.*signup.*/);
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
