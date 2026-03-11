import { Page, Locator } from '@playwright/test';
import { BasePage } from 'pages/base.page';

export class LogoShowPage extends BasePage {
    readonly header: Locator;
    readonly slugInput: Locator;
    readonly priorityInput: Locator;
    readonly activeSwitch: Locator;
    readonly image: Locator;
    readonly backButton: Locator;

    constructor(page: Page) {
        super(page);
        this.header = page.locator('h5');
        this.slugInput = page.locator('input[name="slug"]');
        this.priorityInput = page.locator('input[name="priority"]');
        this.activeSwitch = page.locator('input[name="is_active"]');
        this.image = page.locator('.content img');
        this.backButton = page.locator('a.btn-primary:has-text("Back")');
    }

    async isImageLoaded(): Promise<boolean> {
        return await this.image.evaluate((i: HTMLImageElement) => i.complete && i.naturalWidth > 0);
    }

    async toggleActive() {
        await this.activeSwitch.click({ force: true });
    }
}
