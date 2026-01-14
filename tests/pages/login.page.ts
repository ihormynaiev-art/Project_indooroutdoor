import { Page, Locator, expect } from '@playwright/test';

export class LoginPage {
  readonly page: Page;
  readonly emailInput: Locator;
  readonly passwordInput: Locator;
  readonly loginButton: Locator;
  readonly loginLink: Locator;
  readonly forgotPasswordLink: Locator;
  readonly rememberMeCheckbox: Locator;
  readonly passwordToggle: Locator;

  constructor(page: Page) {
    this.page = page;
    this.loginLink = page.getByRole('link', { name: 'Log In ImageLogin' });
    this.emailInput = page.getByRole('textbox', { name: 'johndeo@example.com' }).filter({ visible: true });
    this.passwordInput = page.locator('input[type="password"]:visible');
    this.loginButton = page.getByRole('button', { name: 'Login' });
    // Более гибкий поиск ссылки Forgot Password
    this.forgotPasswordLink = page.locator('a').filter({ hasText: /forgot.*password|password.*forgot/i }).first();
    // Более гибкий поиск чекбокса Remember Me
    this.rememberMeCheckbox = page.locator('input[type="checkbox"]').first();
    // Более гибкий поиск toggle пароля - ищем рядом с полем пароля
    this.passwordToggle = page.locator('button[aria-label*="password" i], button[aria-label*="show" i], button[aria-label*="hide" i], i.fa-eye, i.fa-eye-slash, svg[class*="eye" i]').first();
  }

  /**
   * Переход на страницу и открытие формы логина
   */
  async goto() {
    await this.page.setViewportSize({ width: 1920, height: 1080 });
    await this.page.goto('https://dev.indooroutdoor.com/', { waitUntil: 'domcontentloaded' });
    await expect(this.loginLink).toBeVisible({ timeout: 10000 });
    await this.loginLink.click();
    await expect(this.emailInput).toBeVisible({ timeout: 10000 });
  }

  /**
   * Выполнение логина с указанными данными
   */
  async login(email: string, password: string) {
    await this.emailInput.fill(email);
    await this.passwordInput.fill(password);
    await this.loginButton.click();
  }

  /**
   * Проверка ограничения попыток входа и получение времени ожидания
   */
  async getRateLimitWaitTime(): Promise<number | null> {
    const bodyText = await this.page.locator('body').textContent().catch(() => '');
    // Паттерны для поиска сообщения об ограничении
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

  /**
   * Обработка ограничения попыток входа
   */
  async handleRateLimit(): Promise<boolean> {
    const waitSeconds = await this.getRateLimitWaitTime();
    if (waitSeconds) {
      console.warn(`⚠️ Обнаружено ограничение попыток входа. Ожидание ${waitSeconds} секунд...`);
      // Используем waitForTimeout только здесь, так как это реальное ожидание сброса лимита
      await this.page.waitForTimeout((waitSeconds + 5) * 1000); // +5 секунд запас
      await this.page.reload();
      await expect(this.loginLink).toBeVisible({ timeout: 10000 });
      await this.loginLink.click();
      await expect(this.emailInput).toBeVisible({ timeout: 10000 });
      return true;
    }
    return false;
  }

  /**
   * Проверка валидности email через HTML5 валидацию
   */
  async isEmailValid(email: string): Promise<boolean> {
    await this.emailInput.fill(email);
    return await this.emailInput.evaluate((node: HTMLInputElement) => node.checkValidity());
  }

  /**
   * Проверка валидности пароля через HTML5 валидацию
   */
  async isPasswordValid(): Promise<boolean> {
    return await this.passwordInput.evaluate((node: HTMLInputElement) => node.checkValidity());
  }

  /**
   * Получение сообщения об ошибке валидации для email
   */
  async getEmailValidationMessage(): Promise<string> {
    return await this.emailInput.evaluate((node: HTMLInputElement) => node.validationMessage);
  }

  /**
   * Получение сообщения об ошибке валидации для пароля
   */
  async getPasswordValidationMessage(): Promise<string> {
    return await this.passwordInput.evaluate((node: HTMLInputElement) => node.validationMessage);
  }

  /**
   * Переключение видимости пароля (show/hide)
   * Ищет toggle элемент рядом с полем пароля, если основной локатор не найден
   */
  async togglePasswordVisibility() {
    let toggleFound = await this.passwordToggle.isVisible({ timeout: 2000 }).catch(() => false);
    
    if (!toggleFound) {
      // Пробуем найти toggle рядом с полем пароля
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

  /**
   * Проверка типа поля пароля (password или text)
   * Работает даже если тип изменился после toggle
   */
  async getPasswordInputType(): Promise<string> {
    // Сначала пробуем найти по type="password"
    let passwordInput = this.passwordInput;
    const type = await passwordInput.getAttribute('type').catch(() => null);
    
    // Если тип изменился на text, ищем по name или id
    if (type === 'text') {
      const name = await passwordInput.getAttribute('name').catch(() => null);
      const id = await passwordInput.getAttribute('id').catch(() => null);
      
      if (name) {
        passwordInput = this.page.locator(`input[name="${name}"]`).first();
      } else if (id) {
        passwordInput = this.page.locator(`#${id}`).first();
      } else {
        // Используем позицию в форме (обычно второе поле после email)
        passwordInput = this.page.locator('input[type="password"], input[type="text"]').nth(1);
      }
    }
    
    return await passwordInput.getAttribute('type') || 'password';
  }

  /**
   * Очистка всех полей формы
   */
  async clearForm() {
    await this.emailInput.clear();
    await this.passwordInput.clear();
  }

  /**
   * Проверка, что пользователь успешно залогинился (кнопка Login скрыта)
   */
  async isLoggedIn(): Promise<boolean> {
    try {
      await expect(this.loginButton).toBeHidden({ timeout: 5000 });
      return true;
    } catch {
      return false;
    }
  }

  /**
   * Возврат на страницу логина (если произошел переход)
   */
  async returnToLoginPage() {
    if (this.page.url() !== 'https://dev.indooroutdoor.com/') {
      await this.page.goBack();
    }
    if (await this.loginLink.isVisible({ timeout: 2000 }).catch(() => false)) {
      await this.loginLink.click();
      await expect(this.emailInput).toBeVisible({ timeout: 10000 });
    }
  }
}

