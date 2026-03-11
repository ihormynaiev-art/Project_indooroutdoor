import { Page, Locator } from '@playwright/test';

export class HeaderComponent {
    readonly page: Page;
    readonly logo: Locator;
    readonly navigationMenu: Locator;
    readonly userProfileButton: Locator;
    readonly logoutButton: Locator;

    constructor(page: Page) {
        this.page = page;
        this.logo = page.locator('[data-testid="header-logo"]');
        this.navigationMenu = page.locator('[data-testid="navigation-menu"]');
        this.userProfileButton = page.locator('[data-testid="user-profile-button"]');
        this.logoutButton = page.locator('[data-testid="logout-button"]');
    }

    async clickLogo(): Promise<void> {
        await this.logo.click();
    }

    async openUserProfileMenu(): Promise<void> {
        await this.userProfileButton.click();
    }

    async logout(): Promise<void> {
        await this.openUserProfileMenu();
        await this.logoutButton.click();
    }
}
