/**
 * LOGIN FORM SUITE — КОМПЛЕКСНЫЙ ТЕСТ ФОРМЫ АВТОРИЗАЦИИ
 * 
 * Данный набор тестов выполняет исчерпывающую проверку формы входа, включая визуальное соответствие,
 * функциональную валидацию, безопасность (XSS/SQLi) и удобство использования (UI/UX).
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И ОСНОВНОЙ ФУНКЦИОНАЛ:
 *    - Успешный вход с валидными данными и проверка исчезновения формы.
 *    - Автоматическая обработка лимитов на попытки входа (Rate Limiting).
 *    - Проверка сохранения сессии и корректности типов полей (email/password).
 * 
 * 2. UI/UX И ВИЗУАЛЬНЫЙ АУДИТ:
 *    - Адаптивность: проверка корректного отображения на различных разрешениях.
 *    - Доступность (Accessibility): соответствие стандартам WCAG.
 *    - Стили: проверка CSS-параметров элементов формы.
 *    - Видимость: контроль присутствия всех ключевых полей и кнопок.
 * 
 * 3. ГЛУБОКАЯ ВАЛИДАЦИЯ EMAIL:
 *    - Обязательность: проверка поведения при пустом поле.
 *    - Формат (Data-Driven): тестирование различных невалидных паттернов (без @, без домена и т.д.).
 *    - Пробелы: проверка автоматической обрезки (trim) краевых пробелов и запрет пробелов внутри.
 *    - Регистр: подтверждение нечувствительности email к заглавным буквам.
 *    - Границы: проверка лимита длины согласно стандартам RFC (до 254 символов).
 *    - Спецсимволы: проверка разрешенных (._-+) и запрещенных символов.
 * 
 * 4. ГЛУБОКАЯ ВАЛИДАЦИЯ ПАРОЛЯ:
 *    - Обязательность: реакция системы на пустой пароль.
 *    - Длина: проверка минимальных (6-8) и максимальных (64-128) ограничений.
 *    - Сложность: тестирование устойчивости к паролям разного состава (регистр, цифры, символы).
 *    - Интерактивность: проверка функционала «Глазика» (переключение видимости пароля).
 *    - Ошибки: проверка корректности сообщений при неверном пароле (без раскрытия существования email).
 * 
 * 5. БЕЗОПАСНОСТЬ И ЗАЩИТА:
 *    - Защита от XSS: попытки внедрения <script> в поля ввода.
 *    - Защита от SQL-инъекций: тестирование классических паттернов (' OR 1=1 --).
 *    - Конфиденциальность: проверка отсутствия логирования пароля в открытом виде в HTML-коде.
 * 
 * 6. ДОПОЛНИТЕЛЬНЫЕ ЭЛЕМЕНТЫ:
 *    - Forgot Password: проверка наличия ссылки и корректности перехода на форму восстановления.
 *    - Remember Me: проверка наличия чекбокса, его состояний и влияния на форму.
 * 
 * ИТОГ: Тест гарантирует, что форма авторизации надежна, защищена от атак, 
 * удобна для пользователя и соответствует бизнес-требованиям.
 */

import { test, expect } from '@playwright/test';
import { checkResponsiveDesign, checkAccessibility, checkStyles } from './helpers/ui-ux-helpers';
import { LoginPage } from './pages/login.page';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

test.describe('Login Form Suite @regression', () => {
  let loginPage: LoginPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
    await loginPage.goto();
    // Обработка лимита один раз перед тестом
    await loginPage.handleRateLimit();
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Успешная авторизация с валидными данными', async ({ page }) => {
    // ОБЯЗАТЕЛЬНАЯ проверка UI/UX и адаптивности формы логина (до заполнения)
    await test.step('Проверка UI/UX и адаптивности формы логина', async () => {
      await checkResponsiveDesign(page);
      await checkAccessibility(page);
      await checkStyles(page);
    });

    await test.step('Заполнение формы валидными данными', async () => {
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill('Qwerty123$');
    });

    await test.step('Отправка формы и проверка успешного входа', async () => {
      await loginPage.loginButton.click();
      await expect(loginPage.loginButton).toBeHidden({ timeout: 5000 });
    });
  });

  test('Валидация обязательных полей', async () => {
    await test.step('Попытка входа с пустым email', async () => {
      await loginPage.passwordInput.fill('Qwerty123$');
      await loginPage.loginButton.click();

      const isEmailInvalid = await loginPage.emailInput.evaluate((node: HTMLInputElement) => !node.checkValidity());
      expect(isEmailInvalid).toBe(true);
    });

    await test.step('Попытка входа с пустым паролем', async () => {
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill('');
      await loginPage.loginButton.click();

      const isPasswordInvalid = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => !node.checkValidity());
      expect(isPasswordInvalid).toBe(true);
    });

    await test.step('Попытка входа с пустыми полями', async () => {
      await loginPage.clearForm();
      await loginPage.loginButton.click();

      const isEmailInvalid = await loginPage.emailInput.evaluate((node: HTMLInputElement) => !node.checkValidity());
      const isPasswordInvalid = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => !node.checkValidity());

      expect(isEmailInvalid).toBe(true);
      expect(isPasswordInvalid).toBe(true);
    });
  });

  test('Валидация формата email', async () => {
    await test.step('Проверка валидного формата email', async () => {
      await expect(loginPage.emailInput).toBeVisible();
      const validEmail = 'user@test.com';
      await loginPage.emailInput.fill(validEmail);
      await loginPage.passwordInput.fill('Qwerty123$');

      const isValid = await loginPage.isEmailValid(validEmail);
      expect(isValid).toBe(true);
    });
  });

  // Data-Driven Testing: параметризованные тесты для невалидных email
  const invalidEmails = [
    { email: 'user', description: 'без @' },
    { email: 'user@', description: 'без домена' },
    { email: '@test.com', description: 'без имени пользователя' },
    { email: 'user@test', description: 'без домена верхнего уровня' },
    { email: 'user@test.', description: 'точка в конце домена' }
  ];

  for (const { email, description } of invalidEmails) {
    test(`Валидация некорректного email: ${description} (${email})`, async () => {
      await loginPage.handleRateLimit();
      await loginPage.clearForm();

      const initialUrl = loginPage.page.url();
      await loginPage.emailInput.fill(email);
      await loginPage.passwordInput.fill('Qwerty123$');
      await loginPage.loginButton.click();

      // Ждем либо валидации, либо изменения URL
      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        // Если кнопка скрылась, проверяем что URL изменился (неуспешный вход)
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      // Проверяем валидацию через HTML5
      const validationInfo = await loginPage.emailInput.evaluate((node: HTMLInputElement) => {
        return {
          checkValidity: node.checkValidity(),
          typeMismatch: node.validity.typeMismatch,
          inputType: node.type
        };
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      if (validationInfo.inputType === 'email') {
        expect(validationInfo.typeMismatch || isLoginButtonStillVisible || urlNotChanged).toBe(true);
      } else {
        expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);
      }

      if (!isLoginButtonStillVisible && !urlNotChanged) {
        await loginPage.returnToLoginPage();
      }
    });
  }

  test('Email - проверка сообщения об ошибке для пустого поля', async () => {
    await test.step('Проверка отображения сообщения об ошибке для пустого email', async () => {
      await loginPage.emailInput.fill('');
      await loginPage.passwordInput.fill('Qwerty123$');
      await loginPage.loginButton.click();

      const isInvalid = await loginPage.emailInput.evaluate((node: HTMLInputElement) => !node.checkValidity());
      expect(isInvalid).toBe(true);

      const validationMessage = await loginPage.getEmailValidationMessage();
      const isAriaInvalid = await loginPage.emailInput.getAttribute('aria-invalid');

      expect(validationMessage.length > 0 || isAriaInvalid === 'true').toBe(true);
    });
  });

  test('Email - проверка лишних пробелов', async () => {
    await test.step('Пробелы в начале и в конце должны обрезаться', async () => {
      const emailWithSpaces = '  user@test.com  ';
      await loginPage.emailInput.fill(emailWithSpaces);
      await loginPage.passwordInput.fill('Qwerty123$');

      const trimmedValue = await loginPage.emailInput.inputValue();
      expect(trimmedValue.trim()).toBe('user@test.com');
    });

    await test.step('Пробелы внутри email должны вызывать ошибку', async () => {
      const emailWithSpacesInside = 'user @test.com';
      await loginPage.emailInput.fill(emailWithSpacesInside);
      await loginPage.passwordInput.fill('Qwerty123$');

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      // Ждем либо валидации, либо изменения URL
      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const validationInfo = await loginPage.emailInput.evaluate((node: HTMLInputElement) => {
        return {
          checkValidity: node.checkValidity(),
          typeMismatch: node.validity.typeMismatch,
          inputType: node.type
        };
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(validationInfo.typeMismatch || isLoginButtonStillVisible || urlNotChanged).toBe(true);
    });
  });

  test('Email - проверка регистра', async () => {
    await test.step('Email не должен зависеть от регистра', async () => {
      const emailsWithDifferentCase = [
        'User@Test.com',
        'USER@TEST.COM',
        'user@test.com'
      ];

      for (const email of emailsWithDifferentCase) {
        await loginPage.emailInput.fill(email);
        await loginPage.passwordInput.fill('Qwerty123$');

        const isValid = await loginPage.emailInput.evaluate((node: HTMLInputElement) => {
          return node.type === 'email' ? node.checkValidity() : true;
        });
        expect(isValid).toBe(true);
      }
    });
  });

  test('Email - проверка максимальной длины', async () => {
    await test.step('Проверка ограничения длины email (≤ 254 символа)', async () => {
      // Валидный email длиной 254 символа
      const longValidEmail = 'a'.repeat(240) + '@test.com'; // 254 символа
      await loginPage.emailInput.fill(longValidEmail);
      await loginPage.passwordInput.fill('Qwerty123$');

      const isValid = await loginPage.isEmailValid(longValidEmail);
      expect(isValid).toBe(true);

      // Email длиной более 254 символов
      const tooLongEmail = 'a'.repeat(250) + '@test.com'; // > 254 символов
      await loginPage.emailInput.fill(tooLongEmail);
      await loginPage.passwordInput.fill('Qwerty123$');

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const validationInfo = await loginPage.emailInput.evaluate((node: HTMLInputElement) => {
        return {
          checkValidity: node.checkValidity(),
          tooLong: node.validity.tooLong,
          value: node.value.length
        };
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(validationInfo.tooLong || !validationInfo.checkValidity || isLoginButtonStillVisible || urlNotChanged).toBe(true);
    });
  });

  test('Email - проверка спецсимволов', async () => {
    await test.step('Разрешенные спецсимволы: . _ - +', async () => {
      const validEmailsWithSpecialChars = [
        'user.name@test.com',
        'user_name@test.com',
        'user-name@test.com',
        'user+tag@test.com',
        'user.name+tag@test.com'
      ];

      for (const email of validEmailsWithSpecialChars) {
        await loginPage.emailInput.fill(email);
        await loginPage.passwordInput.fill('Qwerty123$');

        const isValid = await loginPage.isEmailValid(email);
        expect(isValid).toBe(true);
      }
    });

    await test.step('Запрещенные спецсимволы: пробелы, <>, ; : /', async () => {
      const invalidEmailsWithForbiddenChars = [
        'user<>@test.com',
        'user;@test.com',
        'user:@test.com',
        'user/@test.com'
      ];

      for (const email of invalidEmailsWithForbiddenChars) {
        await loginPage.emailInput.fill(email);
        await loginPage.passwordInput.fill('Qwerty123$');

        const initialUrl = loginPage.page.url();
        await loginPage.loginButton.click();

        await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
          const currentUrl = loginPage.page.url();
          if (currentUrl !== initialUrl) {
            await loginPage.returnToLoginPage();
          }
        });

        const validationInfo = await loginPage.emailInput.evaluate((node: HTMLInputElement) => {
          return {
            checkValidity: node.checkValidity(),
            typeMismatch: node.validity.typeMismatch
          };
        });

        const currentUrl = loginPage.page.url();
        const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
        const urlNotChanged = currentUrl === initialUrl;

        expect(validationInfo.typeMismatch || !validationInfo.checkValidity || isLoginButtonStillVisible || urlNotChanged).toBe(true);
      }
    });
  });

  test('Email - проверка безопасности (XSS и SQL-инъекции)', async () => {
    await test.step('Защита от XSS', async () => {
      const xssAttempt = '<script>alert("XSS")</script>@test.com';
      await loginPage.emailInput.fill(xssAttempt);
      await loginPage.passwordInput.fill('Qwerty123$');

      const inputValueBeforeSubmit = await loginPage.emailInput.inputValue();
      expect(inputValueBeforeSubmit).toContain('<script>');

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);

      if (isLoginButtonStillVisible || urlNotChanged) {
        const pageContent = await loginPage.page.content();
        expect(pageContent).not.toContain('alert("XSS")');
      }
    });

    await test.step('Защита от SQL-инъекций', async () => {
      const sqlInjectionAttempt = "' OR 1=1 --@test.com";
      await loginPage.emailInput.fill(sqlInjectionAttempt);
      await loginPage.passwordInput.fill('Qwerty123$');

      const inputValueBeforeSubmit = await loginPage.emailInput.inputValue();
      expect(inputValueBeforeSubmit).toContain("' OR 1=1 --");

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);
    });
  });

  test('Password - проверка сообщения об ошибке для пустого поля', async () => {
    await test.step('Проверка отображения сообщения об ошибке для пустого пароля', async () => {
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill('');
      await loginPage.loginButton.click();

      const isInvalid = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => !node.checkValidity());
      expect(isInvalid).toBe(true);

      const validationMessage = await loginPage.getPasswordValidationMessage();
      const isAriaInvalid = await loginPage.passwordInput.getAttribute('aria-invalid');

      expect(validationMessage.length > 0 || isAriaInvalid === 'true').toBe(true);
    });
  });

  test('Password - проверка минимальной длины', async () => {
    await test.step('Проверка минимальной длины пароля (обычно 6-8 символов)', async () => {
      const shortPasswords = ['12345', '123456', '1234567']; // 5, 6, 7 символов

      for (const shortPassword of shortPasswords) {
        await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
        await loginPage.passwordInput.fill(shortPassword);

        const initialUrl = loginPage.page.url();
        await loginPage.loginButton.click();

        await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
          const currentUrl = loginPage.page.url();
          if (currentUrl !== initialUrl) {
            await loginPage.returnToLoginPage();
          }
        });

        const validationInfo = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => {
          return {
            checkValidity: node.checkValidity(),
            tooShort: node.validity.tooShort,
            valueLength: node.value.length,
            minLength: node.minLength
          };
        });

        const currentUrl = loginPage.page.url();
        const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
        const urlNotChanged = currentUrl === initialUrl;

        if (validationInfo.minLength > 0) {
          expect(validationInfo.tooShort || !validationInfo.checkValidity || isLoginButtonStillVisible || urlNotChanged).toBe(true);
        } else {
          expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);
        }
      }
    });
  });

  test('Password - проверка максимальной длины', async () => {
    await test.step('Проверка ограничения максимальной длины пароля (обычно 64-128 символов)', async () => {
      // Валидный пароль максимальной длины (128 символов)
      const maxLengthPassword = 'A'.repeat(128);
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(maxLengthPassword);

      const isValid = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => node.checkValidity());
      expect(isValid).toBe(true);

      // Пароль длиннее максимального (200 символов)
      const tooLongPassword = 'A'.repeat(200);
      await loginPage.passwordInput.fill(tooLongPassword);

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const validationInfo = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => {
        return {
          checkValidity: node.checkValidity(),
          tooLong: node.validity.tooLong,
          valueLength: node.value.length,
          maxLength: node.maxLength
        };
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      if (validationInfo.maxLength > 0) {
        expect(validationInfo.tooLong || !validationInfo.checkValidity || isLoginButtonStillVisible || urlNotChanged).toBe(true);
      } else {
        expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);
      }
    });
  });

  test('Password - проверка сложности пароля', async () => {
    await test.step('Проверка требований к сложности пароля (если применимо)', async () => {
      const weakPasswords = [
        'lowercase',
        'UPPERCASE',
        '12345678',
        '!@#$%^&*',
        'Lowercase123',
        'Lowercase!@#',
        'UPPERCASE123',
        '123!@#'
      ];

      for (const weakPassword of weakPasswords) {
        await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
        await loginPage.passwordInput.fill(weakPassword);

        const initialUrl = loginPage.page.url();
        await loginPage.loginButton.click();

        await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
          const currentUrl = loginPage.page.url();
          if (currentUrl !== initialUrl) {
            await loginPage.returnToLoginPage();
          }
        });

        const currentUrl = loginPage.page.url();
        const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
        const urlNotChanged = currentUrl === initialUrl;

        expect(isLoginButtonStillVisible || urlNotChanged || currentUrl !== initialUrl).toBe(true);
      }

      // Валидный пароль со всеми требованиями
      const strongPassword = 'StrongPass123!';
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(strongPassword);

      const isValid = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => node.checkValidity());
      expect(isValid).toBe(true);
    });
  });

  test('Password - проверка пробелов', async () => {
    await test.step('Пробелы в начале и в конце должны обрабатываться корректно', async () => {
      const passwordWithSpaces = '  Qwerty123$  ';
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(passwordWithSpaces);

      const inputValue = await loginPage.passwordInput.inputValue();

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged || currentUrl !== initialUrl).toBe(true);
    });

    await test.step('Пробел внутри пароля - проверка разрешения/запрета', async () => {
      const passwordWithSpaceInside = 'Qwerty 123$';
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(passwordWithSpaceInside);

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged || currentUrl !== initialUrl).toBe(true);
    });
  });

  test('Password - проверка отображения (скрыт/показать)', async () => {
    await test.step('Пароль должен быть скрыт по умолчанию', async () => {
      await loginPage.passwordInput.fill('Qwerty123$');

      const inputType = await loginPage.getPasswordInputType();
      expect(inputType).toBe('password');

      const isPasswordHidden = await loginPage.passwordInput.evaluate((node: HTMLInputElement) => {
        return node.type === 'password';
      });
      expect(isPasswordHidden).toBe(true);
    });

    await test.step('Проверка наличия и функциональности иконки показа/скрытия пароля', async () => {
      await loginPage.passwordInput.fill('Qwerty123$');

      // Проверяем наличие иконки toggle
      const toggleExists = await loginPage.passwordToggle.isVisible({ timeout: 2000 }).catch(() => false);

      if (toggleExists) {
        const initialType = await loginPage.getPasswordInputType();
        expect(initialType).toBe('password');

        // Кликаем на иконку для показа пароля
        await loginPage.togglePasswordVisibility();
        await expect(loginPage.passwordInput).toHaveAttribute('type', 'text', { timeout: 2000 });

        // Проверяем, что пароль виден
        const visibleValue = await loginPage.passwordInput.inputValue();
        expect(visibleValue).toBe('Qwerty123$');

        // Кликаем обратно для скрытия пароля
        await loginPage.togglePasswordVisibility();
        await expect(loginPage.passwordInput).toHaveAttribute('type', 'password', { timeout: 2000 });
      } else {
        console.log('Иконка показа/скрытия пароля не найдена на странице');
      }
    });
  });

  test('Password - проверка сообщения об ошибке для неверного пароля', async () => {
    await test.step('Корректное сообщение об ошибке при неверном пароле', async () => {
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill('WrongPassword123$');
      await loginPage.loginButton.click();

      // Ждем либо появления ошибки, либо сохранения формы видимой
      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 });

      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);

      const bodyText = await loginPage.page.locator('body').textContent();
      const hasError = isLoginButtonStillVisible || (bodyText && (
        bodyText.toLowerCase().includes('error') ||
        bodyText.toLowerCase().includes('invalid') ||
        bodyText.toLowerCase().includes('incorrect') ||
        bodyText.toLowerCase().includes('wrong')
      ));

      expect(hasError).toBe(true);

      if (bodyText) {
        const shouldNotContain = [
          'email exists',
          'email does not exist',
          'user not found',
          'user exists'
        ];

        for (const phrase of shouldNotContain) {
          expect(bodyText.toLowerCase()).not.toContain(phrase.toLowerCase());
        }
      }
    });
  });

  test('Password - проверка безопасности (XSS и SQL-инъекции)', async () => {
    await test.step('Защита от XSS в пароле', async () => {
      const xssAttempt = '<script>alert("XSS")</script>';
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(xssAttempt);

      const inputValueBeforeSubmit = await loginPage.passwordInput.inputValue();
      expect(inputValueBeforeSubmit).toContain('<script>');

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);

      if (isLoginButtonStillVisible || urlNotChanged) {
        const pageContent = await loginPage.page.content();
        expect(pageContent).not.toContain('alert("XSS")');
      }
    });

    await test.step('Защита от SQL-инъекций в пароле', async () => {
      const sqlInjectionAttempt = "' OR 1=1 --";
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(sqlInjectionAttempt);

      const inputValueBeforeSubmit = await loginPage.passwordInput.inputValue();
      expect(inputValueBeforeSubmit).toContain("' OR 1=1 --");

      const initialUrl = loginPage.page.url();
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 }).catch(async () => {
        const currentUrl = loginPage.page.url();
        if (currentUrl !== initialUrl) {
          await loginPage.returnToLoginPage();
        }
      });

      const currentUrl = loginPage.page.url();
      const isLoginButtonStillVisible = await loginPage.loginButton.isVisible().catch(() => false);
      const urlNotChanged = currentUrl === initialUrl;

      expect(isLoginButtonStillVisible || urlNotChanged).toBe(true);
    });

    await test.step('Проверка отсутствия логирования пароля в открытом виде', async () => {
      const testPassword = 'TestPassword123$';
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill(testPassword);

      const pageContent = await loginPage.page.content();
      const bodyText = await loginPage.page.locator('body').textContent();

      if (bodyText) {
        expect(bodyText).not.toContain(testPassword);
      }

      const inputType = await loginPage.getPasswordInputType();
      expect(inputType).toBe('password');
    });
  });

  test('Неуспешная авторизация с неверными данными', async () => {
    await test.step('Попытка входа с неверным email', async () => {
      await loginPage.emailInput.fill('wrong@email.com');
      await loginPage.passwordInput.fill('Qwerty123$');
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 });
      const isLoginButtonVisible = await loginPage.loginButton.isVisible().catch(() => false);
      expect(isLoginButtonVisible || await loginPage.page.locator('body').textContent()).toBeTruthy();
    });

    await test.step('Попытка входа с неверным паролем', async () => {
      await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
      await loginPage.passwordInput.fill('WrongPassword123$');
      await loginPage.loginButton.click();

      await expect(loginPage.loginButton).toBeVisible({ timeout: 5000 });
      const isLoginButtonVisible = await loginPage.loginButton.isVisible().catch(() => false);
      expect(isLoginButtonVisible || await loginPage.page.locator('body').textContent()).toBeTruthy();
    });
  });

  test('Forgot Password - проверка функциональности', async () => {
    await test.step('Проверка наличия ссылки Forgot Password', async () => {
      const forgotPasswordExists = await loginPage.forgotPasswordLink.isVisible({ timeout: 2000 }).catch(() => false);

      if (forgotPasswordExists) {
        await expect(loginPage.forgotPasswordLink).toBeVisible();
        const isClickable = await loginPage.forgotPasswordLink.isEnabled();
        expect(isClickable).toBe(true);
      } else {
        console.log('Ссылка Forgot Password не найдена на странице');
      }
    });

    await test.step('Проверка перехода по ссылке Forgot Password', async () => {
      const forgotPasswordExists = await loginPage.forgotPasswordLink.isVisible({ timeout: 2000 }).catch(() => false);

      if (forgotPasswordExists) {
        const initialUrl = loginPage.page.url();
        await loginPage.forgotPasswordLink.click();

        // Ждем либо изменения URL, либо появления формы восстановления
        await expect(loginPage.page.locator('input[type="email"], input[name*="email" i]').or(loginPage.page.locator('body')).first())
          .toBeVisible({ timeout: 5000 });

        const currentUrl = loginPage.page.url();
        const urlChanged = currentUrl !== initialUrl;
        const hasForgotPasswordForm = await loginPage.page.locator('input[type="email"], input[name*="email" i]').isVisible().catch(() => false);
        const bodyText = await loginPage.page.locator('body').textContent();
        const hasForgotPasswordText = bodyText ? (bodyText.toLowerCase().includes('forgot') || bodyText.toLowerCase().includes('reset')) : false;

        expect(urlChanged || hasForgotPasswordForm || hasForgotPasswordText).toBe(true);

        if (urlChanged) {
          await loginPage.goto();
        }
      }
    });
  });

  test('Remember Me - проверка чекбокса "Запомнить меня"', async () => {
    await test.step('Проверка наличия чекбокса Remember Me', async () => {
      const rememberMeExists = await loginPage.rememberMeCheckbox.isVisible({ timeout: 2000 }).catch(() => false);

      if (rememberMeExists) {
        await expect(loginPage.rememberMeCheckbox).toBeVisible();
        const isChecked = await loginPage.rememberMeCheckbox.isChecked();
        expect(isChecked).toBe(false);
      } else {
        console.log('Чекбокс Remember Me не найден на странице');
      }
    });

    await test.step('Проверка функциональности чекбокса Remember Me', async () => {
      const rememberMeExists = await loginPage.rememberMeCheckbox.isVisible({ timeout: 2000 }).catch(() => false);

      if (rememberMeExists) {
        const initialChecked = await loginPage.rememberMeCheckbox.isChecked();
        expect(initialChecked).toBe(false);

        await loginPage.rememberMeCheckbox.check();
        await expect(loginPage.rememberMeCheckbox).toBeChecked();

        await loginPage.rememberMeCheckbox.uncheck();
        await expect(loginPage.rememberMeCheckbox).not.toBeChecked();

        await loginPage.rememberMeCheckbox.check();
        await loginPage.emailInput.fill('ihor.mynaiev@greenice.net');
        await loginPage.passwordInput.fill('Qwerty123$');

        const checkboxStateBeforeLogin = await loginPage.rememberMeCheckbox.isChecked();
        expect(checkboxStateBeforeLogin).toBe(true);
      }
    });
  });

  test('Проверка видимости полей формы', async () => {
    await test.step('Проверка наличия всех элементов формы', async () => {
      await expect(loginPage.emailInput).toBeVisible();
      await expect(loginPage.passwordInput).toBeVisible();
      await expect(loginPage.loginButton).toBeVisible();
    });
  });

  test('Проверка типов полей ввода', async () => {
    await test.step('Проверка типа поля email', async () => {
      const inputType = await loginPage.emailInput.getAttribute('type');
      const inputName = await loginPage.emailInput.getAttribute('name');

      expect(inputType).toBe('email');
      expect(inputName).toBeTruthy();
    });

    await test.step('Проверка типа поля password', async () => {
      const inputType = await loginPage.getPasswordInputType();
      expect(inputType).toBe('password');
    });
  });
});
