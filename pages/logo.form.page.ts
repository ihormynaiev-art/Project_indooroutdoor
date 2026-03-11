import { Page, Locator } from '@playwright/test';
import { BasePage } from 'pages/base.page';

export class LogoFormPage extends BasePage {
    readonly header: Locator;
    readonly slugInput: Locator;
    readonly priorityInput: Locator;
    readonly activeSwitch: Locator;
    readonly fileInput: Locator;
    readonly submitButton: Locator;
    readonly backButton: Locator;

    constructor(page: Page) {
        super(page);
        this.header = page.locator('h5');
        this.slugInput = page.locator('input[name="slug"]');
        this.priorityInput = page.locator('input[name="priority"]');
        this.activeSwitch = page.locator('input[name="is_active"]');
        this.fileInput = page.locator('input[type="file"]');
        this.submitButton = page.locator('button[type="submit"]');
        this.backButton = page.locator('a.btn-primary:has-text("Back")');
    }

    async fillForm(logoFormData: { slug: string; priority: string; active: boolean; filePath: string }) {
        await this.slugInput.fill(logoFormData.slug);
        await this.priorityInput.fill(logoFormData.priority);

        const currentState = await this.activeSwitch.isChecked();
        if (currentState !== logoFormData.active) {
            await this.activeSwitch.click({ force: true });
        }

        await this.fileInput.setInputFiles(logoFormData.filePath);
    }

    async submit() {
        await this.submitButton.click();
    }
}
