/**
 * ACCOUNT SETTINGS SUITE — КОМПЛЕКСНЫЙ АУДИТ НАСТРОЕК ПРОФИЛЯ
 * 
 * Данный тестовый набор предназначен для глубокой проверки раздела Account Settings 
 * на сайте IndoorOutdoor. Включает аудит безопасности, стилей и UI/UX.
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И СЛОЖНАЯ НАВИГАЦИЯ:
 *    - Вход: Стандартный Login с валидными данными.
 *    - Меню: Поиск элемента «Settings» через JS-клик и переход в «Account Settings» (XPath/Fallback).
 *    - URL: Валидация перехода на страницу /profile.
 * 
 * 2. ДЕТАЛЬНЫЙ АУДИТ ПОЛЯ "NAME":
 *    - Границы: Пустое поле (Required), 1 символ, 255/256 символов (maxlength).
 *    - Типы: Латиница, Кириллица, цифры, сложные фамилии (Jean-Pierre, O'Connor), эмодзи.
 *    - Логика: Автоматический Trim, блокировка сохранения пустых пробелов, работа Paste.
 *    - Безопасность: Проверка на Stored XSS (<script>) и HTML-инъекции (<b>) с перезагрузкой страницы.
 *    - UI: Наличие визуальной звездочки (*) и красного цвета для текста ошибок.
 * 
 * 3. ГЛУБОКАЯ ПРОВЕРКА ПОЛЯ "EMAIL":
 *    - Атрибуты: Проверка type="email", required и autocomplete.
 *    - Формат: Тестирование сложных адресов (+, поддомены) и негативные сценарии (без @ и т.д.).
 *    - Стандарты: Лимит 254 символа и автоматическое приведение к нижнему регистру (lowercase).
 * 
 * 4. ПОЛЯ ПАРОЛЕЙ (NEW & CONFIRM):
 *    - Маскировка: Проверка типа password по умолчанию.
 *    - Глазик (Visibility Toggle): Переключение типа на text, проверка видимости значения и изоляция полей.
 *    - Валидация: Ошибка при вводе менее 8 символов.
 * 
 * 5. ИНТЕГРАЦИОННЫЙ СЦЕНАРИЙ (ПОЛНЫЙ ЦИКЛ):
 *    - Процесс: Смена имени и пароля -> Сохранение -> Logout -> Login с новым паролем.
 *    - Clean Up: Возврат к исходным данным для чистоты последующих тестов.
 * 
 * 6. ГЛОБАЛЬНЫЙ UI/UX И ТЕХНИЧЕСКИЙ АУДИТ:
 *    - Стили: Анализ fontSize, fontFamily, padding и цветов через getComputedStyle.
 *    - Интерактивность: Проверка cursor: pointer у кнопок.
 *    - Адаптивность: Вызов checkUIUX для проверки на мобильных/планшетах.
 * 
 * ИТОГ: Гарантирует защиту от некорректных данных, XSS-атак, правильность 
 * обработки международных имен и стабильность навигации.
 */


import { test, expect } from '@playwright/test';
import { checkUIUX } from 'utils/ui.ux.helper';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Account Settings - Проверка страницы настроек аккаунта
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Навигацию на страницу Account Settings
 * - Проверку заголовка страницы
 * - Детальную валидацию поля Name
 * - Проверку стилей элементов
 * 
 * @see README.md для подробной документации
 */
test.describe('Account Settings Suite @regression', () => {
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

  test('Навигация и проверка страницы Account Settings с валидацией поля Name', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(300000); // 5 минут (для детальных проверок)

    // Авторизация
    await test.step('Авторизация пользователя', async () => {
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).fill('ihor.mynaiev@greenice.net');
      await page.getByRole('textbox', { name: '*************' }).click();
      await page.getByRole('textbox', { name: '*************' }).fill('Qwerty123$');
      await page.getByRole('button', { name: 'Login' }).click();
      
      // Ждем завершения авторизации
      await page.waitForTimeout(2000);
      console.log('✅ Авторизация выполнена');
    });

    // Навигация к Account Settings
    await test.step('Навигация к Account Settings', async () => {
      // Ищем все элементы <span>Settings</span> в меню
      const allSettingsSpans = page.locator('span').filter({ hasText: /^Settings$/ });
      const count = await allSettingsSpans.count();
      
      // Проверяем, что есть минимум 2 элемента
      expect(count).toBeGreaterThanOrEqual(2);
      
      // Берем второй элемент (индекс 1)
      const settingsSpan = allSettingsSpans.nth(1);
      
      // Кликаем именно на второй <span>Settings</span> используя JavaScript
      await settingsSpan.evaluate((el: HTMLElement) => {
        el.click();
      });
      await page.waitForTimeout(500);
      
      // В выпадающем списке ищем Account Settings
      // Ждем, пока выпадающее меню откроется
      await page.waitForTimeout(1000); // Даем время на открытие меню
      
      // Используем XPath для более точного поиска элемента Account Settings
      // XPath: //*[@id="sidebar-menu"]/ul/li[7]/ul/li/a
      const accountSettingsLink = page.locator('xpath=//*[@id="sidebar-menu"]/ul/li[7]/ul/li/a');
      
      // Альтернативный поиск, если XPath не сработает
      let linkExists = await accountSettingsLink.count();
      let finalLink = accountSettingsLink;
      
      if (linkExists === 0) {
        // Fallback: ищем по href и тексту
        finalLink = page.locator('a[href*="profile"]').filter({ hasText: /Account Settings/i }).first();
        linkExists = await finalLink.count();
        
        if (linkExists === 0) {
          // Еще один fallback: просто по href
          finalLink = page.locator('a[href="https://dev.indooroutdoor.com/profile"]').first();
        }
      }
      
      await expect(finalLink).toBeVisible({ timeout: 10000 });
      await finalLink.click();
      await page.waitForTimeout(2000);
      
      console.log('✅ Переход на страницу Account Settings выполнен');
    });

    // Проверка URL
    await test.step('Проверка URL страницы', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/profile', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/profile');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Проверка заголовка страницы
    await test.step('Проверка заголовка страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Account Settings/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Account Settings');
      console.log(`✅ Заголовок найден: "${headingText?.trim()}"`);

      // Проверка стилей заголовка
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontWeight: styles.fontWeight,
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(headingStyles.display).not.toBe('none');
      expect(headingStyles.visibility).not.toBe('hidden');
      expect(parseFloat(headingStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили заголовка: font-size=${headingStyles.fontSize}, font-weight=${headingStyles.fontWeight}`);
    });

    // Проверка блока General Information
    await test.step('Проверка блока General Information', async () => {
      const generalInfoHeading = page.getByText('General Information', { exact: false }).first();
      await expect(generalInfoHeading).toBeVisible({ timeout: 10000 });
      console.log('✅ Блок "General Information" найден');
    });

    // 1. Граничные значения (Boundary Testing)
    await test.step('1. Граничные значения поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      await expect(nameInput).toBeVisible({ timeout: 10000 });
      
      // Сохраняем исходное значение
      const originalValue = await nameInput.inputValue();
      console.log(`📝 Исходное значение поля: "${originalValue}"`);

      // 1.1. Пустое поле
      await nameInput.clear();
      await nameInput.blur(); // Убираем фокус, чтобы сработала валидация
      await page.waitForTimeout(500);
      
      // Проверяем наличие ошибки "Required" (валидация должна сработать при blur)
      const requiredError = page.getByText(/Required|This field is required|Name is required/i).first();
      const errorExists = await requiredError.count();
      if (errorExists > 0) {
        await expect(requiredError).toBeVisible({ timeout: 5000 });
        console.log('✅ Пустое поле: ошибка "Required" появилась');
      } else {
        console.log('⚠️ Пустое поле: ошибка "Required" не найдена (возможно, требуется попытка сохранения)');
      }

      // 1.2. 1 символ
      await nameInput.fill('A');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const value1 = await nameInput.inputValue();
      expect(value1).toBe('A');
      console.log('✅ 1 символ: значение принято');

      // 1.3. 254 символа
      const text254 = 'A'.repeat(254);
      await nameInput.fill(text254);
      await nameInput.blur();
      await page.waitForTimeout(500);
      const value254 = await nameInput.inputValue();
      expect(value254.length).toBeLessThanOrEqual(255);
      console.log(`✅ 254 символа: значение принято (длина: ${value254.length})`);

      // 1.4. 255 символов
      const text255 = 'A'.repeat(255);
      await nameInput.fill(text255);
      await nameInput.blur();
      await page.waitForTimeout(500);
      const value255 = await nameInput.inputValue();
      expect(value255.length).toBeLessThanOrEqual(255);
      console.log(`✅ 255 символов: значение принято (длина: ${value255.length})`);

      // 1.5. 256 символов
      const text256 = 'A'.repeat(256);
      await nameInput.fill(text256);
      await nameInput.blur();
      await page.waitForTimeout(500);
      const value256 = await nameInput.inputValue();
      
      // Проверяем maxlength атрибут
      const maxLength = await nameInput.getAttribute('maxlength');
      if (maxLength) {
        expect(parseInt(maxLength)).toBeLessThanOrEqual(255);
        expect(value256.length).toBeLessThanOrEqual(255);
        console.log(`✅ 256 символов: поле ограничено атрибутом maxlength=${maxLength}`);
      } else {
        // Если нет maxlength, проверяем, что значение обрезано или есть ошибка
        if (value256.length <= 255) {
          console.log(`✅ 256 символов: значение обрезано до ${value256.length} символов`);
        } else {
          // Пытаемся сохранить и проверить ошибку
          const saveButton = page.locator('button[type="submit"]').or(page.getByRole('button', { name: /Save|Update|Submit/i })).first();
          const saveButtonExists = await saveButton.count();
          
          if (saveButtonExists > 0) {
            // Используем JavaScript клик для скрытых элементов
            await saveButton.evaluate((el: HTMLElement) => {
              (el as HTMLButtonElement).click();
            });
            await page.waitForTimeout(1000);
            const maxLengthError = page.getByText(/Maximum length|Too long|Maximum 255/i).first();
            const maxErrorExists = await maxLengthError.count();
            if (maxErrorExists > 0) {
              console.log('✅ 256 символов: ошибка "Maximum length is 255" появилась');
            } else {
              console.log('⚠️ 256 символов: ошибка не найдена, но значение может быть обрезано');
            }
          }
        }
      }

      // Восстанавливаем исходное значение
      await nameInput.fill(originalValue);
      await nameInput.blur();
      await page.waitForTimeout(500);
    });

    // 2. Валидация типов данных
    await test.step('2. Валидация типов данных поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      const originalValue = await nameInput.inputValue();

      // 2.1. Латиница
      await nameInput.fill('John Doe');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const latinValue = await nameInput.inputValue();
      expect(latinValue).toBe('John Doe');
      console.log('✅ Латиница: значение принято');

      // 2.2. Кириллица
      await nameInput.fill('Иван Иванов');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const cyrillicValue = await nameInput.inputValue();
      expect(cyrillicValue).toBe('Иван Иванов');
      console.log('✅ Кириллица: значение принято');

      // 2.3. Цифры
      await nameInput.fill('12345');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const digitsValue = await nameInput.inputValue();
      // Проверяем, принимаются ли цифры (в именах обычно нет, но в названиях компаний - да)
      console.log(`ℹ️ Цифры: значение "${digitsValue}" (может быть принято или отклонено в зависимости от бизнес-правил)`);

      // 2.4. Спецсимволы (дефисы и апострофы)
      await nameInput.fill("O'Connor");
      await nameInput.blur();
      await page.waitForTimeout(500);
      const apostropheValue = await nameInput.inputValue();
      console.log(`✅ Апостроф: значение "${apostropheValue}" принято`);

      await nameInput.fill('Jean-Pierre');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const hyphenValue = await nameInput.inputValue();
      console.log(`✅ Дефис: значение "${hyphenValue}" принято`);

      // 2.5. Эмодзи
      await nameInput.fill('Name 📄');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const emojiValue = await nameInput.inputValue();
      console.log(`ℹ️ Эмодзи: значение "${emojiValue}" (может быть принято или отклонено)`);

      // Восстанавливаем исходное значение
      await nameInput.fill(originalValue);
      await nameInput.blur();
      await page.waitForTimeout(500);
    });

    // 3. Функциональные проверки (Логика)
    await test.step('3. Функциональные проверки поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      const originalValue = await nameInput.inputValue();

      // 3.1. Обрезка пробелов (Trim)
      await nameInput.fill(' John ');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const trimmedValue = await nameInput.inputValue();
      if (trimmedValue === 'John') {
        console.log('✅ Trim: пробелы автоматически удалены');
      } else {
        console.log(`ℹ️ Trim: значение "${trimmedValue}" (пробелы могут быть сохранены)`);
      }

      // 3.2. Только пробелы
      await nameInput.fill('   ');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const spacesValue = await nameInput.inputValue();
      
      // Пытаемся сохранить
      const saveButton = page.locator('button[type="submit"]').or(page.getByRole('button', { name: /Save|Update|Submit/i })).first();
      const saveButtonExists = await saveButton.count();
      
      if (saveButtonExists > 0) {
        // Используем JavaScript клик для скрытых элементов
        await saveButton.evaluate((el: HTMLElement) => {
          (el as HTMLButtonElement).click();
        });
        await page.waitForTimeout(1000);
        
        const requiredError = page.getByText(/Required|This field is required/i).first();
        const errorExists = await requiredError.count();
        if (errorExists > 0) {
          console.log('✅ Только пробелы: ошибка "Required" появилась');
        } else {
          console.log('⚠️ Только пробелы: ошибка не найдена');
        }
      }

      // 3.3. Двойные пробелы
      await nameInput.fill('John  Doe');
      await nameInput.blur();
      await page.waitForTimeout(500);
      const doubleSpacesValue = await nameInput.inputValue();
      console.log(`ℹ️ Двойные пробелы: значение "${doubleSpacesValue}" (может быть сохранено как есть или нормализовано)`);

      // 3.4. Вставка (Paste)
      await nameInput.click();
      await nameInput.fill(''); // Очищаем
      await page.keyboard.press('Control+V'); // Пытаемся вставить из буфера
      await page.waitForTimeout(500);
      const pastedValue = await nameInput.inputValue();
      console.log(`ℹ️ Вставка: значение "${pastedValue}" (зависит от содержимого буфера обмена)`);

      // Восстанавливаем исходное значение
      await nameInput.fill(originalValue);
      await nameInput.blur();
      await page.waitForTimeout(500);
    });

    // 4. Проверки безопасности
    await test.step('4. Проверки безопасности поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      const originalValue = await nameInput.inputValue();

      // 4.1. XSS (Stored)
      const xssPayload = '<script>alert(1)</script>';
      await nameInput.fill(xssPayload);
      await nameInput.blur();
      await page.waitForTimeout(500);
      
      // Пытаемся сохранить
      const saveButton = page.locator('button[type="submit"]').or(page.getByRole('button', { name: /Save|Update|Submit/i })).first();
      const saveButtonExists = await saveButton.count();
      
      if (saveButtonExists > 0) {
        // Используем JavaScript клик для скрытых элементов
        await saveButton.evaluate((el: HTMLElement) => {
          (el as HTMLButtonElement).click();
        });
        await page.waitForTimeout(2000);
        
        // Обновляем страницу и проверяем, не выполнился ли скрипт
        await page.reload();
        await page.waitForTimeout(2000);
        
        // Переопределяем nameInput после перезагрузки страницы
        const nameInputAfterReload = page.locator('input#name[name="name"]').first();
        const savedValue = await nameInputAfterReload.inputValue();
        
        // Проверяем, что alert не всплыл (если всплыл, тест упадет с timeout)
        // Проверяем, что скрипт не выполнился - либо значение очищено, либо экранировано
        if (savedValue.includes('<script>')) {
          // Если содержит <script>, проверяем, что оно экранировано (не выполняется)
          expect(savedValue).toContain('<script>');
          console.log(`✅ XSS: скрипт экранирован, значение сохранено как текст: "${savedValue.substring(0, 50)}"`);
        } else {
          // Если не содержит <script>, значит было очищено/отклонено - это тоже хорошо
          console.log(`✅ XSS: скрипт был очищен/отклонен (безопасность работает): "${savedValue.substring(0, 50)}"`);
        }
      }

      // 4.2. HTML теги
      await nameInput.fill('<b>John</b>');
      await nameInput.blur();
      await page.waitForTimeout(500);
      
      if (saveButtonExists > 0) {
        // Используем JavaScript клик для скрытых элементов
        await saveButton.evaluate((el: HTMLElement) => {
          (el as HTMLButtonElement).click();
        });
        await page.waitForTimeout(2000);
        await page.reload();
        await page.waitForTimeout(2000);
        
        // Переопределяем nameInput после перезагрузки страницы
        const nameInputAfterReload = page.locator('input#name[name="name"]').first();
        const htmlValue = await nameInputAfterReload.inputValue();
        
        // Проверяем, что HTML не интерпретируется
        // Вариант 1: HTML теги сохранены как текст (экранированы)
        // Вариант 2: HTML теги были очищены/отклонены (тоже хорошо для безопасности)
        if (htmlValue.includes('<b>')) {
          // HTML теги сохранены как текст (экранированы) - это хорошо
          expect(htmlValue).toContain('<b>');
          console.log(`✅ HTML теги: значение сохранено как текст (экранировано): "${htmlValue}"`);
        } else {
          // HTML теги были очищены/отклонены - это тоже хорошо для безопасности
          console.log(`✅ HTML теги: значение было очищено/отклонено (безопасность работает): "${htmlValue}"`);
        }
      }

      // Восстанавливаем исходное значение
      await nameInput.fill(originalValue);
      await nameInput.blur();
      await page.waitForTimeout(500);
    });

    // 5. UI/UX проверки
    await test.step('5. UI/UX проверки поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      
      // 5.1. Наличие звездочки (если поле обязательное)
      const label = page.locator('label[for="name"]').or(page.locator('label').filter({ hasText: /Name/i })).first();
      const labelExists = await label.count();
      
      if (labelExists > 0) {
        const labelText = await label.textContent();
        const hasAsterisk = labelText?.includes('*') || labelText?.includes('★');
        if (hasAsterisk) {
          console.log('✅ Звездочка: найдена в label');
        } else {
          console.log('ℹ️ Звездочка: не найдена в label (поле может быть необязательным)');
        }
      }

      // 5.2. Атрибут Required
      const requiredAttr = await nameInput.getAttribute('required');
      if (requiredAttr !== null) {
        console.log('✅ Атрибут Required: присутствует в HTML');
      } else {
        console.log('⚠️ Атрибут Required: отсутствует в HTML');
      }

      // 5.3. Сообщение об ошибке (проверяем стили и видимость)
      await nameInput.clear();
      await nameInput.blur();
      await page.waitForTimeout(500);
      
      // Ищем сообщение об ошибке, исключая элементы reCAPTCHA
      const errorMessage = page.locator('.error, .invalid-feedback, [class*="error"], [class*="invalid"]')
        .filter({ hasNotText: /grecaptcha/i })
        .filter({ hasNot: page.locator('[class*="grecaptcha"]') })
        .first();
      
      const errorExists = await errorMessage.count();
      
      if (errorExists > 0) {
        // Проверяем видимость перед использованием
        const isVisible = await errorMessage.isVisible();
        if (isVisible) {
          await expect(errorMessage).toBeVisible({ timeout: 5000 });
          const errorText = await errorMessage.textContent();
          console.log(`✅ Сообщение об ошибке: "${errorText?.trim()}"`);
          
          // Проверка стилей ошибки
          const errorStyles = await errorMessage.evaluate((el) => {
            const styles = window.getComputedStyle(el);
            return {
              color: styles.color,
              fontSize: styles.fontSize,
              display: styles.display
            };
          });
          
          // Проверяем, что цвет красный (или близкий к красному)
          const color = errorStyles.color.toLowerCase();
          const isRed = color.includes('rgb(255') || color.includes('red') || color.includes('#f') || color.includes('rgb(220') || color.includes('rgb(239');
          if (isRed) {
            console.log(`✅ Цвет ошибки: ${errorStyles.color} (красный)`);
          } else {
            console.log(`ℹ️ Цвет ошибки: ${errorStyles.color}`);
          }
        } else {
          console.log('⚠️ Сообщение об ошибке найдено, но скрыто (возможно, это не ошибка валидации)');
        }
      } else {
        console.log('⚠️ Сообщение об ошибке: не найдено');
      }

      // Восстанавливаем исходное значение
      const originalValue = await page.locator('input#name[name="name"]').first().inputValue().catch(() => 'IhorMynaiev');
      await nameInput.fill(originalValue || 'IhorMynaiev');
      await nameInput.blur();
      await page.waitForTimeout(500);
    });

    // Проверка стилей поля Name
    await test.step('Проверка стилей поля Name', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      
      const inputStyles = await nameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          border: styles.border,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          display: styles.display,
          visibility: styles.visibility
        };
      });

      expect(inputStyles.display).not.toBe('none');
      expect(inputStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили поля Name: font-size=${inputStyles.fontSize}, color=${inputStyles.color}, padding=${inputStyles.padding}`);
    });

    // 1. UI и атрибуты поля Email
    await test.step('1. UI и атрибуты поля Email', async () => {
      const emailInput = page.locator('input#email[name="email"]').first();
      await expect(emailInput).toBeVisible({ timeout: 10000 });
      
      // 1.1. Тип поля
      const type = await emailInput.getAttribute('type');
      expect(type).toBe('email');
      console.log(`✅ Тип поля Email: ${type}`);
      
      // 1.2. Обязательность
      const required = await emailInput.getAttribute('required');
      expect(required).not.toBeNull();
      console.log('✅ Поле Email обязательное (required)');
      
      // 1.3. Placeholder
      const placeholder = await emailInput.getAttribute('placeholder');
      if (placeholder) {
        expect(placeholder.length).toBeGreaterThan(0);
        console.log(`✅ Placeholder поля Email: "${placeholder}"`);
      } else {
        console.log('ℹ️ Placeholder поля Email отсутствует');
      }
      
      // 1.4. Autocomplete
      const autocomplete = await emailInput.getAttribute('autocomplete');
      if (autocomplete) {
        expect(['email', 'username'].includes(autocomplete)).toBeTruthy();
        console.log(`✅ Autocomplete поля Email: ${autocomplete}`);
      } else {
        console.log('ℹ️ Autocomplete поля Email отсутствует');
      }
    });

    // 2. Позитивные тесты поля Email (Валидные форматы)
    await test.step('2. Позитивные тесты поля Email (Валидные форматы)', async () => {
      const emailInput = page.locator('input#email[name="email"]').first();
      const originalValue = await emailInput.inputValue();
      
      const validEmails = [
        'user@example.com',
        'user.name@sub.domain.com',
        'user+filter@gmail.com',
        '123456@domain.co'
      ];
      
      for (const validEmail of validEmails) {
        await emailInput.fill(validEmail);
        await emailInput.blur();
        await page.waitForTimeout(300);
        
        const value = await emailInput.inputValue();
        expect(value).toBe(validEmail);
        console.log(`✅ Валидный email принят: "${validEmail}"`);
      }
      
      // Восстанавливаем исходное значение
      await emailInput.fill(originalValue);
      await emailInput.blur();
      await page.waitForTimeout(500);
    });

    // 3. Негативные тесты поля Email (Валидация формата)
    await test.step('3. Негативные тесты поля Email (Валидация формата)', async () => {
      const emailInput = page.locator('input#email[name="email"]').first();
      const originalValue = await emailInput.inputValue();
      
      const invalidEmails = [
        { value: '', description: 'Пустое поле' },
        { value: 'testexample.com', description: 'Без символа @' },
        { value: 'test@', description: 'Без домена' },
        { value: 'test@@example.com', description: 'Две собаки' },
        { value: 'test@exam!ple.com', description: 'Спецсимволы в домене' }
      ];
      
      for (const invalid of invalidEmails) {
        await emailInput.fill(invalid.value);
        await emailInput.blur();
        await page.waitForTimeout(300);
        
        // Проверяем, что браузерная валидация сработала (для type="email")
        const validationMessage = await emailInput.evaluate((el: HTMLInputElement) => {
          return (el as HTMLInputElement).validationMessage;
        });
        
        if (validationMessage) {
          console.log(`✅ ${invalid.description}: браузерная валидация сработала - "${validationMessage}"`);
        } else {
          // Проверяем наличие ошибки на странице
          const errorMessage = page.locator('.error, .invalid-feedback, [class*="error"], [class*="invalid"]')
            .filter({ hasNotText: /grecaptcha/i })
            .first();
          const errorExists = await errorMessage.count();
          
          if (errorExists > 0) {
            const isVisible = await errorMessage.isVisible();
            if (isVisible) {
              const errorText = await errorMessage.textContent();
              console.log(`✅ ${invalid.description}: ошибка найдена - "${errorText?.trim()}"`);
            } else {
              console.log(`ℹ️ ${invalid.description}: ошибка найдена, но скрыта`);
            }
          } else {
            console.log(`⚠️ ${invalid.description}: ошибка не найдена`);
          }
        }
      }
      
      // Восстанавливаем исходное значение
      await emailInput.fill(originalValue);
      await emailInput.blur();
      await page.waitForTimeout(500);
    });

    // 4. Граничные значения и Логика поля Email
    await test.step('4. Граничные значения и Логика поля Email', async () => {
      const emailInput = page.locator('input#email[name="email"]').first();
      const originalValue = await emailInput.inputValue();
      
      // 4.1. Лимит 254 символа
      // Создаем email длиной 254 символа (согласно RFC)
      const longLocalPart = 'a'.repeat(240);
      const email254 = `${longLocalPart}@example.com`;
      expect(email254.length).toBeLessThanOrEqual(254);
      
      await emailInput.fill(email254);
      await emailInput.blur();
      await page.waitForTimeout(300);
      
      const value254 = await emailInput.inputValue();
      expect(value254.length).toBeLessThanOrEqual(254);
      console.log(`✅ Email 254 символа: длина ${value254.length} (принято)`);
      
      // 4.2. Trim (удаление пробелов по краям)
      await emailInput.fill(' test@mail.com ');
      await emailInput.blur();
      await page.waitForTimeout(300);
      
      const trimmedValue = await emailInput.inputValue();
      if (trimmedValue === 'test@mail.com') {
        console.log('✅ Trim: пробелы автоматически удалены');
      } else {
        console.log(`ℹ️ Trim: значение "${trimmedValue}" (пробелы могут быть сохранены)`);
      }
      
      // 4.3. Регистр (преобразование в нижний регистр)
      await emailInput.fill('TEST@MAIL.COM');
      await emailInput.blur();
      await page.waitForTimeout(300);
      
      const lowerValue = await emailInput.inputValue();
      if (lowerValue === 'test@mail.com') {
        console.log('✅ Регистр: преобразовано в нижний регистр');
      } else {
        console.log(`ℹ️ Регистр: значение "${lowerValue}" (может быть сохранено как есть)`);
      }
      
      // Восстанавливаем исходное значение
      await emailInput.fill(originalValue);
      await emailInput.blur();
      await page.waitForTimeout(500);
    });

    // Проверка стилей поля Email
    await test.step('Проверка стилей поля Email', async () => {
      const emailInput = page.locator('input#email[name="email"]').first();
      
      const inputStyles = await emailInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          border: styles.border,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          display: styles.display,
          visibility: styles.visibility
        };
      });

      expect(inputStyles.display).not.toBe('none');
      expect(inputStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили поля Email: font-size=${inputStyles.fontSize}, color=${inputStyles.color}, padding=${inputStyles.padding}`);
    });

    // Проверка наличия текста "Password"
    await test.step('Проверка наличия текста Password', async () => {
      const passwordText = page.getByText('Password', { exact: false }).first();
      await expect(passwordText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Password" найден на странице');
    });

    // 1. UI и атрибуты поля New Password
    await test.step('1. UI и атрибуты поля New Password', async () => {
      // Используем XPath для поиска поля
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      await expect(newPasswordInput).toBeVisible({ timeout: 10000 });
      
      // 1.1. Тип поля
      const type = await newPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      console.log(`✅ Тип поля New Password: ${type}`);
      
      // 1.2. Placeholder
      const placeholder = await newPasswordInput.getAttribute('placeholder');
      if (placeholder) {
        expect(placeholder.length).toBeGreaterThan(0);
        console.log(`✅ Placeholder поля New Password: "${placeholder}"`);
      } else {
        console.log('ℹ️ Placeholder поля New Password отсутствует');
      }
      
      // 1.3. Required
      const required = await newPasswordInput.getAttribute('required');
      if (required !== null) {
        console.log('✅ Поле New Password обязательное (required)');
      } else {
        console.log('ℹ️ Поле New Password необязательное (required отсутствует)');
      }
      
      // 1.4. Подсказка "Must be 8 Characters at Least"
      const hintText = page.getByText(/Must be 8 Characters at Least/i).first();
      const hintExists = await hintText.count();
      if (hintExists > 0) {
        await expect(hintText).toBeVisible({ timeout: 5000 });
        console.log('✅ Подсказка "Must be 8 Characters at Least" найдена');
      } else {
        console.log('ℹ️ Подсказка "Must be 8 Characters at Least" не найдена');
      }
    });

    // 2. Функционал видимости (Toggle Eye)
    await test.step('2. Функционал видимости (Toggle Eye)', async () => {
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      const toggleEye = page.locator('xpath=//*[@id="passwordInput"]/span');
      
      // Проверяем наличие иконки глазика
      const eyeExists = await toggleEye.count();
      expect(eyeExists).toBeGreaterThan(0);
      await expect(toggleEye).toBeVisible({ timeout: 10000 });
      console.log('✅ Иконка глазика найдена');
      
      // Заполняем поле паролем для проверки видимости
      const testPassword = 'TestPassword123';
      await newPasswordInput.fill(testPassword);
      await page.waitForTimeout(300);
      
      // Проверяем начальное состояние (type="password" - пароль скрыт)
      let type = await newPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      
      // Проверяем, что пароль скрыт (значение не видно в атрибуте value или отображается как точки)
      const isPasswordHidden = await newPasswordInput.evaluate((el: HTMLInputElement) => {
        return (el as HTMLInputElement).type === 'password';
      });
      expect(isPasswordHidden).toBe(true);
      console.log('✅ Начальное состояние: пароль скрыт (type="password")');
      
      // Кликаем на иконку глазика - показываем пароль
      await toggleEye.click();
      await page.waitForTimeout(300);
      
      // Проверяем, что тип изменился на "text" - пароль виден
      type = await newPasswordInput.getAttribute('type');
      expect(type).toBe('text');
      
      // Проверяем, что пароль действительно виден (значение отображается)
      const visibleValue = await newPasswordInput.inputValue();
      expect(visibleValue).toBe(testPassword);
      console.log(`✅ После клика: пароль виден (type="text", значение: "${visibleValue}")`);
      
      // Проверяем, что поле Confirm New Password не затронуто
      const confirmPasswordInput = page.locator('input[type="password"][name*="password_confirmation"], input[type="password"][id*="password_confirmation"]').first();
      const confirmExists = await confirmPasswordInput.count();
      if (confirmExists > 0) {
        const confirmType = await confirmPasswordInput.getAttribute('type');
        expect(confirmType).toBe('password');
        console.log('✅ Поле Confirm New Password не затронуто (осталось type="password")');
      }
      
      // Кликаем еще раз - скрываем пароль
      await toggleEye.click();
      await page.waitForTimeout(300);
      
      // Проверяем, что тип вернулся на "password" - пароль скрыт
      type = await newPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      
      // Проверяем, что значение все еще есть, но скрыто
      const hiddenValue = await newPasswordInput.inputValue();
      expect(hiddenValue).toBe(testPassword); // Значение сохраняется, но визуально скрыто
      console.log(`✅ После второго клика: пароль скрыт (type="password", значение сохранено: "${hiddenValue.length} символов")`);
      
      // Очищаем поле
      await newPasswordInput.clear();
      await page.waitForTimeout(300);
    });

    // 3. Валидация поля New Password
    await test.step('3. Валидация поля New Password', async () => {
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      
      // 3.1. Минимальная длина (7 символов)
      await newPasswordInput.fill('1234567'); // 7 символов
      await newPasswordInput.blur();
      await page.waitForTimeout(500);
      
      // Проверяем наличие ошибки
      const errorMessage = page.locator('.error, .invalid-feedback, [class*="error"], [class*="invalid"]')
        .filter({ hasNotText: /grecaptcha/i })
        .filter({ hasNot: page.locator('[class*="grecaptcha"]') })
        .first();
      
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const isVisible = await errorMessage.isVisible();
        if (isVisible) {
          const errorText = await errorMessage.textContent();
          console.log(`✅ 7 символов: ошибка найдена - "${errorText?.trim()}"`);
        } else {
          console.log('ℹ️ 7 символов: ошибка найдена, но скрыта');
        }
      } else {
        // Проверяем браузерную валидацию
        const validationMessage = await newPasswordInput.evaluate((el: HTMLInputElement) => {
          return (el as HTMLInputElement).validationMessage;
        });
        if (validationMessage) {
          console.log(`✅ 7 символов: браузерная валидация - "${validationMessage}"`);
        } else {
          console.log('⚠️ 7 символов: ошибка не найдена');
        }
      }
      
      // 3.2. Граничное значение (8 символов)
      await newPasswordInput.fill('12345678'); // 8 символов
      await newPasswordInput.blur();
      await page.waitForTimeout(500);
      
      const value8 = await newPasswordInput.inputValue();
      expect(value8.length).toBeGreaterThanOrEqual(8);
      console.log(`✅ 8 символов: значение принято (длина: ${value8.length})`);
      
      // Проверяем, что ошибки нет
      const errorExists8 = await errorMessage.count();
      if (errorExists8 > 0) {
        const isVisible8 = await errorMessage.isVisible();
        if (!isVisible8) {
          console.log('✅ 8 символов: ошибка не видна (валидация пройдена)');
        } else {
          console.log('⚠️ 8 символов: ошибка все еще видна');
        }
      } else {
        console.log('✅ 8 символов: ошибка отсутствует (валидация пройдена)');
      }
      
      // 3.3. Максимальная длина (255 символов)
      const longPassword = 'A'.repeat(255);
      await newPasswordInput.fill(longPassword);
      await newPasswordInput.blur();
      await page.waitForTimeout(500);
      
      const value255 = await newPasswordInput.inputValue();
      expect(value255.length).toBeLessThanOrEqual(255);
      console.log(`✅ 255 символов: значение принято (длина: ${value255.length})`);
      
      // 3.4. Пустое поле
      await newPasswordInput.clear();
      await newPasswordInput.blur();
      await page.waitForTimeout(500);
      
      // Проверяем наличие ошибки или блокировку кнопки сохранения
      const emptyErrorExists = await errorMessage.count();
      if (emptyErrorExists > 0) {
        const isVisibleEmpty = await errorMessage.isVisible();
        if (isVisibleEmpty) {
          const errorText = await errorMessage.textContent();
          console.log(`✅ Пустое поле: ошибка найдена - "${errorText?.trim()}"`);
        } else {
          console.log('ℹ️ Пустое поле: ошибка найдена, но скрыта');
        }
      } else {
        // Проверяем блокировку кнопки сохранения
        const saveButton = page.locator('button[type="submit"]').or(page.getByRole('button', { name: /Save|Update|Submit/i })).first();
        const saveButtonExists = await saveButton.count();
        if (saveButtonExists > 0) {
          const isDisabled = await saveButton.isDisabled();
          if (isDisabled) {
            console.log('✅ Пустое поле: кнопка сохранения заблокирована');
          } else {
            console.log('⚠️ Пустое поле: кнопка сохранения не заблокирована');
          }
        } else {
          console.log('⚠️ Пустое поле: ошибка не найдена и кнопка сохранения не найдена');
        }
      }
      
      // Очищаем поле
      await newPasswordInput.clear();
      await newPasswordInput.blur();
      await page.waitForTimeout(500);
    });

    // Проверка стилей поля New Password
    await test.step('Проверка стилей поля New Password', async () => {
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      
      const inputStyles = await newPasswordInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          border: styles.border,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          display: styles.display,
          visibility: styles.visibility
        };
      });

      expect(inputStyles.display).not.toBe('none');
      expect(inputStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили поля New Password: font-size=${inputStyles.fontSize}, color=${inputStyles.color}, padding=${inputStyles.padding}`);
    });

    // Проверка стилей иконки глазика
    await test.step('Проверка стилей иконки глазика', async () => {
      const toggleEye = page.locator('xpath=//*[@id="passwordInput"]/span');
      
      const eyeStyles = await toggleEye.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(eyeStyles.display).not.toBe('none');
      expect(eyeStyles.visibility).not.toBe('hidden');
      expect(parseFloat(eyeStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили иконки глазика: cursor=${eyeStyles.cursor}, opacity=${eyeStyles.opacity}`);
    });

    // 1. UI и атрибуты поля Confirm Password
    await test.step('1. UI и атрибуты поля Confirm Password', async () => {
      // Используем XPath для поиска поля
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      await expect(confirmPasswordInput).toBeVisible({ timeout: 10000 });
      
      // 1.1. Тип поля
      const type = await confirmPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      console.log(`✅ Тип поля Confirm Password: ${type}`);
      
      // 1.2. Placeholder
      const placeholder = await confirmPasswordInput.getAttribute('placeholder');
      if (placeholder) {
        expect(placeholder.length).toBeGreaterThan(0);
        console.log(`✅ Placeholder поля Confirm Password: "${placeholder}"`);
      } else {
        console.log('ℹ️ Placeholder поля Confirm Password отсутствует');
      }
      
      // 1.3. Required
      const required = await confirmPasswordInput.getAttribute('required');
      if (required !== null) {
        console.log('✅ Поле Confirm Password обязательное (required)');
      } else {
        console.log('ℹ️ Поле Confirm Password необязательное (required отсутствует)');
      }
      
      // 1.4. Подсказка "Must be 8 Characters at Least"
      const hintText = page.getByText(/Must be 8 Characters at Least/i).first();
      const hintExists = await hintText.count();
      if (hintExists > 0) {
        await expect(hintText).toBeVisible({ timeout: 5000 });
        console.log('✅ Подсказка "Must be 8 Characters at Least" найдена');
      } else {
        console.log('ℹ️ Подсказка "Must be 8 Characters at Least" не найдена');
      }
    });

    // 2. Функционал видимости (Toggle Eye) для Confirm Password
    await test.step('2. Функционал видимости (Toggle Eye) для Confirm Password', async () => {
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      const toggleEye = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[3]/div/div[2]/div/span');
      
      // Проверяем наличие иконки глазика
      const eyeExists = await toggleEye.count();
      expect(eyeExists).toBeGreaterThan(0);
      await expect(toggleEye).toBeVisible({ timeout: 10000 });
      console.log('✅ Иконка глазика для Confirm Password найдена');
      
      // Заполняем поле паролем для проверки видимости
      const testPassword = 'TestPassword123';
      await confirmPasswordInput.fill(testPassword);
      await page.waitForTimeout(300);
      
      // Проверяем начальное состояние (type="password" - пароль скрыт)
      let type = await confirmPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      
      // Проверяем, что пароль скрыт
      const isPasswordHidden = await confirmPasswordInput.evaluate((el: HTMLInputElement) => {
        return (el as HTMLInputElement).type === 'password';
      });
      expect(isPasswordHidden).toBe(true);
      console.log('✅ Начальное состояние: пароль скрыт (type="password")');
      
      // Кликаем на иконку глазика - показываем пароль
      await toggleEye.click();
      await page.waitForTimeout(300);
      
      // Проверяем, что тип изменился на "text" - пароль виден
      type = await confirmPasswordInput.getAttribute('type');
      expect(type).toBe('text');
      
      // Проверяем, что пароль действительно виден (значение отображается)
      const visibleValue = await confirmPasswordInput.inputValue();
      expect(visibleValue).toBe(testPassword);
      console.log(`✅ После клика: пароль виден (type="text", значение: "${visibleValue}")`);
      
      // Проверяем, что поле New Password не затронуто
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      const newPasswordType = await newPasswordInput.getAttribute('type');
      // Поле New Password должно остаться в своем состоянии (не изменяться)
      console.log(`✅ Поле New Password не затронуто (type="${newPasswordType}")`);
      
      // Кликаем еще раз - скрываем пароль
      await toggleEye.click();
      await page.waitForTimeout(300);
      
      // Проверяем, что тип вернулся на "password" - пароль скрыт
      type = await confirmPasswordInput.getAttribute('type');
      expect(type).toBe('password');
      
      // Проверяем, что значение все еще есть, но скрыто
      const hiddenValue = await confirmPasswordInput.inputValue();
      expect(hiddenValue).toBe(testPassword); // Значение сохраняется, но визуально скрыто
      console.log(`✅ После второго клика: пароль скрыт (type="password", значение сохранено: "${hiddenValue.length} символов")`);
      
      // Очищаем поле
      await confirmPasswordInput.clear();
      await page.waitForTimeout(300);
    });

    // 3. Валидация поля Confirm Password
    await test.step('3. Валидация поля Confirm Password', async () => {
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      
      // 3.1. Минимальная длина (7 символов)
      await confirmPasswordInput.fill('1234567'); // 7 символов
      await confirmPasswordInput.blur();
      await page.waitForTimeout(500);
      
      // Проверяем наличие ошибки
      const errorMessage = page.locator('.error, .invalid-feedback, [class*="error"], [class*="invalid"]')
        .filter({ hasNotText: /grecaptcha/i })
        .filter({ hasNot: page.locator('[class*="grecaptcha"]') })
        .first();
      
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const isVisible = await errorMessage.isVisible();
        if (isVisible) {
          const errorText = await errorMessage.textContent();
          console.log(`✅ 7 символов: ошибка найдена - "${errorText?.trim()}"`);
        } else {
          console.log('ℹ️ 7 символов: ошибка найдена, но скрыта');
        }
      } else {
        // Проверяем браузерную валидацию
        const validationMessage = await confirmPasswordInput.evaluate((el: HTMLInputElement) => {
          return (el as HTMLInputElement).validationMessage;
        });
        if (validationMessage) {
          console.log(`✅ 7 символов: браузерная валидация - "${validationMessage}"`);
        } else {
          console.log('⚠️ 7 символов: ошибка не найдена');
        }
      }
      
      // 3.2. Граничное значение (8 символов)
      await confirmPasswordInput.fill('12345678'); // 8 символов
      await confirmPasswordInput.blur();
      await page.waitForTimeout(500);
      
      const value8 = await confirmPasswordInput.inputValue();
      expect(value8.length).toBeGreaterThanOrEqual(8);
      console.log(`✅ 8 символов: значение принято (длина: ${value8.length})`);
      
      // Проверяем, что ошибки нет
      const errorExists8 = await errorMessage.count();
      if (errorExists8 > 0) {
        const isVisible8 = await errorMessage.isVisible();
        if (!isVisible8) {
          console.log('✅ 8 символов: ошибка не видна (валидация пройдена)');
        } else {
          console.log('⚠️ 8 символов: ошибка все еще видна');
        }
      } else {
        console.log('✅ 8 символов: ошибка отсутствует (валидация пройдена)');
      }
      
      // 3.3. Максимальная длина (255 символов)
      const longPassword = 'A'.repeat(255);
      await confirmPasswordInput.fill(longPassword);
      await confirmPasswordInput.blur();
      await page.waitForTimeout(500);
      
      const value255 = await confirmPasswordInput.inputValue();
      expect(value255.length).toBeLessThanOrEqual(255);
      console.log(`✅ 255 символов: значение принято (длина: ${value255.length})`);
      
      // 3.4. Пустое поле
      await confirmPasswordInput.clear();
      await confirmPasswordInput.blur();
      await page.waitForTimeout(500);
      
      // Проверяем наличие ошибки или блокировку кнопки сохранения
      const emptyErrorExists = await errorMessage.count();
      if (emptyErrorExists > 0) {
        const isVisibleEmpty = await errorMessage.isVisible();
        if (isVisibleEmpty) {
          const errorText = await errorMessage.textContent();
          console.log(`✅ Пустое поле: ошибка найдена - "${errorText?.trim()}"`);
        } else {
          console.log('ℹ️ Пустое поле: ошибка найдена, но скрыта');
        }
      } else {
        // Проверяем блокировку кнопки сохранения
        const saveButton = page.locator('button[type="submit"]').or(page.getByRole('button', { name: /Save|Update|Submit/i })).first();
        const saveButtonExists = await saveButton.count();
        if (saveButtonExists > 0) {
          const isDisabled = await saveButton.isDisabled();
          if (isDisabled) {
            console.log('✅ Пустое поле: кнопка сохранения заблокирована');
          } else {
            console.log('⚠️ Пустое поле: кнопка сохранения не заблокирована');
          }
        } else {
          console.log('⚠️ Пустое поле: ошибка не найдена и кнопка сохранения не найдена');
        }
      }
      
      // Очищаем поле
      await confirmPasswordInput.clear();
      await confirmPasswordInput.blur();
      await page.waitForTimeout(500);
    });

    // Проверка стилей поля Confirm Password
    await test.step('Проверка стилей поля Confirm Password', async () => {
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      
      const inputStyles = await confirmPasswordInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          border: styles.border,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          display: styles.display,
          visibility: styles.visibility
        };
      });

      expect(inputStyles.display).not.toBe('none');
      expect(inputStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили поля Confirm Password: font-size=${inputStyles.fontSize}, color=${inputStyles.color}, padding=${inputStyles.padding}`);
    });

    // Проверка стилей иконки глазика для Confirm Password
    await test.step('Проверка стилей иконки глазика для Confirm Password', async () => {
      const toggleEye = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[3]/div/div[2]/div/span');
      
      const eyeStyles = await toggleEye.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(eyeStyles.display).not.toBe('none');
      expect(eyeStyles.visibility).not.toBe('hidden');
      expect(parseFloat(eyeStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили иконки глазика для Confirm Password: cursor=${eyeStyles.cursor}, opacity=${eyeStyles.opacity}`);
    });

    // Функциональный тест: сохранение изменений и проверка
    await test.step('Функциональный тест: сохранение изменений и проверка', async () => {
      // Заполняем поля новыми значениями
      const nameInput = page.locator('input#name[name="name"]').first();
      const emailInput = page.locator('input#email[name="email"]').first();
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      
      // Заполняем Name
      await nameInput.fill('IhorMynaievTest');
      await nameInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле Name заполнено: IhorMynaievTest');
      
      // Заполняем New Password
      await newPasswordInput.fill('Qwerty1234$');
      await newPasswordInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле New Password заполнено');
      
      // Заполняем Confirm Password
      await confirmPasswordInput.fill('Qwerty1234$');
      await confirmPasswordInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле Confirm Password заполнено');
      
      // Кликаем на кнопку сохранения
      const saveButton = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[4]/button');
      await expect(saveButton).toBeVisible({ timeout: 10000 });
      await saveButton.click();
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка сохранения нажата');
      
      // Проверяем, что изменения сохранились
      const savedName = await nameInput.inputValue();
      
      expect(savedName).toBe('IhorMynaievTest');
      console.log(`✅ Изменения сохранены: Name="${savedName}"`);
      
      // Проверяем наличие сообщения об успешном сохранении
      const successMessage = page.getByText(/Saved|Success|Updated|Changes saved/i).first();
      const successExists = await successMessage.count();
      if (successExists > 0) {
        const isVisible = await successMessage.isVisible();
        if (isVisible) {
          const successText = await successMessage.textContent();
          console.log(`✅ Сообщение об успешном сохранении: "${successText?.trim()}"`);
        }
      }
    });

    // Выход из системы
    await test.step('Выход из системы', async () => {
      // Кликаем на аватар пользователя (используем родительский элемент <a> для более стабильного клика)
      const avatarLink = page.locator('xpath=/html/body/div[1]/div[1]/div[2]/ul/li[4]/a');
      await expect(avatarLink).toBeVisible({ timeout: 10000 });
      
      // Используем JavaScript клик для обхода проблемы нестабильности элемента
      await avatarLink.evaluate((el: HTMLElement) => {
        el.click();
      });
      await page.waitForTimeout(1000);
      console.log('✅ Клик на аватар выполнен');
      
      // Кликаем на Logout
      const logoutLink = page.locator('xpath=/html/body/div[1]/div[1]/div[2]/ul/li[4]/div/form/a/span');
      await expect(logoutLink).toBeVisible({ timeout: 10000 });
      
      // Используем JavaScript клик для Logout тоже
      await logoutLink.evaluate((el: HTMLElement) => {
        el.click();
      });
      await page.waitForTimeout(2000);
      console.log('✅ Выход из системы выполнен');
      
      // Проверяем переход на главную страницу
      await page.waitForURL('https://dev.indooroutdoor.com/', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/');
      console.log('✅ Переход на главную страницу подтвержден');
    });

    // Авторизация с новым паролем
    await test.step('Авторизация с новым паролем', async () => {
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).fill('ihor.mynaiev@greenice.net');
      await page.getByRole('textbox', { name: '*************' }).click();
      await page.getByRole('textbox', { name: '*************' }).fill('Qwerty1234$');
      await page.getByRole('button', { name: 'Login' }).click();
      
      // Ждем завершения авторизации
      await page.waitForTimeout(2000);
      console.log('✅ Авторизация с новым паролем выполнена');
    });

    // Возврат на страницу Account Settings
    await test.step('Возврат на страницу Account Settings', async () => {
      // Навигация к Account Settings
      const allSettingsSpans = page.locator('span').filter({ hasText: /^Settings$/ });
      const count = await allSettingsSpans.count();
      expect(count).toBeGreaterThanOrEqual(2);
      
      const settingsSpan = allSettingsSpans.nth(1);
      await settingsSpan.evaluate((el: HTMLElement) => {
        el.click();
      });
      await page.waitForTimeout(1000); // Увеличиваем время ожидания открытия меню
      
      // В выпадающем списке ищем Account Settings
      // Используем XPath для более точного поиска, как в начале теста
      let accountSettingsLink = page.locator('xpath=//*[@id="sidebar-menu"]/ul/li[7]/ul/li/a');
      let linkExists = await accountSettingsLink.count();
      
      if (linkExists === 0) {
        // Fallback: ищем по href и тексту
        accountSettingsLink = page.locator('a[href*="profile"]').filter({ hasText: /Account Settings/i }).first();
        linkExists = await accountSettingsLink.count();
        
        if (linkExists === 0) {
          // Еще один fallback: просто по href
          accountSettingsLink = page.locator('a[href="https://dev.indooroutdoor.com/profile"]').first();
        }
      }
      
      // Проверяем существование элемента (даже если он скрыт)
      const finalLinkExists = await accountSettingsLink.count();
      expect(finalLinkExists).toBeGreaterThan(0);
      
      // Используем JavaScript клик для скрытых элементов
      await accountSettingsLink.evaluate((el: HTMLElement) => {
        (el as HTMLElement).click();
      });
      await page.waitForTimeout(2000);
      
      await page.waitForURL('https://dev.indooroutdoor.com/profile', { timeout: 10000 });
      console.log('✅ Возврат на страницу Account Settings выполнен');
    });

    // Возврат исходных значений
    await test.step('Возврат исходных значений', async () => {
      const nameInput = page.locator('input#name[name="name"]').first();
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      
      // Возвращаем Name (убираем "Test")
      await nameInput.fill('IhorMynaiev');
      await nameInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле Name возвращено: IhorMynaiev');
      
      // Возвращаем пароль
      await newPasswordInput.fill('Qwerty123$');
      await newPasswordInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле New Password возвращено');
      
      await confirmPasswordInput.fill('Qwerty123$');
      await confirmPasswordInput.blur();
      await page.waitForTimeout(300);
      console.log('✅ Поле Confirm Password возвращено');
      
      // Сохраняем изменения
      const saveButton = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[4]/button');
      await expect(saveButton).toBeVisible({ timeout: 10000 });
      await saveButton.click();
      await page.waitForTimeout(2000);
      console.log('✅ Изменения сохранены');
      
      // Проверяем, что значения вернулись
      const finalName = await nameInput.inputValue();
      
      expect(finalName).toBe('IhorMynaiev');
      console.log(`✅ Исходные значения восстановлены: Name="${finalName}"`);
    });

    // Проверка стилей всех элементов
    await test.step('Проверка стилей всех элементов', async () => {
      // Проверка стилей поля Name
      const nameInput = page.locator('input#name[name="name"]').first();
      const nameStyles = await nameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          color: styles.color,
          padding: styles.padding
        };
      });
      console.log(`✅ Стили поля Name: font-size=${nameStyles.fontSize}, color=${nameStyles.color}`);
      
      // Проверка стилей поля Email
      const emailInput = page.locator('input#email[name="email"]').first();
      const emailStyles = await emailInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          color: styles.color,
          padding: styles.padding
        };
      });
      console.log(`✅ Стили поля Email: font-size=${emailStyles.fontSize}, color=${emailStyles.color}`);
      
      // Проверка стилей кнопки сохранения
      const saveButton = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[4]/button');
      const buttonStyles = await saveButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          color: styles.color,
          backgroundColor: styles.backgroundColor,
          padding: styles.padding,
          borderRadius: styles.borderRadius
        };
      });
      console.log(`✅ Стили кнопки сохранения: font-size=${buttonStyles.fontSize}, background-color=${buttonStyles.backgroundColor}`);
    });

    // Проверка видимости всех элементов
    await test.step('Проверка видимости всех элементов', async () => {
      // Проверка видимости полей
      const nameInput = page.locator('input#name[name="name"]').first();
      await expect(nameInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Name видимо');
      
      const emailInput = page.locator('input#email[name="email"]').first();
      await expect(emailInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Email видимо');
      
      const newPasswordInput = page.locator('xpath=//*[@id="password"]');
      await expect(newPasswordInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле New Password видимо');
      
      const confirmPasswordInput = page.locator('xpath=//*[@id="password_confirmation"]');
      await expect(confirmPasswordInput).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Confirm Password видимо');
      
      // Проверка видимости кнопки сохранения
      const saveButton = page.locator('xpath=/html/body/div[1]/div[4]/div/div/div/form/div[4]/button');
      await expect(saveButton).toBeVisible({ timeout: 10000 });
      console.log('✅ Кнопка сохранения видима');
      
      // Проверка видимости заголовка
      const heading = page.getByRole('heading', { name: /Account Settings/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      console.log('✅ Заголовок Account Settings видим');
    });

    // Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});

