import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from 'pages/base.page';

export class RegistrationPage extends BasePage {
    readonly businessNameInput: Locator;
    readonly fullNameInput: Locator;
    readonly emailInput: Locator;
    readonly passwordInput: Locator;
    readonly confirmPasswordInput: Locator;
    readonly signupButton: Locator;
    readonly passwordToggle: Locator;
    readonly confirmPasswordToggle: Locator;
    readonly heading: Locator;
    readonly signUpLink: Locator;

    constructor(page: Page) {
        super(page);
        this.signUpLink = page.getByRole('link', { name: 'Sign Up' });
        this.heading = page.getByRole('heading', { name: /Contractor Registration/i });
        this.businessNameInput = page.locator('input[name*="business"], input[placeholder*="business name" i]').first();
        this.fullNameInput = page.getByPlaceholder('Enter your name');
        this.emailInput = page.getByPlaceholder('example@email.com');
        this.passwordInput = page.locator('#password');
        this.confirmPasswordInput = page.locator('#password_confirmation');
        this.signupButton = page.getByRole('button', { name: /Signup|Sign Up/i }).first();
        this.passwordToggle = page.locator('span.toggle-password').first();
        this.confirmPasswordToggle = page.locator('span.toggle-password').nth(1);
    }

    async navigate() {
        await this.page.setViewportSize({ width: 1920, height: 1080 });
        await this.page.goto('/');
        await this.signUpLink.first().click();
        await expect(this.heading).toBeVisible({ timeout: 10000 });
    }

    async getStyle(locator: Locator, property: string): Promise<string> {
        return await locator.evaluate((el, prop) => {
            return window.getComputedStyle(el).getPropertyValue(prop);
        }, property);
    }

    async getStyles(locator: Locator): Promise<{
        fontSize: string;
        fontFamily: string;
        color: string;
        padding: string;
        borderRadius: string;
        borderColor: string;
        outline: string;
        boxShadow: string;
    }> {
        return await locator.evaluate((el) => {
            const styles = window.getComputedStyle(el);
            return {
                fontSize: styles.fontSize,
                fontFamily: styles.fontFamily,
                color: styles.color,
                padding: styles.padding,
                borderRadius: styles.borderRadius,
                borderColor: styles.borderColor,
                outline: styles.outline,
                boxShadow: styles.boxShadow
            };
        });
    }

    async isFieldValid(locator: Locator): Promise<boolean> {
        return await locator.evaluate((node: HTMLInputElement) => node.checkValidity());
    }

    async getValidationMessage(locator: Locator): Promise<string> {
        return await locator.evaluate((node: HTMLInputElement) => node.validationMessage);
    }

    async togglePasswordVisibility() {
        if (await this.passwordToggle.isVisible({ timeout: 2000 }).catch(() => false)) {
            await this.passwordToggle.click();
        }
    }

    async toggleConfirmPasswordVisibility() {
        if (await this.confirmPasswordToggle.isVisible({ timeout: 2000 }).catch(() => false)) {
            await this.confirmPasswordToggle.click();
        }
    }

    async getPasswordInputType(): Promise<string> {
        return await this.passwordInput.getAttribute('type') || 'password';
    }

    async getConfirmPasswordInputType(): Promise<string> {
        return await this.confirmPasswordInput.getAttribute('type') || 'password';
    }

    async clearForm() {
        await this.businessNameInput.clear();
        await this.fullNameInput.clear();
        await this.emailInput.clear();
        await this.passwordInput.clear();
        await this.confirmPasswordInput.clear();
    }

    async fillForm(formData: {
        businessName?: string;
        fullName?: string;
        email?: string;
        password?: string;
        confirmPassword?: string;
    }) {
        if (formData.businessName) {
            await this.businessNameInput.fill(formData.businessName);
        }
        if (formData.fullName) {
            await this.fullNameInput.fill(formData.fullName);
        }
        if (formData.email) {
            await this.emailInput.fill(formData.email);
        }
        if (formData.password) {
            await this.passwordInput.fill(formData.password);
        }
        if (formData.confirmPassword) {
            await this.confirmPasswordInput.fill(formData.confirmPassword);
        }
    }

    async hasErrorMessage(text?: string): Promise<boolean> {
        if (text) {
            const errorLocator = this.page.locator(`text=/${text}/i`).first();
            return await errorLocator.isVisible({ timeout: 2000 }).catch(() => false);
        }
        const errorLocator = this.page.locator('text=/required|cannot be empty|field is required/i').first();
        return await errorLocator.isVisible({ timeout: 2000 }).catch(() => false);
    }

    async getLabelText(fieldName: string): Promise<string | null> {
        const label = this.page.getByText(fieldName, { exact: false }).first();
        return await label.textContent();
    }

    async hasRequiredMarker(fieldName: string): Promise<boolean> {
        const labelText = await this.getLabelText(fieldName);
        return labelText?.includes('*') || false;
    }
}
