import { Page, Locator } from '@playwright/test';

export class AdminsPage {
  readonly page: Page;
  readonly pageHeader: Locator;
  readonly nameFilter: Locator;
  readonly emailFilter: Locator;
  readonly adminsTable: Locator;
  readonly nameColumn: Locator;
  readonly emailColumn: Locator;

  constructor(page: Page) {
    this.page = page;
    this.pageHeader = page.getByRole('heading', { name: 'All Admins' });
    this.nameFilter = page.locator('#nameFilter');
    this.emailFilter = page.locator('#emailFilter');
    this.adminsTable = page.locator('#admins-data');
    this.nameColumn = page.getByRole('columnheader', { name: 'Name' });
    this.emailColumn = page.getByRole('columnheader', { name: 'Email' });
  }

  async goto() {
    await this.page.goto('https://dev.indooroutdoor.com/admin/admins');
  }

  async searchByName(name: string) {
    await this.nameFilter.fill(name);
    await this.nameFilter.press('Enter');
    await this.page.waitForLoadState('networkidle');
  }

  async searchByEmail(email: string) {
    await this.emailFilter.fill(email);
    await this.emailFilter.press('Enter');
    await this.page.waitForLoadState('networkidle');
  }

  async resetFilters() {
    await this.nameFilter.clear();
    await this.emailFilter.clear();
    await this.page.waitForLoadState('networkidle');
  }

  async sortByColumn(columnName: string, direction: 'ascending' | 'descending') {
    const column = this.page.getByRole('columnheader', { name: columnName });
    let currentSort = await column.getAttribute('aria-sort');

    if (currentSort === direction) {
      return;
    }

    // DataTables cycle through: ascending -> descending -> none (sometimes)
    // We click until the desired direction is reached
    let attempts = 0;
    while (currentSort !== direction && attempts < 3) {
      await column.click();
      await this.page.waitForLoadState('networkidle');
      currentSort = await column.getAttribute('aria-sort');
      attempts++;
    }
  }

  getAdminRow(nameOrEmail: string): Locator {
    return this.page.locator('#admins-data tbody tr').filter({ hasText: nameOrEmail });
  }

  async clickShowForAdmin(name: string) {
    const row = this.getAdminRow(name);
    const showButton = row.getByRole('link', { name: 'Show' });
    
    await Promise.all([
      this.page.waitForURL(/\/admin\/admins\/\d+/),
      showButton.click()
    ]);
    await this.page.waitForLoadState('networkidle');
  }

  async clickDeleteForAdmin(adminName: string) {
    await this.adminsTable
      .locator('tbody tr')
      .filter({ hasText: adminName })
      .getByRole('link', { name: /Delete/i }) // ищем кнопку удаления
      .first() // <--- ДОБАВЬ ЭТО, чтобы выбрать первый из найденных элементов
      .click();
  }
}

export class AdminDetailsPage {
  readonly page: Page;
  readonly nameInput: Locator;
  readonly emailInput: Locator;
  readonly backButton: Locator;

  constructor(page: Page) {
    this.page = page;
    this.nameInput = page.locator('input[name="name"]');
    this.emailInput = page.locator('input[name="slug"]');
    this.backButton = page.getByRole('link', { name: 'Back' });
  }
}
