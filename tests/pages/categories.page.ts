import { Page, Locator } from '@playwright/test';

export class CategoriesPage {
  readonly page: Page;
  readonly pageHeader: Locator;
  readonly searchInput: Locator;
  readonly categoriesTable: Locator;
  readonly nameColumnHeader: Locator;
  readonly nextButton: Locator;
  readonly previousButton: Locator;
  readonly paginationInfo: Locator;

  constructor(page: Page) {
    this.page = page;
    this.pageHeader = page.getByRole('heading', { name: 'All Categories' });
    this.searchInput = page.locator('#search:visible');
    this.categoriesTable = page.locator('#categories-data');
    this.nameColumnHeader = page.getByRole('columnheader', { name: 'Name' });
    this.nextButton = page.getByRole('link', { name: 'Next' });
    this.previousButton = page.getByRole('link', { name: 'Previous' });
    this.paginationInfo = page.locator('#categories-data_info');
  }

  async goto() {
    await this.page.goto('https://dev.indooroutdoor.com/admin/categories');
  }

  async searchCategory(name: string) {
    await this.searchInput.fill(name);
    await this.searchInput.press('Enter');
    await this.page.waitForLoadState('networkidle');
  }

  async sortByColumn(columnName: string, direction: 'ascending' | 'descending') {
    const column = this.page.getByRole('columnheader', { name: columnName });
    let currentSort = await column.getAttribute('aria-sort');

    if (currentSort === direction) {
      return;
    }

    let attempts = 0;
    while (currentSort !== direction && attempts < 3) {
      await column.click();
      await this.page.waitForLoadState('networkidle');
      currentSort = await column.getAttribute('aria-sort');
      attempts++;
    }
  }

  async sortByName() {
    await this.sortByColumn('Name', 'ascending');
  }

  getCategoryRow(name: string): Locator {
    return this.categoriesTable.locator('tbody tr').filter({ 
      has: this.page.locator('td').filter({ hasText: new RegExp(`^${name}$`) })
    });
  }

  async getAriaSortOfNameColumn(): Promise<string | null> {
    return await this.nameColumnHeader.getAttribute('aria-sort');
  }

  async getRowCount(): Promise<number> {
    return await this.categoriesTable.locator('tbody tr').count();
  }

  async clickNext() {
    await this.nextButton.click();
    await this.page.waitForLoadState('networkidle');
  }

  async clickPrevious() {
    await this.previousButton.click();
    await this.page.waitForLoadState('networkidle');
  }
}
