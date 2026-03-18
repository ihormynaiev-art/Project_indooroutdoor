import { test, expect } from '@playwright/test';
import { LoginPage } from 'pages/login.page';
import { AdminsPage } from 'pages/admins.page';
import { AdminDetailsPage } from 'pages/admin.details.page';
import { checkUIUX, checkStyles } from 'utils/ui.ux.helper';

test.describe('Admin Panel / All Admins Management @regression', () => {
  let loginPage: LoginPage;
  let adminsPage: AdminsPage;
  let detailsPage: AdminDetailsPage;

  test.beforeEach(async ({ page }) => {
    // Установка стандартного размера viewport согласно README.md
    await page.setViewportSize({ width: 1920, height: 1080 });
    
    loginPage = new LoginPage(page);
    adminsPage = new AdminsPage(page);
    detailsPage = new AdminDetailsPage(page);

    // Arrange: Login as Admin
    await test.step('Авторизация администратора', async () => {
      await loginPage.goto();
      await loginPage.login('ssartems97@gmail.com', 'pepmiq-torras-qowkU1');
    });
    
    // Navigate to Admins page
    await test.step('Переход на страницу All Admins', async () => {
      await adminsPage.goto();
      await expect(adminsPage.pageHeader).toBeVisible({ timeout: 15000 });
    });
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста согласно README.md
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Search, Sort and View Admin Details', async ({ page }) => {
    const targetAdmin = 'Артем Скрипник';
    const targetEmail = 'ssartems97@gmail.com';

    // 1. Verify page load and header
    await test.step('Проверка загрузки страницы и заголовка', async () => {
      await expect(page).toHaveURL(/.*admin\/admins/);
      await expect(adminsPage.pageHeader).toHaveText('All Admins');
    });

    // 2. Search by Name
    await test.step('Поиск по имени и сброс фильтра', async () => {
      await adminsPage.searchByName(targetAdmin);
      // Ждем, пока в таблице останется только нужная строка
      await expect(adminsPage.adminsTable.locator('tbody tr')).toContainText([targetAdmin]);
      // И теперь проверяем количество
      await expect(adminsPage.adminsTable.locator('tbody tr')).toHaveCount(1);

      await adminsPage.resetFilters();
      await expect(adminsPage.adminsTable.locator('tbody tr')).toHaveCount(3); // Based on the 3 items in HTML fragment
    });

    // 3. Search by Email
    await test.step('Поиск по Email и сброс фильтра', async () => {
      await adminsPage.searchByEmail(targetEmail);
      // Ждем, пока в таблице останется только нужная строка
      await expect(adminsPage.adminsTable.locator('tbody tr')).toContainText([targetEmail]);
      await expect(adminsPage.adminsTable.locator('tbody tr')).toHaveCount(1);
      
      await adminsPage.resetFilters();
      await expect(adminsPage.adminsTable.locator('tbody tr')).toHaveCount(3);
    });

    // 4. Sort by Name
    await test.step('Проверка сортировки по имени', async () => {
      await adminsPage.sortByColumn('Name', 'ascending');
      await expect(adminsPage.nameColumn).toHaveAttribute('aria-sort', 'ascending');
      
      await adminsPage.sortByColumn('Name', 'descending');
      await expect(adminsPage.nameColumn).toHaveAttribute('aria-sort', 'descending');
    });

    // 5. Sort by Email
    await test.step('Проверка сортировки по Email', async () => {
      await adminsPage.sortByColumn('Email', 'ascending');
      await expect(adminsPage.emailColumn).toHaveAttribute('aria-sort', 'ascending');
      
      await adminsPage.sortByColumn('Email', 'descending');
      await expect(adminsPage.emailColumn).toHaveAttribute('aria-sort', 'descending');
    });

    // 6. View Admin Details (Show)
    await test.step('Просмотр деталей администратора', async () => {
      await adminsPage.searchByName(targetAdmin);
      
      // Кликаем и ждем перехода (логика ожидания внутри POM)
      await adminsPage.clickShowForAdmin(targetAdmin);

      // Verify Details Page
      await expect(page.getByRole('heading', { name: targetAdmin })).toBeVisible();
      
      // Ждем видимости полей перед проверкой
      await expect(detailsPage.nameInput).toBeVisible({ timeout: 10000 });
      await expect(detailsPage.emailInput).toBeVisible({ timeout: 10000 });

      // Проверяем значения и состояние (disabled)
      await expect(detailsPage.nameInput).toHaveValue(targetAdmin);
      await expect(detailsPage.emailInput).toHaveValue(targetEmail);
      await expect(detailsPage.nameInput).toBeDisabled();
      await expect(detailsPage.emailInput).toBeDisabled();

      // Go back
      await detailsPage.backButton.click();
      await expect(adminsPage.pageHeader).toBeVisible();
    });

    // ОБЯЗАТЕЛЬНО: Проверки UI/UX и стилей согласно README.md
    await test.step('Комплексная проверка UI/UX и стилей', async () => {
      await checkStyles(page);
      await checkUIUX(page);
    });
  });

  test('Delete Admin Action - Cancel/Dismiss @new', async ({ page }) => {
    const targetAdmin = 'jim'; // From HTML fragment

    await test.step('Поиск администратора для удаления', async () => {
      await adminsPage.searchByName(targetAdmin);
    });
    
    await test.step('Проверка отмены удаления в диалоговом окне', async () => {
      // Handle dialog if it's a native window.confirm
      page.once('dialog', async dialog => {
        expect(dialog.type()).toBe('confirm');
        expect(dialog.message()).toContain('delete'); // Typical message
        await dialog.dismiss();
      });

      await adminsPage.clickDeleteForAdmin(targetAdmin);
      
      // Verify admin still exists since we cancelled
      await expect(adminsPage.getAdminRow(targetAdmin).first()).toBeVisible();
    });

    // ОБЯЗАТЕЛЬНО: Проверка стилей согласно README.md
    await test.step('Проверка стилей', async () => {
      await checkStyles(page);
    });
  });
});
