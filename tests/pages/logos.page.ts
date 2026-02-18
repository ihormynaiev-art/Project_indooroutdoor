import { Page, Locator } from '@playwright/test';

export class LogosPage {
  readonly page: Page;
  readonly header: Locator;
  readonly table: Locator;
  readonly tableRows: Locator;
  readonly slugHeader: Locator;
  readonly priorityHeader: Locator;
  readonly activeHeader: Locator;
  readonly imageHeader: Locator;
  readonly actionHeader: Locator;
  readonly paginationContainer: Locator;

  constructor(page: Page) {
    this.page = page;
    this.header = page.locator('.content-page-header h5');
    this.table = page.locator('#logos-data');
    this.tableRows = page.locator('#logos-data tbody tr');
    this.slugHeader = page.locator('th[aria-label*="Slug"]');
    this.priorityHeader = page.locator('th[aria-label*="Priority"]');
    this.activeHeader = page.locator('th[aria-label*="Active"]');
    this.imageHeader = page.locator('th[aria-label="Image"]');
    this.actionHeader = page.locator('th[aria-label="Action"]');
    this.paginationContainer = page.locator('#logos-data_paginate');
    this.createButton = page.locator('a.btn-primary[href*="create"]');
  }

  readonly createButton: Locator;

  async goto() {
    await this.page.goto('https://dev.indooroutdoor.com/admin/logos');
  }

  async clickCreate() {
    await this.createButton.click();
  }

  async sortBySlug() {
    await this.slugHeader.click();
  }

  async sortByPriority() {
    await this.priorityHeader.click();
  }

  async sortByActive() {
    await this.activeHeader.click();
  }

  async clickPage(pageNumber: number) {
    await this.paginationContainer.getByRole('link', { name: pageNumber.toString(), exact: true }).click();
  }

  getLogoRow(slug: string): Locator {
    return this.tableRows.filter({ hasText: slug });
  }

  async clickShow(slug: string) {
    await this.getLogoRow(slug).locator('a.table-show').click();
  }

  async clickEdit(slug: string) {
    await this.getLogoRow(slug).locator('a.table-edit').click();
  }

  async clickDelete(slug: string) {
    await this.getLogoRow(slug).locator('a.table-delete').click();
  }

  /**
   * Fetches data from a specific column across all visible rows.
   * @param columnIndex 0-based index of the column
   */
  async getColumnValues(columnIndex: number): Promise<string[]> {
    // Wait for table to be attached and have at least one row if possible
    await this.table.waitFor({ state: 'visible' });
    
    // Extract values from cells in the specified column
    return await this.tableRows.evaluateAll((rows, index) => {
      return rows.map(row => {
        const cell = row.cells[index];
        return cell ? cell.innerText.trim() : '';
      });
    }, columnIndex);
  }
}
