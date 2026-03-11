import { Page, Locator } from '@playwright/test';

export class BasePage {
    readonly page: Page;

    constructor(page: Page) {
        this.page = page;
    }

    async navigateTo(url: string): Promise<void> {
        await this.page.goto(url);
    }

    async clickElement(locator: Locator): Promise<void> {
        await locator.click();
    }

    async fillInput(locator: Locator, text: string): Promise<void> {
        await locator.fill(text);
    }

    async waitForElementVisible(locator: Locator): Promise<void> {
        await locator.waitFor({ state: 'visible' });
    }

    async waitForElementHidden(locator: Locator): Promise<void> {
        await locator.waitFor({ state: 'hidden' });
    }

    async getElementText(locator: Locator): Promise<string> {
        return await locator.innerText();
    }

    async waitForPageLoad(): Promise<void> {
        await this.page.waitForLoadState('networkidle');
    }
}
