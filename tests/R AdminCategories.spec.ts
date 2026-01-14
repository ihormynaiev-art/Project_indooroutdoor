import { test, expect } from '@playwright/test';
import { LoginPage } from './pages/login.page';
import { CategoriesPage } from './pages/categories.page';

test.describe('Admin Panel - Categories Management', () => {
  let loginPage: LoginPage;
  let categoriesPage: CategoriesPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
    categoriesPage = new CategoriesPage(page);

    // Arrange: Login to the Admin Panel
    await loginPage.goto();
    await loginPage.login('SSArtemS97@gmail.com', 'pepmiq-torras-qowkU1');
    
    // Check if we are logged in - simple check to ensure navigation passed
    // (Actual navigation to categories happens in the test step)
  });

  test('Search, Sort and Table Validation for Categories', async ({ page }) => {
    // Act: Navigate to the Categories page
    await categoriesPage.goto();

    // Assert: Verify the "All Categories" page header is visible
    await expect(categoriesPage.pageHeader).toBeVisible();

    // --- Pagination and Sorting Checks (on full list) ---

    // Act: Verify sorting functionality on the "Name" column
    await categoriesPage.sortByColumn('Name', 'ascending');
    await expect(categoriesPage.nameColumnHeader).toHaveAttribute('aria-sort', 'ascending');

    await categoriesPage.sortByColumn('Name', 'descending');
    await expect(categoriesPage.nameColumnHeader).toHaveAttribute('aria-sort', 'descending');

    // Act: Verify pagination functionality
    const isPaginationVisible = await categoriesPage.nextButton.isVisible();
    if (isPaginationVisible) {
      const initialInfo = await categoriesPage.paginationInfo.textContent();
      
      await categoriesPage.clickNext();
      const nextInfo = await categoriesPage.paginationInfo.textContent();
      expect(nextInfo).not.toBe(initialInfo);
      
      await categoriesPage.clickPrevious();
      const prevInfo = await categoriesPage.paginationInfo.textContent();
      expect(prevInfo).toBe(initialInfo);
    }

    // --- Search and Row Validation ---

    // Act: Perform a search by category name: "Appliance Repair"
    await categoriesPage.searchCategory('Appliance Repair');

    // Assert: Verify that the table filters and shows the correct row
    const targetRow = categoriesPage.getCategoryRow('Appliance Repair');
    await expect(targetRow).toBeVisible();
    
    // Assert: Verify that the "Edit" and "Delete" buttons are present for the category
    await expect(targetRow.locator('.table-edit')).toBeVisible();
    await expect(targetRow.locator('.table-delete')).toBeVisible();
  });
});
