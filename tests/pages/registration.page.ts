import { Page, Locator, expect } from '@playwright/test';

export class RegistrationPage {
  readonly page: Page;
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
    this.page = page;
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

  /**
   * Навигация на страницу регистрации подрядчика
   */
  async navigate() {
    await this.page.setViewportSize({ width: 1920, height: 1080 });
    await this.page.goto('https://dev.indooroutdoor.com/');
    await this.signUpLink.first().click();
    await expect(this.heading).toBeVisible({ timeout: 10000 });
  }

  /**
   * Получение стиля элемента
   */
  async getStyle(locator: Locator, property: string): Promise<string> {
    return await locator.evaluate((el, prop) => {
      return window.getComputedStyle(el).getPropertyValue(prop);
    }, property);
  }

  /**
   * Получение всех стилей элемента
   */
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

  /**
   * Проверка валидности поля через HTML5 валидацию
   */
  async isFieldValid(locator: Locator): Promise<boolean> {
    return await locator.evaluate((node: HTMLInputElement) => node.checkValidity());
  }

  /**
   * Получение сообщения об ошибке валидации
   */
  async getValidationMessage(locator: Locator): Promise<string> {
    return await locator.evaluate((node: HTMLInputElement) => node.validationMessage);
  }

  /**
   * Переключение видимости пароля
   */
  async togglePasswordVisibility() {
    if (await this.passwordToggle.isVisible({ timeout: 2000 }).catch(() => false)) {
      await this.passwordToggle.click();
    }
  }

  /**
   * Переключение видимости подтверждения пароля
   */
  async toggleConfirmPasswordVisibility() {
    if (await this.confirmPasswordToggle.isVisible({ timeout: 2000 }).catch(() => false)) {
      await this.confirmPasswordToggle.click();
    }
  }

  /**
   * Проверка типа поля пароля
   */
  async getPasswordInputType(): Promise<string> {
    return await this.passwordInput.getAttribute('type') || 'password';
  }

  /**
   * Проверка типа поля подтверждения пароля
   */
  async getConfirmPasswordInputType(): Promise<string> {
    return await this.confirmPasswordInput.getAttribute('type') || 'password';
  }

  /**
   * Очистка всех полей формы
   */
  async clearForm() {
    await this.businessNameInput.clear();
    await this.fullNameInput.clear();
    await this.emailInput.clear();
    await this.passwordInput.clear();
    await this.confirmPasswordInput.clear();
  }

  /**
   * Заполнение формы регистрации
   */
  async fillForm(data: {
    businessName?: string;
    fullName?: string;
    email?: string;
    password?: string;
    confirmPassword?: string;
  }) {
    if (data.businessName) {
      await this.businessNameInput.fill(data.businessName);
    }
    if (data.fullName) {
      await this.fullNameInput.fill(data.fullName);
    }
    if (data.email) {
      await this.emailInput.fill(data.email);
    }
    if (data.password) {
      await this.passwordInput.fill(data.password);
    }
    if (data.confirmPassword) {
      await this.confirmPasswordInput.fill(data.confirmPassword);
    }
  }

  /**
   * Проверка наличия сообщения об ошибке
   */
  async hasErrorMessage(text?: string): Promise<boolean> {
    if (text) {
      const errorLocator = this.page.locator(`text=/${text}/i`).first();
      return await errorLocator.isVisible({ timeout: 2000 }).catch(() => false);
    }
    const errorLocator = this.page.locator('text=/required|обязательно|заполните|cannot be empty|field is required/i').first();
    return await errorLocator.isVisible({ timeout: 2000 }).catch(() => false);
  }

  /**
   * Получение текста label поля
   */
  async getLabelText(fieldName: string): Promise<string | null> {
    const label = this.page.getByText(fieldName, { exact: false }).first();
    return await label.textContent();
  }

  /**
   * Проверка наличия маркера обязательности (*)
   */
  async hasRequiredMarker(fieldName: string): Promise<boolean> {
    const labelText = await this.getLabelText(fieldName);
    return labelText?.includes('*') || false;
  }
}






