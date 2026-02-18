import { Page, Locator } from '@playwright/test';
import * as path from 'path';

export class LogoFormPage {
  readonly page: Page;
  readonly header: Locator;
  readonly slugInput: Locator;
  readonly priorityInput: Locator;
  readonly activeSwitch: Locator;
  readonly fileInput: Locator;
  readonly submitButton: Locator;
  readonly backButton: Locator;

  constructor(page: Page) {
    this.page = page;
    this.header = page.locator('h5');
    this.slugInput = page.locator('input[name="slug"]');
    this.priorityInput = page.locator('input[name="priority"]');
    this.activeSwitch = page.locator('input[name="is_active"]');
    this.fileInput = page.locator('input[type="file"]');
    this.submitButton = page.locator('button[type="submit"]');
    this.backButton = page.locator('a.btn-primary:has-text("Back")');
  }

  async fillForm(data: { slug: string; priority: string; active: boolean; filePath: string }) {
    await this.slugInput.fill(data.slug);
    await this.priorityInput.fill(data.priority);
    
    const currentState = await this.activeSwitch.isChecked();
    if (currentState !== data.active) {
      await this.activeSwitch.click({ force: true });
    }
    
    await this.fileInput.setInputFiles(data.filePath);
  }

  async submit() {
    await this.submitButton.click();
  }
}
