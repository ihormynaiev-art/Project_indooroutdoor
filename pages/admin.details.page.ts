import { Page, Locator } from '@playwright/test';
import { BasePage } from 'pages/base.page';

export class AdminDetailsPage extends BasePage {
    readonly nameInput: Locator;
    readonly emailInput: Locator;
    readonly backButton: Locator;

    constructor(page: Page) {
        super(page);
        this.nameInput = page.locator('input[name="name"]');
        this.emailInput = page.locator('input[name="slug"]');
        this.backButton = page.getByRole('link', { name: 'Back' });
    }
}
