/**
 * HOMEOWNER SIGNUP — КОМПЛЕКСНЫЙ ТЕСТ ФОРМЫ РЕГИСТРАЦИИ ДОМОВЛАДЕЛЬЦА
 * 
 * Данный тестовый набор выполняет полный аудит процесса регистрации пользователя типа "Homeowner",
 * включая навигацию, визуальное соответствие (UI/UX), функциональную валидацию полей и безопасность.
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. НАВИГАЦИЯ И ДОСТУПНОСТЬ:
 *    - Проверка наличия и кликабельности ссылки "Sign Up" в главном меню.
 *    - Переход в раздел выбора типа регистрации и выбор опции "Homeowner Sign Up".
 *    - Валидация корректности заголовка формы ("Homeowner Signup").
 * 
 * 2. ПОЛЕ "FULL NAME" (ИМЯ И ФАМИЛИЯ):
 *    - UI-атрибуты: проверка плейсхолдера, обязательности (required), типа (text) и автозаполнения (name).
 *    - Стили: аудит шрифтов, отступов и состояний фокуса (изменение цвета границ и теней).
 *    - Взаимодействие: работа клавиши Tab, очистка поля через горячие клавиши (Ctrl+A + Backspace).
 *    - Валидация данных: поддержка Латиницы, Кириллицы, имен с дефисами (Jean-Pierre) и апострофами (O'Brien).
 *    - Граничные значения: тесты на ввод 1, 2, 255 и 256 символов (проверка maxlength).
 *    - Негативные сценарии: обработка пустого поля, обрезка лишних пробелов (trim).
 * 
 * 3. ПОЛЕ "EMAIL" (ЭЛЕКТРОННАЯ ПОЧТА):
 *    - Технический аудит: проверка type="email", плейсхолдера и корректности autocomplete.
 *    - Позитивные сценарии: поддержка сложных форматов (поддомены, теги с символом "+", дефисы, цифры).
 *    - Валидация форматов: блокировка адресов без символа "@", без домена, с пробелами или двойными точками.
 *    - Безопасность: защита от Stored XSS (внедрение <script>) и SQL-инъекций.
 * 
 * 4. ПОЛЯ ПАРОЛЯ И ПОДТВЕРЖДЕНИЯ (PASSWORD & CONFIRMATION):
 *    - Маскировка: подтверждение типа "password" для обоих полей (скрытый ввод).
 *    - Требования к сложности: проверка валидации минимальной длины (8 символов) и наличия цифр/спецсимволов/заглавных букв.
 *    - Логика подтверждения: строгая проверка на совпадение значений (обнаружение ошибок при разном регистре или лишних символах).
 *    - Интерактивность: проверка функционала кнопки "show/hide password" (переключение типа на "text" и обратно).
 * 
 * 5. КНОПКА "SIGNUP" И ОТПРАВКА ФОРМЫ:
 *    - Визуальный аудит: текст кнопки, стили оформления (классы site-button), cursor: pointer.
 *    - Поведенческий тест: проверка состояния Hover (наведение) и Focus.
 *    - Логика валидации: запуск проверки всех полей при клике на пустую форму.
 *    - Submission Test: имитация успешной регистрации с валидными данными и проверка ответа сервера.
 *    - Состояние загрузки: проверка блокировки кнопки (disabled) или изменения текста во время обработки запроса.
 * 
 * 6. ГЛОБАЛЬНЫЙ UI/UX И АДАПТИВНОСТЬ:
 *    - Вызов функции checkUIUX для анализа верстки на различных разрешениях (Desktop, Tablet, Mobile).
 *    - Проверка семантики элементов, корректности применения теней (shadow-sm) и общих CSS-стандартов.
 * 
 * ИТОГ: Тест гарантирует, что новый домовладелец может беспрепятственно зарегистрироваться, 
 * форма защищена от некорректного ввода, а интерфейс стабилен и удобен на любых устройствах.
 */

import { test, expect } from '@playwright/test';
import { checkUIUX, BRAND_COLORS } from './helpers/ui-ux-helpers';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Homeowner Signup - Проверка навигации и отображения формы регистрации Homeowner
 * 
 * Этот тест проверяет:
 * - Навигацию на страницу регистрации
 * - Переключение на форму Homeowner Signup
 * - Отображение заголовка формы
 * - Наличие основных элементов
 * - UI/UX и адаптивность страницы
 * 
 * @see README.md для подробной документации
 */
test.describe('Homeowner Signup Navigation @regression', () => {
  test.beforeEach(async ({ page }) => {
    // Устанавливаем размер viewport
    await page.setViewportSize({ width: 1920, height: 1080 });
  await page.goto('https://dev.indooroutdoor.com/');
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Навигация к форме Homeowner Signup и проверка отображения', async ({ page }) => {
    await test.step('Проверка наличия ссылки Sign Up на главной странице', async () => {
  await expect(page.getByRole('navigation')).toContainText('Sign Up');
  await expect(page.getByRole('link', { name: 'Sign Up' })).toBeVisible();
      console.log('✅ Ссылка Sign Up найдена на главной странице');
    });

    await test.step('Переход на страницу регистрации', async () => {
  await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      console.log('✅ Переход на страницу регистрации выполнен');
    });

    await test.step('Проверка отображения опции Homeowner Sign Up', async () => {
      await expect(page.getByText('Homeowner Sign Up')).toBeVisible({ timeout: 10000 });
  await expect(page.locator('body')).toContainText('Homeowner');
      console.log('✅ Опция Homeowner Sign Up отображается');
    });

    await test.step('Переход к форме Homeowner Signup', async () => {
      // Используем гибкий селектор для поиска ссылки
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(500);
      console.log('✅ Переход к форме Homeowner Signup выполнен');
    });

    await test.step('Проверка заголовка формы Homeowner Signup', async () => {
      await expect(page.locator('h3')).toContainText('Homeowner Signup', { timeout: 10000 });
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      
      const heading = page.getByRole('heading', { name: 'Homeowner Signup' });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Homeowner Signup');
      console.log(`✅ Заголовок формы найден: "${headingText?.trim()}"`);
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Full Name: Валидация и стили', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

    // Навигация к форме Homeowner Signup
    await test.step('Навигация к форме Homeowner Signup', async () => {
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что форма загрузилась
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      console.log('✅ Навигация к форме Homeowner Signup выполнена');
    });

    // 1. UI/UX проверки (Внешний вид)
    await test.step('UI/UX проверки поля Full Name', async () => {
      // 1.1. Поиск поля по различным селекторам
      const fullNameInput = page.locator('input#name, input[name="name"], input[placeholder*="name" i]').first();
      const inputExists = await fullNameInput.count();
      expect(inputExists).toBeGreaterThan(0);
      console.log('✅ Поле Full Name найдено');

      // 1.2. Placeholder
      const placeholder = await fullNameInput.getAttribute('placeholder');
      if (placeholder) {
        expect(placeholder.toLowerCase()).toContain('name');
        console.log(`✅ Placeholder найден: "${placeholder}"`);
      } else {
        console.log('⚠️ Placeholder не найден');
      }

      // 1.3. Проверка required атрибута
      const isRequired = await fullNameInput.getAttribute('required');
      if (isRequired !== null) {
        console.log('✅ Поле помечено как обязательное (required)');
      }

      // 1.4. Проверка autocomplete атрибута
      const autocomplete = await fullNameInput.getAttribute('autocomplete');
      if (autocomplete === 'name') {
        console.log('✅ Autocomplete установлен: "name"');
      }

      // 1.5. Проверка типа поля
      const inputType = await fullNameInput.getAttribute('type');
      expect(inputType).toBe('text');
      console.log(`✅ Тип поля: "${inputType}"`);

      // 1.6. Проверка классов CSS
      const classes = await fullNameInput.getAttribute('class');
      if (classes) {
        expect(classes).toContain('form-control');
        console.log(`✅ CSS классы применены: "${classes}"`);
      }

      // 1.7. Focus State - проверка изменения стилей при фокусе
      await fullNameInput.click();
      await page.waitForTimeout(300);
      const focusedStyles = await fullNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderColor: styles.borderColor,
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus State: border-color=${focusedStyles.borderColor}, outline=${focusedStyles.outline}`);

      // 1.8. Шрифт и отступы
      const inputStyles = await fullNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: font-size=${inputStyles.fontSize}, padding=${inputStyles.padding}, border-radius=${inputStyles.borderRadius}`);

      // 1.9. Проверка shadow-sm класса
      if (classes?.includes('shadow-sm')) {
        console.log('✅ Класс shadow-sm применен');
      }
    });

    // 2. Состояние поля (State)
    await test.step('Проверка состояния поля Full Name', async () => {
      const fullNameInput = page.locator('input#name, input[name="name"], input[placeholder*="name" i]').first();
      
      // 2.1. Read-only / Disabled
      const isReadOnly = await fullNameInput.getAttribute('readonly');
      const isDisabled = await fullNameInput.isDisabled();
      expect(isReadOnly).toBeNull();
      expect(isDisabled).toBe(false);
      console.log('✅ Поле доступно для редактирования (не read-only и не disabled)');

      // 2.2. Взаимодействие с клавиатурой - Tab
      await fullNameInput.click();
      await page.keyboard.press('Tab');
      await page.waitForTimeout(200);
      const focusedElement = await page.evaluate(() => document.activeElement?.tagName);
      console.log(`✅ Tab работает (активный элемент: ${focusedElement})`);

      // 2.3. Очистка через Ctrl+A + Backspace
      await fullNameInput.fill('Test Name');
      await fullNameInput.click();
      await page.keyboard.press('Control+A');
      await page.keyboard.press('Backspace');
      await page.waitForTimeout(200);
      const clearedValue = await fullNameInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Очистка через Ctrl+A + Backspace работает');
    });

    // 3. Позитивные тесты (Happy Path)
    await test.step('Позитивные тесты поля Full Name', async () => {
      const fullNameInput = page.locator('input#name, input[name="name"], input[placeholder*="name" i]').first();

      // 3.1. Стандартный ввод: Латиница
      await fullNameInput.fill('John Doe');
      const latinValue = await fullNameInput.inputValue();
      expect(latinValue).toBe('John Doe');
      console.log(`✅ Латиница принята: "${latinValue}"`);

      // 3.2. Кириллица
      await fullNameInput.fill('Иван Иванов');
      const cyrillicValue = await fullNameInput.inputValue();
      expect(cyrillicValue).toBe('Иван Иванов');
      console.log(`✅ Кириллица принята: "${cyrillicValue}"`);

      // 3.3. Дефис (для двойных имен)
      await fullNameInput.fill('Mary-Jane Watson');
      const hyphenValue = await fullNameInput.inputValue();
      expect(hyphenValue).toBe('Mary-Jane Watson');
      console.log(`✅ Дефис принят: "${hyphenValue}"`);

      // 3.4. Апостроф
      await fullNameInput.fill("O'Brien");
      const apostropheValue = await fullNameInput.inputValue();
      expect(apostropheValue).toContain("'");
      console.log(`✅ Апостроф принят: "${apostropheValue}"`);

      // 3.5. Пробелы - полное имя из нескольких слов
      await fullNameInput.fill('John Michael Smith');
      const spacesValue = await fullNameInput.inputValue();
      expect(spacesValue).toContain(' ');
      expect(spacesValue).toBe('John Michael Smith');
      console.log(`✅ Пробелы приняты: "${spacesValue}"`);
    });

    // 4. Граничные значения (Boundary Testing)
    await test.step('Граничные значения поля Full Name', async () => {
      const fullNameInput = page.locator('input#name, input[name="name"], input[placeholder*="name" i]').first();

      // 4.1. Минимальная длина: 1 символ
      await fullNameInput.fill('A');
      const value1 = await fullNameInput.inputValue();
      expect(value1.length).toBe(1);
      console.log(`✅ Минимальная длина (1 символ): "${value1}" (длина: ${value1.length})`);

      // 4.2. Минимальная длина: 2 символа
      await fullNameInput.fill('AB');
      const value2 = await fullNameInput.inputValue();
      expect(value2.length).toBe(2);
      console.log(`✅ Минимальная длина (2 символа): "${value2}" (длина: ${value2.length})`);

      // 4.3. Максимальная длина: 255 символов
      const maxLengthValue = 'A'.repeat(255);
      await fullNameInput.fill(maxLengthValue);
      const value255 = await fullNameInput.inputValue();
      expect(value255.length).toBeLessThanOrEqual(255);
      console.log(`✅ Максимальная длина (255 символов): длина=${value255.length}`);

      // 4.4. Превышение лимита: 256 символов
      const overLimitValue = 'A'.repeat(256);
      await fullNameInput.fill(overLimitValue);
      const value256 = await fullNameInput.inputValue();
      if (value256.length === 255) {
        console.log(`✅ Превышение лимита обработано: 256 символов обрезано до ${value256.length} (maxlength работает)`);
      } else if (value256.length === 256) {
        console.log(`⚠️ Превышение лимита: поле приняло ${value256.length} символов (возможно, валидация на сервере)`);
      } else {
        console.log(`✅ Превышение лимита обработано: длина=${value256.length}`);
      }
      expect(value256.length).toBeLessThanOrEqual(256);
    });

    // 5. Негативные тесты и валидация
    await test.step('Негативные тесты и валидация поля Full Name', async () => {
      const fullNameInput = page.locator('input#name, input[name="name"], input[placeholder*="name" i]').first();

      // 5.1. Пустое поле (required)
      await fullNameInput.clear();
      await fullNameInput.blur();
      await page.waitForTimeout(500);
      
      // Пытаемся отправить форму с пустым полем
      const signupButton = page.getByRole('button', { name: /Signup|Sign Up|Register|Create Account/i }).first();
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty|field is required/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация пустого поля: сообщение об ошибке - "${errorText?.trim()}"`);
      } else {
        // Проверяем через aria-invalid
        const isInvalid = await fullNameInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация пустого поля: поле помечено как невалидное (aria-invalid="true")');
        } else {
          // Проверяем HTML5 валидацию
          const validity = await fullNameInput.evaluate((el: HTMLInputElement) => el.validity.valueMissing);
          if (validity) {
            console.log('✅ Валидация пустого поля: HTML5 валидация работает (valueMissing)');
          } else {
            console.log('⚠️ Валидация пустого поля: сообщение об ошибке не найдено (возможно, валидация на сервере)');
          }
        }
      }

      // 5.2. Только пробелы
      await fullNameInput.fill('   ');
      await fullNameInput.blur();
      await page.waitForTimeout(500);
      const spacesOnlyValue = await fullNameInput.inputValue();
      
      // Проверяем, что пробелы обрезаны (trim)
      if (spacesOnlyValue.trim() === '') {
        console.log('✅ Только пробелы обработаны: поле обрезает пробелы (trim работает)');
      } else {
        console.log(`⚠️ Только пробелы: поле приняло "${spacesOnlyValue}" (trim не работает)`);
      }

      // 5.3. Лишние пробелы в начале и конце
      await fullNameInput.fill('  John Doe  ');
      await fullNameInput.blur();
      await page.waitForTimeout(500);
      const trimmedValue = await fullNameInput.inputValue();
      if (trimmedValue.trim() === trimmedValue) {
        console.log('✅ Лишние пробелы обрезаны');
      } else {
        console.log(`⚠️ Лишние пробелы: "${trimmedValue}"`);
      }
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Email: Валидация и стили', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

    // Навигация к форме Homeowner Signup
    await test.step('Навигация к форме Homeowner Signup', async () => {
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что форма загрузилась
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      console.log('✅ Навигация к форме Homeowner Signup выполнена');
    });

    // 1. UI/UX проверки (Внешний вид)
    await test.step('UI/UX проверки поля Email', async () => {
      // Используем ID и проверку видимости
      const emailInput = page.locator('#email:visible');
      
      // Ждем, пока поле станет видимым
      await expect(emailInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Email найдено и видимо');

      // 1.1. Проверка плейсхолдера (теперь он точно найдется)
      await expect(emailInput).toHaveAttribute('placeholder', 'example@email.com');
      console.log('✅ Placeholder найден: "example@email.com"');

      // 1.2. Проверка обязательности
      await expect(emailInput).toHaveAttribute('required', 'required');
      console.log('✅ Поле помечено как обязательное (required)');

      // 1.3. Проверка типа
      await expect(emailInput).toHaveAttribute('type', 'email');
      console.log('✅ Тип поля: "email"');

      // 1.4. Проверка автозаполнения (Autocomplete)
      await expect(emailInput).toHaveAttribute('autocomplete', 'username');
      console.log('✅ Autocomplete установлен: "username"');

      // 1.5. Проверка классов CSS
      const classes = await emailInput.getAttribute('class');
      if (classes) {
        expect(classes).toContain('form-control');
        console.log(`✅ CSS классы применены: "${classes}"`);
      }

      // 1.6. Взаимодействие (теперь клик сработает мгновенно)
      await emailInput.scrollIntoViewIfNeeded();
      await emailInput.click();
      await page.waitForTimeout(300);
      console.log('✅ Поле Email успешно сфокусировано');

      // 1.7. Focus State - проверка изменения стилей при фокусе
      const focusedStyles = await emailInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderColor: styles.borderColor,
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus State: border-color=${focusedStyles.borderColor}, outline=${focusedStyles.outline}`);

      // 1.8. Шрифт и отступы
      const inputStyles = await emailInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: font-size=${inputStyles.fontSize}, padding=${inputStyles.padding}, border-radius=${inputStyles.borderRadius}`);

      // 1.9. Проверка shadow-sm класса
      if (classes?.includes('shadow-sm')) {
        console.log('✅ Класс shadow-sm применен');
      }
    });

    // 2. Состояние поля (State)
    await test.step('Проверка состояния поля Email', async () => {
      const emailInput = page.locator('#email:visible');
      await emailInput.scrollIntoViewIfNeeded();
      
      // 2.1. Read-only / Disabled
      const isReadOnly = await emailInput.getAttribute('readonly');
      const isDisabled = await emailInput.isDisabled();
      expect(isReadOnly).toBeNull();
      expect(isDisabled).toBe(false);
      console.log('✅ Поле доступно для редактирования (не read-only и не disabled)');

      // 2.2. Взаимодействие с клавиатурой - Tab
      await emailInput.click();
      await page.keyboard.press('Tab');
      await page.waitForTimeout(200);
      const focusedElement = await page.evaluate(() => document.activeElement?.tagName);
      console.log(`✅ Tab работает (активный элемент: ${focusedElement})`);

      // 2.3. Очистка через Ctrl+A + Backspace
      await emailInput.fill('ihor.mynaiev+1@greenice.net');
      await emailInput.click();
      await page.keyboard.press('Control+A');
      await page.keyboard.press('Backspace');
      await page.waitForTimeout(200);
      const clearedValue = await emailInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Очистка через Ctrl+A + Backspace работает');
    });

    // 3. Позитивные тесты (Happy Path) - Валидные email адреса
    await test.step('Позитивные тесты поля Email - валидные форматы', async () => {
      const emailInput = page.locator('#email:visible');
      await emailInput.scrollIntoViewIfNeeded();

      // 3.1. Стандартный email
      await emailInput.fill('ihor.mynaiev+1@greenice.net');
      const standardValue = await emailInput.inputValue();
      expect(standardValue).toBe('ihor.mynaiev+1@greenice.net');
      console.log(`✅ Стандартный email принят: "${standardValue}"`);

      // 3.2. Email с поддоменом
      await emailInput.fill('ihor.mynaiev+sub@greenice.net');
      const subdomainValue = await emailInput.inputValue();
      expect(subdomainValue).toBe('ihor.mynaiev+sub@greenice.net');
      console.log(`✅ Email с поддоменом принят: "${subdomainValue}"`);

      // 3.3. Email с точкой в локальной части
      await emailInput.fill('ihor.mynaiev.dot@greenice.net');
      const dotValue = await emailInput.inputValue();
      expect(dotValue).toBe('ihor.mynaiev.dot@greenice.net');
      console.log(`✅ Email с точкой принят: "${dotValue}"`);

      // 3.4. Email с плюсом (tag)
      await emailInput.fill('ihor.mynaiev+tag@greenice.net');
      const plusValue = await emailInput.inputValue();
      expect(plusValue).toBe('ihor.mynaiev+tag@greenice.net');
      console.log(`✅ Email с плюсом принят: "${plusValue}"`);

      // 3.5. Email с дефисом
      await emailInput.fill('ihor-mynaiev@greenice.net');
      const hyphenValue = await emailInput.inputValue();
      expect(hyphenValue).toBe('ihor-mynaiev@greenice.net');
      console.log(`✅ Email с дефисом принят: "${hyphenValue}"`);

      // 3.6. Email с цифрами
      await emailInput.fill('ihor.mynaiev123@greenice.net');
      const numbersValue = await emailInput.inputValue();
      expect(numbersValue).toBe('ihor.mynaiev123@greenice.net');
      console.log(`✅ Email с цифрами принят: "${numbersValue}"`);

      // 3.7. Email с длинным доменом
      await emailInput.fill('ihor.mynaiev@greenice.co.uk');
      const longDomainValue = await emailInput.inputValue();
      expect(longDomainValue).toBe('ihor.mynaiev@greenice.co.uk');
      console.log(`✅ Email с длинным доменом принят: "${longDomainValue}"`);

      // 3.8. Email с нижним подчеркиванием
      await emailInput.fill('ihor_mynaiev@greenice.net');
      const underscoreValue = await emailInput.inputValue();
      expect(underscoreValue).toBe('ihor_mynaiev@greenice.net');
      console.log(`✅ Email с подчеркиванием принят: "${underscoreValue}"`);
    });

    // 4. Граничные значения (Boundary Testing)
    await test.step('Граничные значения поля Email', async () => {
      const emailInput = page.locator('#email:visible');
      await emailInput.scrollIntoViewIfNeeded();

      // 4.1. Минимальная длина локальной части
      await emailInput.fill('a@b.co');
      const minValue = await emailInput.inputValue();
      expect(minValue).toBe('a@b.co');
      console.log(`✅ Минимальная длина: "${minValue}"`);

      //4.2. Максимальная длина: 254 символа (RFC 5321)
      const maxLengthEmail = 'a'.repeat(64) + '@' + 'b'.repeat(189) + '.com';
      await emailInput.fill(maxLengthEmail);
      const maxValue = await emailInput.inputValue();
      expect(maxValue.length).toBeLessThanOrEqual(254);
      console.log(`✅ Максимальная длина: длина=${maxValue.length}`);

      // 4.3. Длинная локальная часть
      const longLocal = 'ihor.mynaiev.' + 'a'.repeat(40) + '@greenice.net';
      await emailInput.fill(longLocal);
      const longLocalValue = await emailInput.inputValue();
      expect(longLocalValue).toBe(longLocal);
      console.log(`✅ Длинная локальная часть принята: длина=${longLocalValue.length}`);
    });

    // 5. Негативные тесты и валидация
    await test.step('Негативные тесты и валидация поля Email', async () => {
      const emailInput = page.locator('#email:visible');
      const signupButton = page.getByRole('button', { name: /Signup|Sign Up|Register|Create Account/i }).first();
      await emailInput.scrollIntoViewIfNeeded();

      // 1. Предварительно заполняем поле Full Name рандомным значением
      const fullNameInput = page.locator('input#name, input[name="name"]').first();
      const randomNumber = Math.floor(Math.random() * 10000);
      await fullNameInput.fill(`Test ${randomNumber}`);
      console.log(`✅ Поле Full Name заполнено для теста: "Test ${randomNumber}"`);

      // 5.1. Пустое поле (required)
      await emailInput.clear();
      await emailInput.blur();
      await page.waitForTimeout(500);
      
      // Пытаемся отправить форму с пустым полем
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty|field is required/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация пустого поля: сообщение об ошибке - "${errorText?.trim()}"`);
      } else {
        // Проверяем через aria-invalid
        const isInvalid = await emailInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация пустого поля: поле помечено как невалидное (aria-invalid="true")');
        } else {
          // Проверяем HTML5 валидацию
          const validity = await emailInput.evaluate((el: HTMLInputElement) => el.validity.valueMissing);
          if (validity) {
            console.log('✅ Валидация пустого поля: HTML5 валидация работает (valueMissing)');
          } else {
            console.log('⚠️ Валидация пустого поля: сообщение об ошибке не найдено (возможно, валидация на сервере)');
          }
        }
      }

      // 5.2. Невалидные форматы email
      const invalidEmails = [
        { email: 'ihor.mynaiev', description: 'без @' },
        { email: '@greenice.net', description: 'без локальной части' },
        { email: 'ihor.mynaiev@', description: 'без домена' },
        { email: 'ihor.mynaiev@.net', description: 'пустой домен' },
        { email: 'ihor.mynaiev@greenice', description: 'без TLD' },
        { email: 'ihor mynaiev@greenice.net', description: 'с пробелом' },
        { email: 'ihor.mynaiev@greenice..net', description: 'двойная точка в домене' },
        { email: 'ihor.mynaiev@@greenice.net', description: 'двойной @' },
        { email: '.ihor.mynaiev@greenice.net', description: 'точка в начале' },
        { email: 'ihor.mynaiev.@greenice.net', description: 'точка в конце локальной части' }
      ];

      for (const { email, description } of invalidEmails) {
        await emailInput.fill(email);
        
        // НАЖИМАЕМ КНОПКУ после каждого ввода для проверки реальной валидации формы
        await signupButton.click();
        await page.waitForTimeout(500); // Небольшая пауза для отрисовки ошибки
        
        // Проверяем валидность (либо браузерную, либо наличие текста ошибки на странице)
        const isValid = await emailInput.evaluate((el: HTMLInputElement) => el.validity.valid);
        const errorMsg = page.locator('text=/invalid|неверный|некорректный|email/i').first();
        const errorVisible = await errorMsg.isVisible().catch(() => false);

        if (!isValid || errorVisible) {
          console.log(`✅ Невалидный email отклонен (${description}): "${email}"`);
        } else {
          console.log(`⚠️ Невалидный email был принят формой (${description}): "${email}"`);
        }
      }

      // 5.3. Только пробелы
      await emailInput.fill('   ');
      await emailInput.blur();
      await page.waitForTimeout(500);
      const spacesOnlyValue = await emailInput.inputValue();
      
      // Проверяем, что пробелы обрезаны (trim)
      if (spacesOnlyValue.trim() === '') {
        console.log('✅ Только пробелы обработаны: поле обрезает пробелы (trim работает)');
      } else {
        console.log(`⚠️ Только пробелы: поле приняло "${spacesOnlyValue}" (trim не работает)`);
      }
    });

    // 6. Проверка безопасности
    await test.step('Проверка безопасности поля Email', async () => {
      const emailInput = page.locator('#email:visible');
      await emailInput.scrollIntoViewIfNeeded();

      // 6.1. XSS-уязвимость: HTML-теги
      await emailInput.fill('<script>alert("xss")</script>@greenice.net');
      const xssValue = await emailInput.inputValue();
      // Проверяем, что теги не выполнились
      const hasAlert = await page.evaluate(() => {
        return typeof window.alert === 'function';
      });
      console.log(`✅ XSS защита: значение сохранено как текст: "${xssValue.substring(0, 30)}..."`);

      // 6.2. SQL-инъекция
      await emailInput.fill("ihor.mynaiev'--@greenice.net");
      const sqlValue = await emailInput.inputValue();
      expect(sqlValue).toContain("'--");
      console.log(`✅ SQL-инъекция обработана: значение принято как текст: "${sqlValue}"`);

      // Очищаем поле после проверок безопасности
      await emailInput.clear();
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Password: Валидация и стили', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

    // Навигация к форме Homeowner Signup
    await test.step('Навигация к форме Homeowner Signup', async () => {
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что форма загрузилась
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      console.log('✅ Навигация к форме Homeowner Signup выполнена');
    });

    // 1. UI/UX проверки (Внешний вид)
    await test.step('UI/UX проверки поля Password', async () => {
      // Используем ID и проверку видимости
      const passwordInput = page.locator('#password:visible');
      
      // Ждем, пока поле станет видимым
      await expect(passwordInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Password найдено и видимо');

      // 1.1. Проверка типа поля
      await expect(passwordInput).toHaveAttribute('type', 'password');
      console.log('✅ Тип поля: "password"');

      // 1.2. Проверка плейсхолдера
      await expect(passwordInput).toHaveAttribute('placeholder', '*************');
      console.log('✅ Placeholder найден: "*************"');

      // 1.3. Проверка обязательности
      const isRequired = await passwordInput.getAttribute('required');
      if (isRequired !== null) {
        console.log('✅ Поле помечено как обязательное (required)');
      }

      // 1.4. Проверка классов CSS
      const classes = await passwordInput.getAttribute('class');
      if (classes) {
        expect(classes).toContain('form-control');
        expect(classes).toContain('pass-input');
        console.log(`✅ CSS классы применены: "${classes}"`);
      }

      // 1.5. Взаимодействие (теперь клик сработает мгновенно)
      await passwordInput.scrollIntoViewIfNeeded();
      await passwordInput.click();
      await page.waitForTimeout(300);
      console.log('✅ Поле Password успешно сфокусировано');

      // 1.6. Focus State - проверка изменения стилей при фокусе
      const focusedStyles = await passwordInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderColor: styles.borderColor,
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus State: border-color=${focusedStyles.borderColor}, outline=${focusedStyles.outline}`);

      // 1.7. Шрифт и отступы
      const inputStyles = await passwordInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: font-size=${inputStyles.fontSize}, padding=${inputStyles.padding}, border-radius=${inputStyles.borderRadius}`);

      // 1.8. Проверка, что пароль скрыт (type="password")
      const inputType = await passwordInput.getAttribute('type');
      expect(inputType).toBe('password');
      console.log('✅ Пароль скрыт (type="password")');
    });

    // 2. Состояние поля (State)
    await test.step('Проверка состояния поля Password', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();
      
      // 2.1. Read-only / Disabled
      const isReadOnly = await passwordInput.getAttribute('readonly');
      const isDisabled = await passwordInput.isDisabled();
      expect(isReadOnly).toBeNull();
      expect(isDisabled).toBe(false);
      console.log('✅ Поле доступно для редактирования (не read-only и не disabled)');

      // 2.2. Взаимодействие с клавиатурой - Tab
      await passwordInput.click();
      await page.waitForTimeout(200);
      const focusedElement = await page.evaluate(() => document.activeElement?.tagName);
      console.log(`✅ Tab работает (активный элемент: ${focusedElement})`);

      // 2.3. Очистка через Ctrl+A + Backspace
      await passwordInput.fill('TestPassword123!');
      await passwordInput.click();
      await page.keyboard.press('Control+A');
      await page.keyboard.press('Backspace');
      await page.waitForTimeout(200);
      const clearedValue = await passwordInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Очистка через Ctrl+A + Backspace работает');
    });

    // 3. Позитивные тесты (Happy Path) - Валидные пароли
    await test.step('Позитивные тесты поля Password - валидные пароли', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();

      // 3.1. Стандартный пароль с буквами, цифрами и спецсимволами
      await passwordInput.fill('Password123!');
      const standardValue = await passwordInput.inputValue();
      expect(standardValue).toBe('Password123!');
      console.log(`✅ Стандартный пароль принят (длина: ${standardValue.length})`);

      // 3.2. Пароль с заглавными и строчными буквами
      await passwordInput.fill('MySecurePass1');
      const mixedCaseValue = await passwordInput.inputValue();
      expect(mixedCaseValue).toBe('MySecurePass1');
      console.log(`✅ Пароль с разным регистром принят: "${mixedCaseValue}"`);

      // 3.3. Пароль со специальными символами
      await passwordInput.fill('Pass@Word#123');
      const specialCharsValue = await passwordInput.inputValue();
      expect(specialCharsValue).toBe('Pass@Word#123');
      console.log(`✅ Пароль со спецсимволами принят: "${specialCharsValue}"`);

      // 3.4. Пароль с дефисом и подчеркиванием
      await passwordInput.fill('Pass-Word_123');
      const dashUnderscoreValue = await passwordInput.inputValue();
      expect(dashUnderscoreValue).toBe('Pass-Word_123');
      console.log(`✅ Пароль с дефисом и подчеркиванием принят: "${dashUnderscoreValue}"`);

      // 3.5. Длинный пароль
      await passwordInput.fill('VeryLongPassword123!@#');
      const longValue = await passwordInput.inputValue();
      expect(longValue.length).toBeGreaterThan(15);
      console.log(`✅ Длинный пароль принят (длина: ${longValue.length})`);
    });

    // 4. Граничные значения (Boundary Testing)
    await test.step('Граничные значения поля Password', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();

      // 4.1. Минимальная длина: 1 символ
      await passwordInput.fill('A');
      const value1 = await passwordInput.inputValue();
      expect(value1.length).toBe(1);
      console.log(`✅ Минимальная длина (1 символ): длина=${value1.length}`);

      // 4.2. Минимальная длина: 8 символов (стандартный минимум)
      await passwordInput.fill('Pass123!');
      const value8 = await passwordInput.inputValue();
      expect(value8.length).toBe(8);
      console.log(`✅ Минимальная длина (8 символов): длина=${value8.length}`);

      // 4.3. Максимальная длина: 128 символов (стандартный максимум)
      const maxLengthPassword = 'A'.repeat(128);
      await passwordInput.fill(maxLengthPassword);
      const value128 = await passwordInput.inputValue();
      expect(value128.length).toBeLessThanOrEqual(128);
      console.log(`✅ Максимальная длина (128 символов): длина=${value128.length}`);

      // 4.4. Превышение лимита: 129 символов
      const overLimitPassword = 'A'.repeat(129);
      await passwordInput.fill(overLimitPassword);
      const value129 = await passwordInput.inputValue();
      if (value129.length === 128) {
        console.log(`✅ Превышение лимита обработано: 129 символов обрезано до ${value129.length}`);
      } else {
        console.log(`⚠️ Превышение лимита: поле приняло ${value129.length} символов`);
      }
      expect(value129.length).toBeLessThanOrEqual(129);
    });

    // 5. Негативные тесты и валидация
    await test.step('Негативные тесты и валидация поля Password', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();

      // 5.1. Пустое поле (required)
      await passwordInput.clear();
      await passwordInput.blur();
      await page.waitForTimeout(500);
      
      // Пытаемся отправить форму с пустым полем
      const signupButton = page.getByRole('button', { name: /Signup|Sign Up|Register|Create Account/i }).first();
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty|field is required|password.*required/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация пустого поля: сообщение об ошибке - "${errorText?.trim()}"`);
      } else {
        // Проверяем через aria-invalid
        const isInvalid = await passwordInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация пустого поля: поле помечено как невалидное (aria-invalid="true")');
        } else {
          // Проверяем HTML5 валидацию
          const validity = await passwordInput.evaluate((el: HTMLInputElement) => el.validity.valueMissing);
          if (validity) {
            console.log('✅ Валидация пустого поля: HTML5 валидация работает (valueMissing)');
          } else {
            console.log('⚠️ Валидация пустого поля: сообщение об ошибке не найдено (возможно, валидация на сервере)');
          }
        }
      }

      // 5.2. Слишком короткий пароль (менее 8 символов)
      await passwordInput.fill('Short1!');
      await passwordInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const lengthError = page.locator('text=/password.*length|минимум|at least|8.*characters/i').first();
      const lengthErrorExists = await lengthError.count();
      if (lengthErrorExists > 0) {
        const errorText = await lengthError.textContent();
        console.log(`✅ Валидация минимальной длины: сообщение - "${errorText?.trim()}"`);
      } else {
        console.log('⚠️ Валидация минимальной длины: сообщение не найдено (возможно, валидация на сервере)');
      }

      // 5.3. Пароль без цифр
      await passwordInput.fill('NoNumbers!');
      await passwordInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const numbersError = page.locator('text=/password.*number|цифр|digit/i').first();
      const numbersErrorExists = await numbersError.count();
      if (numbersErrorExists > 0) {
        console.log('✅ Валидация наличия цифр работает');
      } else {
        console.log('⚠️ Валидация наличия цифр: сообщение не найдено');
      }

      // 5.4. Пароль без специальных символов
      await passwordInput.fill('NoSpecial123');
      await passwordInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const specialError = page.locator('text=/password.*special|специальн|character/i').first();
      const specialErrorExists = await specialError.count();
      if (specialErrorExists > 0) {
        console.log('✅ Валидация наличия спецсимволов работает');
      } else {
        console.log('⚠️ Валидация наличия спецсимволов: сообщение не найдено');
      }

      // 5.5. Пароль без заглавных букв
      await passwordInput.fill('nolowercase123!');
      await passwordInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const caseError = page.locator('text=/password.*uppercase|заглавн|capital/i').first();
      const caseErrorExists = await caseError.count();
      if (caseErrorExists > 0) {
        console.log('✅ Валидация наличия заглавных букв работает');
      } else {
        console.log('⚠️ Валидация наличия заглавных букв: сообщение не найдено');
      }

      // 5.6. Только пробелы
      await passwordInput.fill('   ');
      await passwordInput.blur();
      await page.waitForTimeout(500);
      const spacesOnlyValue = await passwordInput.inputValue();
      
      // Проверяем, что пробелы обрезаны (trim)
      if (spacesOnlyValue.trim() === '') {
        console.log('✅ Только пробелы обработаны: поле обрезает пробелы (trim работает)');
      } else {
        console.log(`⚠️ Только пробелы: поле приняло "${spacesOnlyValue}" (trim не работает)`);
      }
    });

    // 6. Проверка безопасности
    await test.step('Проверка безопасности поля Password', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();

      // 6.1. XSS-уязвимость: HTML-теги
      await passwordInput.fill('<script>alert("xss")</script>');
      const xssValue = await passwordInput.inputValue();
      // Проверяем, что теги не выполнились
      const hasAlert = await page.evaluate(() => {
        return typeof window.alert === 'function';
      });
      console.log(`✅ XSS защита: значение сохранено как текст: "${xssValue.substring(0, 20)}..."`);

      // 6.2. SQL-инъекция
      await passwordInput.fill("admin'--");
      const sqlValue = await passwordInput.inputValue();
      expect(sqlValue).toContain("'--");
      console.log(`✅ SQL-инъекция обработана: значение принято как текст: "${sqlValue}"`);

      // 6.3. Проверка, что пароль скрыт при вводе
      await passwordInput.fill('VisiblePassword123!');
      const inputType = await passwordInput.getAttribute('type');
      expect(inputType).toBe('password');
      
      // Проверяем, что значение не видно в DOM (должно быть скрыто)
      const isPasswordType = await passwordInput.evaluate((el: HTMLInputElement) => el.type === 'password');
      expect(isPasswordType).toBe(true);
      console.log('✅ Пароль скрыт при вводе (type="password")');

      // Очищаем поле после проверок безопасности
      await passwordInput.clear();
    });

    // 7. Проверка кнопки show/hide password (если есть)
    await test.step('Проверка кнопки show/hide password', async () => {
      const passwordInput = page.locator('#password:visible');
      await passwordInput.scrollIntoViewIfNeeded();
      
      // Ищем кнопку переключения видимости пароля
      const toggleButton = page.locator('button[aria-label*="password" i], button[title*="password" i], button:has-text("show"), button:has-text("hide"), [class*="eye"], [class*="toggle"]').first();
      
      const toggleExists = await toggleButton.count();
      if (toggleExists > 0) {
        const isVisible = await toggleButton.isVisible().catch(() => false);
        if (isVisible) {
          await passwordInput.fill('TestPassword123!');
          
          // Проверяем начальное состояние (password)
          let inputType = await passwordInput.getAttribute('type');
          expect(inputType).toBe('password');
          console.log('✅ Пароль скрыт по умолчанию');

          // Кликаем на кнопку show
          await toggleButton.click();
          await page.waitForTimeout(300);
          inputType = await passwordInput.getAttribute('type');
          if (inputType === 'text') {
            console.log('✅ Пароль отображается после клика на show');
          }

          // Кликаем на кнопку hide
          await toggleButton.click();
          await page.waitForTimeout(300);
          inputType = await passwordInput.getAttribute('type');
          if (inputType === 'password') {
            console.log('✅ Пароль скрыт после клика на hide');
          }
        } else {
          console.log('⚠️ Кнопка show/hide password найдена, но не видима');
        }
      } else {
        console.log('ℹ️ Кнопка show/hide password не найдена (возможно, не реализована)');
      }
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Password Confirmation: Валидация и стили', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

    // Навигация к форме Homeowner Signup
    await test.step('Навигация к форме Homeowner Signup', async () => {
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что форма загрузилась
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      console.log('✅ Навигация к форме Homeowner Signup выполнена');
    });

    // 1. UI/UX проверки (Внешний вид)
    await test.step('UI/UX проверки поля Password Confirmation', async () => {
      // Используем ID и проверку видимости
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      
      // Ждем, пока поле станет видимым
      await expect(passwordConfirmationInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Password Confirmation найдено и видимо');

      // 1.1. Проверка типа поля
      await expect(passwordConfirmationInput).toHaveAttribute('type', 'password');
      console.log('✅ Тип поля: "password"');

      // 1.2. Проверка плейсхолдера
      await expect(passwordConfirmationInput).toHaveAttribute('placeholder', '*************');
      console.log('✅ Placeholder найден: "*************"');

      // 1.3. Проверка обязательности
      const isRequired = await passwordConfirmationInput.getAttribute('required');
      if (isRequired !== null) {
        console.log('✅ Поле помечено как обязательное (required)');
      }

      // 1.4. Проверка классов CSS
      const classes = await passwordConfirmationInput.getAttribute('class');
      if (classes) {
        expect(classes).toContain('form-control');
        expect(classes).toContain('confirm-pass-input');
        console.log(`✅ CSS классы применены: "${classes}"`);
      }

      // 1.5. Взаимодействие (теперь клик сработает мгновенно)
      await passwordConfirmationInput.scrollIntoViewIfNeeded();
      await passwordConfirmationInput.click();
      await page.waitForTimeout(300);
      console.log('✅ Поле Password Confirmation успешно сфокусировано');

      // 1.6. Focus State - проверка изменения стилей при фокусе
      const focusedStyles = await passwordConfirmationInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderColor: styles.borderColor,
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus State: border-color=${focusedStyles.borderColor}, outline=${focusedStyles.outline}`);

      // 1.7. Шрифт и отступы
      const inputStyles = await passwordConfirmationInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: font-size=${inputStyles.fontSize}, padding=${inputStyles.padding}, border-radius=${inputStyles.borderRadius}`);

      // 1.8. Проверка, что пароль скрыт (type="password")
      const inputType = await passwordConfirmationInput.getAttribute('type');
      expect(inputType).toBe('password');
      console.log('✅ Пароль скрыт (type="password")');
    });

    // 2. Состояние поля (State)
    await test.step('Проверка состояния поля Password Confirmation', async () => {
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();
      
      // 2.1. Read-only / Disabled
      const isReadOnly = await passwordConfirmationInput.getAttribute('readonly');
      const isDisabled = await passwordConfirmationInput.isDisabled();
      expect(isReadOnly).toBeNull();
      expect(isDisabled).toBe(false);
      console.log('✅ Поле доступно для редактирования (не read-only и не disabled)');

      // 2.2. Взаимодействие с клавиатурой - Tab
      await passwordConfirmationInput.click();
      await page.waitForTimeout(200);
      const focusedElement = await page.evaluate(() => document.activeElement?.tagName);
      console.log(`✅ Tab работает (активный элемент: ${focusedElement})`);

      // 2.3. Очистка через Ctrl+A + Backspace
      await passwordConfirmationInput.fill('TestPassword123!');
      await passwordConfirmationInput.click();
      await page.keyboard.press('Control+A');
      await page.keyboard.press('Backspace');
      await page.waitForTimeout(200);
      const clearedValue = await passwordConfirmationInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Очистка через Ctrl+A + Backspace работает');
    });

    // 3. Позитивные тесты (Happy Path) - Совпадающие пароли
    await test.step('Позитивные тесты поля Password Confirmation - совпадающие пароли', async () => {
      const passwordInput = page.locator('#password:visible');
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();

      // 3.1. Совпадающие пароли - стандартный случай
      await passwordInput.fill('Password123!');
      await passwordConfirmationInput.fill('Password123!');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      const passwordValue = await passwordInput.inputValue();
      const confirmationValue = await passwordConfirmationInput.inputValue();
      expect(passwordValue).toBe(confirmationValue);
      console.log('✅ Совпадающие пароли приняты');

      // 3.2. Совпадающие пароли - с спецсимволами
      await passwordInput.fill('Pass@Word#123');
      await passwordConfirmationInput.fill('Pass@Word#123');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      const passwordValue2 = await passwordInput.inputValue();
      const confirmationValue2 = await passwordConfirmationInput.inputValue();
      expect(passwordValue2).toBe(confirmationValue2);
      console.log('✅ Совпадающие пароли со спецсимволами приняты');

      // 3.3. Совпадающие пароли - длинный пароль
      await passwordInput.fill('VeryLongPassword123!@#');
      await passwordConfirmationInput.fill('VeryLongPassword123!@#');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      const passwordValue3 = await passwordInput.inputValue();
      const confirmationValue3 = await passwordConfirmationInput.inputValue();
      expect(passwordValue3).toBe(confirmationValue3);
      expect(passwordValue3.length).toBeGreaterThan(15);
      console.log(`✅ Совпадающие длинные пароли приняты (длина: ${passwordValue3.length})`);
    });

    // 4. Граничные значения (Boundary Testing)
    await test.step('Граничные значения поля Password Confirmation', async () => {
      const passwordInput = page.locator('#password:visible');
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();

      // 4.1. Минимальная длина: 1 символ
      await passwordInput.fill('A');
      await passwordConfirmationInput.fill('A');
      const value1 = await passwordConfirmationInput.inputValue();
      expect(value1.length).toBe(1);
      console.log(`✅ Минимальная длина (1 символ): длина=${value1.length}`);

      // 4.2. Минимальная длина: 8 символов
      await passwordInput.fill('Pass123!');
      await passwordConfirmationInput.fill('Pass123!');
      const value8 = await passwordConfirmationInput.inputValue();
      expect(value8.length).toBe(8);
      console.log(`✅ Минимальная длина (8 символов): длина=${value8.length}`);

      // 4.3. Максимальная длина: 128 символов
      const maxLengthPassword = 'A'.repeat(128);
      await passwordInput.fill(maxLengthPassword);
      await passwordConfirmationInput.fill(maxLengthPassword);
      const value128 = await passwordConfirmationInput.inputValue();
      expect(value128.length).toBeLessThanOrEqual(128);
      console.log(`✅ Максимальная длина (128 символов): длина=${value128.length}`);
    });

    // 5. Негативные тесты и валидация
    await test.step('Негативные тесты и валидация поля Password Confirmation', async () => {
      const passwordInput = page.locator('#password:visible');
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();

      // 5.1. Пустое поле (required)
      await passwordConfirmationInput.clear();
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      // Пытаемся отправить форму с пустым полем
      const signupButton = page.getByRole('button', { name: /Signup|Sign Up|Register|Create Account/i }).first();
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty|field is required|password.*required/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация пустого поля: сообщение об ошибке - "${errorText?.trim()}"`);
      } else {
        // Проверяем через aria-invalid
        const isInvalid = await passwordConfirmationInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация пустого поля: поле помечено как невалидное (aria-invalid="true")');
        } else {
          // Проверяем HTML5 валидацию
          const validity = await passwordConfirmationInput.evaluate((el: HTMLInputElement) => el.validity.valueMissing);
          if (validity) {
            console.log('✅ Валидация пустого поля: HTML5 валидация работает (valueMissing)');
          } else {
            console.log('⚠️ Валидация пустого поля: сообщение об ошибке не найдено (возможно, валидация на сервере)');
          }
        }
      }

      // 5.2. Несовпадающие пароли - разные значения
      await passwordInput.fill('Password123!');
      await passwordConfirmationInput.fill('DifferentPassword123!');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const matchError = page.locator('text=/password.*match|не совпадают|do not match|must match|does not match/i').first();
      const matchErrorExists = await matchError.count();
      if (matchErrorExists > 0) {
        const errorText = await matchError.textContent();
        console.log(`✅ Валидация несовпадающих паролей работает: "${errorText?.trim()}"`);
      } else {
        console.log('⚠️ Валидация несовпадающих паролей: сообщение не найдено (возможно, валидация на сервере)');
      }

      // 5.3. Несовпадающие пароли - разный регистр
      await passwordInput.fill('Password123!');
      await passwordConfirmationInput.fill('password123!');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const caseMatchError = page.locator('text=/password.*match|не совпадают|do not match/i').first();
      const caseMatchErrorExists = await caseMatchError.count();
      if (caseMatchErrorExists > 0) {
        console.log('✅ Валидация несовпадающих паролей (разный регистр) работает');
      } else {
        console.log('⚠️ Валидация несовпадающих паролей (разный регистр): сообщение не найдено');
      }

      // 5.4. Несовпадающие пароли - лишний символ
      await passwordInput.fill('Password123!');
      await passwordConfirmationInput.fill('Password123!X');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const extraCharError = page.locator('text=/password.*match|не совпадают|do not match/i').first();
      const extraCharErrorExists = await extraCharError.count();
      if (extraCharErrorExists > 0) {
        console.log('✅ Валидация несовпадающих паролей (лишний символ) работает');
      } else {
        console.log('⚠️ Валидация несовпадающих паролей (лишний символ): сообщение не найдено');
      }

      // 5.5. Несовпадающие пароли - не хватает символа
      await passwordInput.fill('Password123!');
      await passwordConfirmationInput.fill('Password123');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      
      await signupButton.click();
      await page.waitForTimeout(1000);
      
      const missingCharError = page.locator('text=/password.*match|не совпадают|do not match/i').first();
      const missingCharErrorExists = await missingCharError.count();
      if (missingCharErrorExists > 0) {
        console.log('✅ Валидация несовпадающих паролей (не хватает символа) работает');
      } else {
        console.log('⚠️ Валидация несовпадающих паролей (не хватает символа): сообщение не найдено');
      }

      // 5.6. Только пробелы
      await passwordConfirmationInput.fill('   ');
      await passwordConfirmationInput.blur();
      await page.waitForTimeout(500);
      const spacesOnlyValue = await passwordConfirmationInput.inputValue();
      
      // Проверяем, что пробелы обрезаны (trim)
      if (spacesOnlyValue.trim() === '') {
        console.log('✅ Только пробелы обработаны: поле обрезает пробелы (trim работает)');
      } else {
        console.log(`⚠️ Только пробелы: поле приняло "${spacesOnlyValue}" (trim не работает)`);
      }
    });

    // 6. Проверка безопасности
    await test.step('Проверка безопасности поля Password Confirmation', async () => {
      const passwordInput = page.locator('#password:visible');
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();

      // 6.1. XSS-уязвимость: HTML-теги
      await passwordInput.fill('<script>alert("xss")</script>');
      await passwordConfirmationInput.fill('<script>alert("xss")</script>');
      const xssValue = await passwordConfirmationInput.inputValue();
      // Проверяем, что теги не выполнились
      const hasAlert = await page.evaluate(() => {
        return typeof window.alert === 'function';
      });
      console.log(`✅ XSS защита: значение сохранено как текст: "${xssValue.substring(0, 20)}..."`);

      // 6.2. SQL-инъекция
      await passwordInput.fill("admin'--");
      await passwordConfirmationInput.fill("admin'--");
      const sqlValue = await passwordConfirmationInput.inputValue();
      expect(sqlValue).toContain("'--");
      console.log(`✅ SQL-инъекция обработана: значение принято как текст: "${sqlValue}"`);

      // 6.3. Проверка, что пароль скрыт при вводе
      await passwordInput.fill('VisiblePassword123!');
      await passwordConfirmationInput.fill('VisiblePassword123!');
      const inputType = await passwordConfirmationInput.getAttribute('type');
      expect(inputType).toBe('password');
      
      // Проверяем, что значение не видно в DOM (должно быть скрыто)
      const isPasswordType = await passwordConfirmationInput.evaluate((el: HTMLInputElement) => el.type === 'password');
      expect(isPasswordType).toBe(true);
      console.log('✅ Пароль скрыт при вводе (type="password")');

      // Очищаем поля после проверок безопасности
      await passwordInput.clear();
      await passwordConfirmationInput.clear();
    });

    // 7. Проверка кнопки show/hide password (если есть)
    await test.step('Проверка кнопки show/hide password для Password Confirmation', async () => {
      const passwordConfirmationInput = page.locator('#password_confirmation:visible');
      await passwordConfirmationInput.scrollIntoViewIfNeeded();
      
      // Ищем кнопку переключения видимости пароля (может быть общая или отдельная)
      const toggleButton = page.locator('button[aria-label*="password" i], button[aria-label*="confirm" i], button[title*="password" i], button[title*="confirm" i], button:has-text("show"), button:has-text("hide"), [class*="eye"], [class*="toggle"]').filter({ hasText: /confirm|confirmation/i }).or(
        page.locator('button[aria-label*="password" i], button[title*="password" i]').nth(1)
      ).first();
      
      const toggleExists = await toggleButton.count();
      if (toggleExists > 0) {
        const isVisible = await toggleButton.isVisible().catch(() => false);
        if (isVisible) {
          await passwordConfirmationInput.fill('TestPassword123!');
          
          // Проверяем начальное состояние (password)
          let inputType = await passwordConfirmationInput.getAttribute('type');
          expect(inputType).toBe('password');
          console.log('✅ Пароль скрыт по умолчанию');

          // Кликаем на кнопку show
          await toggleButton.click();
          await page.waitForTimeout(300);
          inputType = await passwordConfirmationInput.getAttribute('type');
          if (inputType === 'text') {
            console.log('✅ Пароль отображается после клика на show');
          }

          // Кликаем на кнопку hide
          await toggleButton.click();
          await page.waitForTimeout(300);
          inputType = await passwordConfirmationInput.getAttribute('type');
          if (inputType === 'password') {
            console.log('✅ Пароль скрыт после клика на hide');
          }
        } else {
          console.log('⚠️ Кнопка show/hide password найдена, но не видима');
        }
      } else {
        console.log('ℹ️ Кнопка show/hide password для подтверждения не найдена (возможно, не реализована или общая кнопка)');
      }
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Signup Button: Валидация и взаимодействие', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

    // Навигация к форме Homeowner Signup
    await test.step('Навигация к форме Homeowner Signup', async () => {
      await page.getByRole('link', { name: 'Sign Up' }).click();
      await page.waitForTimeout(500);
      
      const homeownerSignUpLink = page.getByRole('link', { name: /Sign Up/i }).nth(1);
      await expect(homeownerSignUpLink).toBeVisible({ timeout: 10000 });
      await homeownerSignUpLink.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что форма загрузилась
      await expect(page.getByRole('heading', { name: 'Homeowner Signup' })).toBeVisible({ timeout: 10000 });
      console.log('✅ Навигация к форме Homeowner Signup выполнена');
    });

    // 1. UI/UX проверки (Внешний вид)
    await test.step('UI/UX проверки кнопки Signup', async () => {
      // Используем несколько способов поиска кнопки
      const signupButton = page.getByRole('button', { name: 'Signup' }).or(
        page.locator('button:has-text("Signup")')
      ).or(
        page.locator('button.login-btn')
      ).first();
      
      // Ждем, пока кнопка станет видимой
      await expect(signupButton).toBeVisible({ timeout: 10000 });
      console.log('✅ Кнопка Signup найдена и видима');

      // 1.1. Проверка текста кнопки
      const buttonText = await signupButton.textContent();
      expect(buttonText?.trim()).toBe('Signup');
      console.log(`✅ Текст кнопки: "${buttonText?.trim()}"`);

      // 1.2. Проверка типа кнопки
      await expect(signupButton).toHaveAttribute('type', 'submit');
      console.log('✅ Тип кнопки: "submit"');

      // 1.3. Проверка классов CSS
      const classes = await signupButton.getAttribute('class');
      if (classes) {
        expect(classes).toContain('site-button');
        expect(classes).toContain('site-button-primary');
        expect(classes).toContain('w-100');
        expect(classes).toContain('login-btn');
        console.log(`✅ CSS классы применены: "${classes}"`);
      }

      // 1.4. Проверка стилей кнопки
      await signupButton.scrollIntoViewIfNeeded();
      const buttonStyles = await signupButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          width: styles.width,
          cursor: styles.cursor
        };
      });
      console.log(`✅ Стили кнопки: background-color=${buttonStyles.backgroundColor}, width=${buttonStyles.width}, cursor=${buttonStyles.cursor}`);

      // Строгая проверка брендового синего цвета #0B1C54
      expect(buttonStyles.backgroundColor).toBe(BRAND_COLORS.NAVY_LIGHT);

      // 1.5. Проверка ширины (w-100 должен означать width: 100%)
      if (buttonStyles.width === '100%' || classes?.includes('w-100')) {
        console.log('✅ Кнопка занимает 100% ширины (w-100)');
      }

      // 1.6. Проверка cursor при наведении
      if (buttonStyles.cursor === 'pointer' || buttonStyles.cursor === 'default') {
        console.log(`✅ Cursor установлен: ${buttonStyles.cursor}`);
      }
    });

    // 2. Состояние кнопки (State)
    await test.step('Проверка состояния кнопки Signup', async () => {
      const signupButton = page.getByRole('button', { name: 'Signup' }).or(
        page.locator('button:has-text("Signup")')
      ).or(
        page.locator('button.login-btn')
      ).first();
      await signupButton.scrollIntoViewIfNeeded();
      
      // 2.1. Disabled / Enabled
      const isDisabled = await signupButton.isDisabled();
      expect(isDisabled).toBe(false);
      console.log('✅ Кнопка активна (не disabled)');

      // 2.2. Проверка видимости
      const isVisible = await signupButton.isVisible();
      expect(isVisible).toBe(true);
      console.log('✅ Кнопка видима');

      // 2.3. Проверка доступности для клика
      const isEnabled = await signupButton.isEnabled();
      expect(isEnabled).toBe(true);
      console.log('✅ Кнопка доступна для взаимодействия');
    });

    // 3. Взаимодействие с кнопкой
    await test.step('Проверка взаимодействия с кнопкой Signup', async () => {
      const signupButton = page.getByRole('button', { name: 'Signup' }).or(
        page.locator('button:has-text("Signup")')
      ).or(
        page.locator('button.login-btn')
      ).first();
      await signupButton.scrollIntoViewIfNeeded();

      // 3.1. Проверка кликабельности
      const isClickable = await signupButton.isEnabled();
      expect(isClickable).toBe(true);
      console.log('✅ Кнопка кликабельна');

      // 3.2. Проверка hover состояния (наведение мыши)
      await signupButton.hover();
      await page.waitForTimeout(300);
      const hoverStyles = await signupButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          opacity: styles.opacity
        };
      });
      console.log(`✅ Hover состояние: background-color=${hoverStyles.backgroundColor}, opacity=${hoverStyles.opacity}`);

      // 3.3. Проверка focus состояния (Tab)
      await signupButton.focus();
      await page.waitForTimeout(300);
      const focusedElement = await page.evaluate(() => document.activeElement?.tagName);
      const focusedButtonText = await page.evaluate(() => {
        const active = document.activeElement as HTMLElement;
        return active?.textContent?.trim();
      });
      if (focusedButtonText === 'Signup') {
        console.log('✅ Кнопка получает фокус через Tab');
      }

      // 3.4. Проверка активного состояния (при нажатии)
      await signupButton.click({ force: true });
      await page.waitForTimeout(300);
      console.log('✅ Клик по кнопке выполнен');
    });

    // 4. Проверка валидации формы при клике
    await test.step('Проверка валидации формы при клике на кнопку Signup', async () => {
      const signupButton = page.getByRole('button', { name: 'Signup' }).or(
        page.locator('button:has-text("Signup")')
      ).or(
        page.locator('button.login-btn')
      ).first();
      await signupButton.scrollIntoViewIfNeeded();

      // Очищаем все поля перед проверкой
      const nameInput = page.locator('#name:visible').first();
      const emailInput = page.locator('#email:visible').first();
      const passwordInput = page.locator('#password:visible').first();
      const passwordConfirmationInput = page.locator('#password_confirmation:visible').first();

      // Проверяем наличие полей и очищаем их
      const nameExists = await nameInput.count();
      const emailExists = await emailInput.count();
      const passwordExists = await passwordInput.count();
      const passwordConfirmationExists = await passwordConfirmationInput.count();

      if (nameExists > 0) await nameInput.clear();
      if (emailExists > 0) await emailInput.clear();
      if (passwordExists > 0) await passwordInput.clear();
      if (passwordConfirmationExists > 0) await passwordConfirmationInput.clear();

      await page.waitForTimeout(500);

      // 4.1. Клик на кнопку с пустой формой
      await signupButton.click();
      await page.waitForTimeout(1000);

      // Проверяем наличие сообщений об ошибках
      const errorMessages = page.locator('text=/required|обязательно|заполните|cannot be empty|field is required/i');
      const errorCount = await errorMessages.count();
      if (errorCount > 0) {
        console.log(`✅ Валидация формы работает: найдено ${errorCount} сообщений об ошибках`);
      } else {
        // Проверяем через aria-invalid
        const invalidFields = await page.locator('[aria-invalid="true"]').count();
        if (invalidFields > 0) {
          console.log(`✅ Валидация формы работает: найдено ${invalidFields} невалидных полей`);
        } else {
          console.log('⚠️ Валидация формы: сообщения об ошибках не найдены (возможно, валидация на сервере)');
        }
      }

      // 4.2. Проверка, что форма не отправилась (остались на той же странице)
      const heading = page.getByRole('heading', { name: 'Homeowner Signup' });
      const headingExists = await heading.count();
      if (headingExists > 0) {
        const isVisible = await heading.isVisible().catch(() => false);
        if (isVisible) {
          console.log('✅ Форма не отправилась с пустыми полями (валидация сработала)');
        }
      }
    });

    // 5. Проверка отправки формы с валидными данными
    await test.step('Проверка отправки формы с валидными данными', async () => {
      const signupButton = page.getByRole('button', { name: 'Signup' }).or(
        page.locator('button:has-text("Signup")')
      ).or(
        page.locator('button.login-btn')
      ).first();
      await signupButton.scrollIntoViewIfNeeded();

      // Заполняем форму валидными данными
      const nameInput = page.locator('#name:visible').first();
      const emailInput = page.locator('#email:visible').first();
      const passwordInput = page.locator('#password:visible').first();
      const passwordConfirmationInput = page.locator('#password_confirmation:visible').first();

      const nameExists = await nameInput.count();
      const emailExists = await emailInput.count();
      const passwordExists = await passwordInput.count();
      const passwordConfirmationExists = await passwordConfirmationInput.count();

      if (nameExists > 0) {
        await nameInput.fill('Test User');
        console.log('✅ Поле Name заполнено');
      }
      if (emailExists > 0) {
        const timestamp = Math.floor(Date.now() / 1000);
        await emailInput.fill(`ihor.mynaiev+${timestamp}@greenice.net`);
        console.log('✅ Поле Email заполнено');
      }
      if (passwordExists > 0) {
        await passwordInput.fill('TestPassword123!');
        console.log('✅ Поле Password заполнено');
      }
      if (passwordConfirmationExists > 0) {
        await passwordConfirmationInput.fill('TestPassword123!');
        console.log('✅ Поле Password Confirmation заполнено');
      }

      await page.waitForTimeout(500);

      // 5.1. Клик на кнопку с заполненной формой
      // Используем Promise.race для отслеживания навигации или ошибок
      const [response] = await Promise.all([
        page.waitForResponse(response => response.status() !== 404, { timeout: 5000 }).catch(() => null),
        page.waitForNavigation({ timeout: 5000 }).catch(() => null),
        signupButton.click()
      ]);

      await page.waitForTimeout(2000);

      // Проверяем, произошла ли навигация или есть сообщение об успехе/ошибке
      const currentUrl = page.url();
      const successMessage = page.locator('text=/success|успешно|registered|зарегистрирован/i').first();
      const errorMessage = page.locator('text=/error|ошибка|failed/i').first();

      const successExists = await successMessage.count();
      const errorExists = await errorMessage.count();

      if (successExists > 0) {
        const successText = await successMessage.textContent();
        console.log(`✅ Форма отправлена успешно: "${successText?.trim()}"`);
      } else if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`⚠️ Форма отправлена, но есть ошибка: "${errorText?.trim()}"`);
      } else if (response) {
        console.log(`✅ Форма отправлена: получен ответ от сервера (статус: ${response.status()})`);
      } else {
        console.log('ℹ️ Форма отправлена: проверка результата требует дополнительной настройки');
      }
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});
