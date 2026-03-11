import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from 'pages/base.page';

export class LoginPage extends BasePage {
    readonly emailInput: Locator;
    readonly passwordInput: Locator;
    readonly loginButton: Locator;
    readonly loginLink: Locator;
    readonly forgotPasswordLink: Locator;
    readonly rememberMeCheckbox: Locator;
    readonly passwordToggle: Locator;

    constructor(page: Page) {
        super(page);
        this.loginLink = page.getByRole('link', { name: 'Log In ImageLogin' });
        this.emailInput = page.getByRole('textbox', { name: 'johndeo@example.com' }).filter({ visible: true });
        this.passwordInput = page.locator('input[type="password"]:visible');
        this.loginButton = page.getByRole('button', { name: 'Login' });
        this.forgotPasswordLink = page.locator('a').filter({ hasText: /forgot.*password|password.*forgot/i }).first();
        this.rememberMeCheckbox = page.locator('input[type="checkbox"]').first();
        this.passwordToggle = page.locator('button[aria-label*="password" i], button[aria-label*="show" i], button[aria-label*="hide" i], i.fa-eye, i.fa-eye-slash, svg[class*="eye" i]').first();
    }

    async goto() {
        await this.page.setViewportSize({ width: 1920, height: 1080 });
        await this.page.goto('/', { waitUntil: 'domcontentloaded' });
        await expect(this.loginLink).toBeVisible({ timeout: 10000 });
        await this.loginLink.click();
        await expect(this.emailInput).toBeVisible({ timeout: 10000 });
    }

    async login(email: string, password: string) {
        await this.emailInput.fill(email);
        await this.passwordInput.fill(password);
        await this.loginButton.click();
    }

    async getRateLimitWaitTime(): Promise<number | null> {
        const bodyText = await this.page.locator('body').textContent().catch(() => '');
        const tooManyAttemptsPatterns = [
            /too many login attempts.*?(\d+)\s*seconds?/i,
            /too many.*?attempts.*?(\d+)\s*seconds?/i,
            /try again in (\d+)\s*seconds?/i,
            /(\d+)\s*seconds?.*?try again/i
        ];

        for (const pattern of tooManyAttemptsPatterns) {
            const match = bodyText?.match(pattern);
            if (match) {
                return parseInt(match[1], 10);
            }
        }
        return null;
    }

    async handleRateLimit(): Promise<boolean> {
        const waitSeconds = await this.getRateLimitWaitTime();
        if (waitSeconds) {
            console.warn(`Rate limit detected. Waiting ${waitSeconds} seconds...`);
            await this.page.waitForTimeout((waitSeconds + 5) * 1000);
            await this.page.reload();
            await expect(this.loginLink).toBeVisible({ timeout: 10000 });
            await this.loginLink.click();
            await expect(this.emailInput).toBeVisible({ timeout: 10000 });
            return true;
        }
        return false;
    }

    async isEmailValid(email: string): Promise<boolean> {
        await this.emailInput.fill(email);
        return await this.emailInput.evaluate((node: HTMLInputElement) => node.checkValidity());
    }

    async isPasswordValid(): Promise<boolean> {
        return await this.passwordInput.evaluate((node: HTMLInputElement) => node.checkValidity());
    }

    async getEmailValidationMessage(): Promise<string> {
        return await this.emailInput.evaluate((node: HTMLInputElement) => node.validationMessage);
    }

    async getPasswordValidationMessage(): Promise<string> {
        return await this.passwordInput.evaluate((node: HTMLInputElement) => node.validationMessage);
    }

    async togglePasswordVisibility() {
        let toggleFound = await this.passwordToggle.isVisible({ timeout: 2000 }).catch(() => false);

        if (!toggleFound) {
            const passwordInputElement = await this.passwordInput.elementHandle();
            if (passwordInputElement) {
                const parent = await passwordInputElement.evaluateHandle((el: HTMLElement) => el?.parentElement);
                if (parent) {
                    const nearbyToggle = this.page.locator('button, span, i, svg').filter({ hasText: /show|hide|eye|password/i }).first();
                    toggleFound = await nearbyToggle.isVisible({ timeout: 1000 }).catch(() => false);
                    if (toggleFound) {
                        await nearbyToggle.click();
                        return;
                    }
                }
            }
        }

        if (toggleFound) {
            await this.passwordToggle.click();
        }
    }

    async getPasswordInputType(): Promise<string> {
        let passwordInput = this.passwordInput;
        const type = await passwordInput.getAttribute('type').catch(() => null);

        if (type === 'text') {
            const name = await passwordInput.getAttribute('name').catch(() => null);
            const id = await passwordInput.getAttribute('id').catch(() => null);

            if (name) {
                passwordInput = this.page.locator(`input[name="${name}"]`).first();
            } else if (id) {
                passwordInput = this.page.locator(`#${id}`).first();
            } else {
                passwordInput = this.page.locator('input[type="password"], input[type="text"]').nth(1);
            }
        }

        return await passwordInput.getAttribute('type') || 'password';
    }

    async clearForm() {
        await this.emailInput.clear();
        await this.passwordInput.clear();
    }

    async isLoggedIn(): Promise<boolean> {
        try {
            await expect(this.loginButton).toBeHidden({ timeout: 5000 });
            return true;
        } catch {
            return false;
        }
    }

    async returnToLoginPage() {
        if (this.page.url() !== '/') {
            await this.page.goBack();
        }
        if (await this.loginLink.isVisible({ timeout: 2000 }).catch(() => false)) {
            await this.loginLink.click();
            await expect(this.emailInput).toBeVisible({ timeout: 10000 });
        }
    }
}
