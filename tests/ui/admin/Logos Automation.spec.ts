import { test, expect } from '@playwright/test';
import { LoginPage } from 'pages/login.page';
import { LogosPage } from 'pages/logos.page';
import { LogoFormPage } from 'pages/logo.form.page';
import { LogoShowPage } from 'pages/logo.show.page';
import * as path from 'path';

// Helper to generate a random slug starting with "A"
function generateSlug(): string {
  const chars = 'abcdefghijklmnopqrstuvwxyz0123456789_-';
  let result = 'A';
  for (let i = 0; i < 10; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return result;
}

test.describe('Admin Logos Page: Verification of UI, Sorting, and CRUD Lifecycle', () => {
  let loginPage: LoginPage;
  let logosPage: LogosPage;
  let formPage: LogoFormPage;
  let showPage: LogoShowPage;

  const testImage1 = path.resolve(__dirname, '../../../logo.png');
  const testImage2 = path.resolve(__dirname, '../../../500px-JPEG_example_down.jpg');

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
    logosPage = new LogosPage(page);
    formPage = new LogoFormPage(page);
    showPage = new LogoShowPage(page);

    // Arrange: Login as Admin
    await test.step('Login as Admin', async () => {
      await loginPage.goto();
      await loginPage.login('SSArtemS97@gmail.com', 'pepmiq-torras-qowkU1');
      await expect(page).not.toHaveURL(/.*login/, { timeout: 15000 });
    });

    // Navigate to Logos page
    await test.step('Navigate to Logos page', async () => {
      await logosPage.goto();
      await expect(logosPage.header).toBeVisible({ timeout: 15000 });
    });
  });

  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Verification of Logos Table (UI, Actual Sorting, and Pagination)', async ({ page }) => {
    // 1. UI Check
    await test.step('Verify URL and Header styles', async () => {
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/admin/logos');
      await expect(logosPage.header).toBeVisible();
      await expect(logosPage.header).toHaveText('All Logos');
      await expect(logosPage.header).toHaveCSS('font-weight', '500');
    });

    await test.step('Verify columns presence', async () => {
      await expect(logosPage.imageHeader).toBeVisible();
      await expect(logosPage.slugHeader).toBeVisible();
      await expect(logosPage.priorityHeader).toBeVisible();
      await expect(logosPage.activeHeader).toBeVisible();
      await expect(logosPage.actionHeader).toBeVisible();
    });

    // 2. Actual Sorting (Slug)
    await test.step('Verify actual sorting by Slug (Ascending and Descending)', async () => {
      const slugHeader = logosPage.slugHeader;
      
      // 1️⃣ Гарантируем включение ASC
      const labelBefore = await slugHeader.getAttribute('aria-label');
      if (labelBefore?.includes('activate to sort column ascending')) {
        await logosPage.sortBySlug();
        await expect(slugHeader).toHaveAttribute('aria-label', /activate to sort column descending/);
      }

      const ascValues = await logosPage.getColumnValues(1);
      const expectedAsc = [...ascValues].sort((a, b) => a.localeCompare(b));
      expect(ascValues, 'Values should be sorted ASC').toEqual(expectedAsc);

      // 2️⃣ Теперь переключаем в DESC (второй клик)
      const firstRowBefore = await logosPage.tableRows.first().innerText();
      await logosPage.sortBySlug();
      
      await expect(slugHeader).toHaveAttribute('aria-label', /activate to sort column ascending/);
      if (ascValues.length > 1) {
        await expect(logosPage.tableRows.first()).not.toHaveText(firstRowBefore);
      }

      const descValues = await logosPage.getColumnValues(1);
      const expectedDesc = [...descValues].sort((a, b) => b.localeCompare(a));
      expect(descValues, 'Values should be sorted DESC').toEqual(expectedDesc);
    });

    // 3. Actual Sorting (Priority)
    await test.step('Verify actual sorting by Priority (Numeric ASC and DESC)', async () => {
      await logosPage.sortByPriority();
      await expect(logosPage.priorityHeader).toHaveAttribute('aria-label', /descending/);
      
      const priorityValuesAsc = await logosPage.getColumnValues(2);
      const numericValuesAsc = priorityValuesAsc.map(v => parseInt(v, 10)).filter(v => !isNaN(v));
      const expectedNumericAsc = [...numericValuesAsc].sort((a, b) => a - b);
      expect(numericValuesAsc, 'Priority should be sorted numerically ASC').toEqual(expectedNumericAsc);

      await logosPage.sortByPriority();
      await expect(logosPage.priorityHeader).toHaveAttribute('aria-label', /ascending/);
      
      const priorityValuesDesc = await logosPage.getColumnValues(2);
      const numericValuesDesc = priorityValuesDesc.map(v => parseInt(v, 10)).filter(v => !isNaN(v));
      const expectedNumericDesc = [...numericValuesDesc].sort((a, b) => b - a);
      expect(numericValuesDesc, 'Priority should be sorted numerically DESC').toEqual(expectedNumericDesc);
    });

    // 4. Actual Sorting (Active)
    await test.step('Verify sort state change for Active column', async () => {
      await logosPage.sortByActive();
      await expect(logosPage.activeHeader).toHaveAttribute('aria-label', /ascending|descending/);
    });

    // 5. Pagination
    await test.step('Verify pagination changes active state and content', async () => {
      const firstSlugBefore = (await logosPage.getColumnValues(1))[0];
      
      await logosPage.clickPage(2);
      
      const page2Item = logosPage.paginationContainer.locator('li.page-item').filter({ hasText: '2' });
      await expect(page2Item).toHaveClass(/active/);
      
      const firstRowSlugLocator = logosPage.tableRows.first().locator('td').nth(1);
      await expect(firstRowSlugLocator).not.toHaveText(firstSlugBefore);

      await logosPage.clickPage(1);
      
      const page1Item = logosPage.paginationContainer.locator('li.page-item').filter({ hasText: '1' });
      await expect(page1Item).toHaveClass(/active/);
      
      await expect(firstRowSlugLocator).toHaveText(firstSlugBefore);
    });
  });

  test('Complete Logo Lifecycle: Create -> Show -> Edit -> Delete', async ({ page }) => {
    const initialSlug = generateSlug();
    const updatedSlug = generateSlug();

    // STEP 1: Create Logo Initial Actions
    await test.step('Navigate to Create Logo Form', async () => {
      await expect(logosPage.createButton).toBeVisible();
      await logosPage.clickCreate();
      await expect(formPage.header).toHaveText('Add Logo');
    });

    // STEP 2: Add Logo Form Validation & Creation
    await test.step('Validate constraints and Create Logo', async () => {
      const isSlugRequired = await formPage.slugInput.evaluate((el: HTMLInputElement) => el.required);
      const isPriorityRequired = await formPage.priorityInput.evaluate((el: HTMLInputElement) => el.required);
      expect(isSlugRequired).toBe(true);
      expect(isPriorityRequired).toBe(true);

      await expect(formPage.slugInput).toHaveAttribute('maxlength', '50');
      expect(await formPage.activeSwitch.isChecked()).toBe(false);

      await formPage.fillForm({
        slug: initialSlug,
        priority: '2',
        active: true,
        filePath: testImage1
      });

      await formPage.submit();
      
      await expect(page).toHaveURL(/.*admin\/logos/);
      await expect(logosPage.getLogoRow(initialSlug)).toBeVisible({ timeout: 10000 });
    });

    // STEP 3: Show & Verify (Read-Only)
    await test.step('Verify Logo details in Show mode', async () => {
      await logosPage.clickShow(initialSlug);
      
      const isLoaded = await showPage.isImageLoaded();
      expect(isLoaded, 'Image should be loaded with natural width > 0').toBe(true);

      await expect(showPage.slugInput).toBeDisabled();
      await expect(showPage.priorityInput).toBeDisabled();

      await showPage.toggleActive();
      expect(await showPage.activeSwitch.isChecked()).toBe(false);

      await expect(showPage.backButton).toBeVisible();
      await showPage.backButton.click();

      const row = logosPage.getLogoRow(initialSlug);
      await expect(row.locator('input[name="is_active"]')).not.toBeChecked();
    });

    // STEP 4: Edit & Update
    await test.step('Edit Logo details', async () => {
      await logosPage.clickEdit(initialSlug);
      await expect(formPage.header).toHaveText('Edit Logo');

      await formPage.fillForm({
        slug: updatedSlug,
        priority: '3',
        active: true,
        filePath: testImage2
      });

      await formPage.submit();
      
      await expect(page).toHaveURL(/.*admin\/logos/);
      await expect(logosPage.getLogoRow(updatedSlug)).toBeVisible();
    });

    // STEP 5: Final Verification & Delete
    await test.step('Final verification and Delete', async () => {
      const row = logosPage.getLogoRow(updatedSlug);
      await expect(row).toBeVisible();
      await expect(row.locator('td').nth(2)).toHaveText('3'); // Priority column
      await expect(row.locator('input[name="is_active"]')).toBeChecked();

      page.once('dialog', async dialog => {
        expect(dialog.type()).toBe('confirm');
        await dialog.accept();
      });

      await logosPage.clickDelete(updatedSlug);
      await expect(logosPage.getLogoRow(updatedSlug)).toBeHidden();
    });
  });
});
