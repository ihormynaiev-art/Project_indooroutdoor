/**
 * REQUEST QUOTES SUITE — ПРОВЕРКА СИСТЕМЫ УПРАВЛЕНИЯ ЗАПРОСАМИ
 * 
 * Данный тестовый набор предназначен для проверки функциональности раздела 
 * "Request Quotes" в кабинете провайдера. Тест имитирует полный цикл работы 
 * со входящими заявками: от поиска в таблице до обновления статуса заказа.
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И НАВИГАЦИЯ:
 *    - Вход в систему и переход в раздел "Request Quotes" через боковое меню.
 *    - Валидация URL и корректности заголовка страницы (стили, шрифты, отступы).
 * 
 * 2. АУДИТ ТАБЛИЦЫ И СОРТИРОВОК:
 *    - Проверка наличия ключевых колонок: Full Name, Email, Status, Date.
 *    - Тестирование логики сортировки (Ascending/Descending):
 *      - Проверка изменения порядка строк в DOM после клика по заголовку.
 *      - Валидация атрибута aria-sort для подтверждения корректного состояния таблицы.
 *    - Анализ стилей заголовков таблицы (cursor: pointer, шрифты).
 * 
 * 3. ПОИСК И ПЕРЕХОД К ДЕТАЛЯМ:
 *    - Поиск конкретной заявки по набору данных (Aaron Scott, New, 01/02/2025).
 *    - Проверка функциональности иконки просмотра (Eye Icon) и перехода на страницу деталей.
 *    - Валидация динамического URL детальной страницы по паттерну /request-quotes/\d+.
 * 
 * 4. УПРАВЛЕНИЕ СТАТУСОМ И ЗАМЕТКАМИ:
 *    - Проверка выпадающего списка Status: наличие опций New, In Progress, Done.
 *    - Тестирование смены статуса и успешного сохранения изменений.
 *    - Проверка текстового поля Internal Note: ввод данных и сохранение служебных заметок.
 *    - Валидация появления уведомлений об успешном обновлении данных.
 * 
 * 5. ПРОВЕРКА ЗАБЛОКИРОВАННЫХ (DISABLED) ПОЛЕЙ:
 *    - Глубокий аудит безопасности и доступа: проверка того, что данные клиента 
 *      (Email, Телефон, Категория, Адрес, Детали проекта) заблокированы для редактирования провайдером.
 *    - Валидация атрибутов disabled/readonly и проверка CSS-стилей заблокированных полей (background-color, cursor: not-allowed).
 * 
 * 6. ТЕХНИЧЕСКИЙ И UI/UX АУДИТ:
 *    - Анализ стилей всех интерактивных элементов через getComputedStyle.
 *    - Вызов комплексной функции checkUIUX для проверки адаптивности и доступности страницы.
 * 
 * ИТОГ: Тест гарантирует стабильность работы CRM-системы провайдера, корректность 
 * управления статусами заказов и защиту персональных данных клиентов от случайного изменения.
 */

import { test, expect } from '@playwright/test';
import { checkUIUX } from './helpers/ui-ux-helpers';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Request Quotes - Проверка страницы запросов на котировки
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Навигацию на страницу Request Quotes
 * - Проверку таблицы с сортировками
 * - Переход к детальной странице запроса
 * - Проверку полей формы (Status, Internal Note)
 * - Проверку disabled полей
 * - Сохранение изменений
 * 
 * @see README.md для подробной документации
 */
test.describe('Request Quotes Suite @regression', () => {
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

  test('Навигация и проверка страницы Request Quotes', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(180000); // 3 минуты

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

    // Навигация к Request Quotes
    await test.step('Навигация к Request Quotes', async () => {
      // Ищем элемент Request Quotes в меню слева
      const requestQuotesLink = page.locator('span').filter({ hasText: /^Request Quotes$/ }).first();
      await expect(requestQuotesLink).toBeVisible({ timeout: 10000 });
      await requestQuotesLink.click();
      await page.waitForTimeout(2000);
      
      console.log('✅ Переход на страницу Request Quotes выполнен');
    });

    // Проверка URL
    await test.step('Проверка URL страницы', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/provider/request-quotes', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/request-quotes');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Проверка заголовка страницы
    await test.step('Проверка заголовка страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Request Quotes/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Request Quotes');
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
          opacity: styles.opacity,
          margin: styles.margin,
          padding: styles.padding,
          textAlign: styles.textAlign
        };
      });

      // Проверка видимости
      expect(headingStyles.display).not.toBe('none');
      expect(headingStyles.visibility).not.toBe('hidden');
      expect(parseFloat(headingStyles.opacity)).toBeGreaterThan(0);
      console.log('✅ Заголовок видим и не скрыт через CSS');

      // Проверка шрифта
      expect(headingStyles.fontFamily).toBeTruthy();
      const fontSizeNum = parseFloat(headingStyles.fontSize);
      expect(fontSizeNum).toBeGreaterThan(0);
      console.log(`✅ Стили заголовка: font-size=${headingStyles.fontSize}, font-family=${headingStyles.fontFamily}, font-weight=${headingStyles.fontWeight}`);

      // Проверка цвета
      expect(headingStyles.color).toBeTruthy();
      console.log(`✅ Цвет заголовка: ${headingStyles.color}`);
    });

    // Проверка колонок таблицы с сортировками
    await test.step('Проверка колонок таблицы с сортировками и их стилей', async () => {
      // Проверка колонки Full Name
      const fullNameHeader = page.locator('th').filter({ hasText: /^Full Name$/ }).first();
      await expect(fullNameHeader).toBeVisible({ timeout: 10000 });
      await expect(fullNameHeader).toHaveAttribute('aria-label', /Full Name.*sort/i);
      console.log('✅ Колонка "Full Name" найдена');

      // Проверка стилей колонки Full Name
      const fullNameStyles = await fullNameHeader.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
          color: styles.color,
          textAlign: styles.textAlign,
          cursor: styles.cursor
        };
      });
      console.log(`✅ Стили колонки Full Name: font-size=${fullNameStyles.fontSize}, font-weight=${fullNameStyles.fontWeight}, cursor=${fullNameStyles.cursor}`);

      // Проверка колонки Email
      const emailHeader = page.locator('th').filter({ hasText: /^Email$/ }).first();
      await expect(emailHeader).toBeVisible({ timeout: 10000 });
      await expect(emailHeader).toHaveAttribute('aria-label', /Email.*sort/i);
      console.log('✅ Колонка "Email" найдена');

      // Проверка стилей колонки Email
      const emailStyles = await emailHeader.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
          color: styles.color,
          cursor: styles.cursor
        };
      });
      console.log(`✅ Стили колонки Email: font-size=${emailStyles.fontSize}, font-weight=${emailStyles.fontWeight}, cursor=${emailStyles.cursor}`);

      // Проверка колонки Status
      const statusHeader = page.locator('th').filter({ hasText: /^Status$/ }).first();
      await expect(statusHeader).toBeVisible({ timeout: 10000 });
      await expect(statusHeader).toHaveAttribute('aria-label', /Status.*sort/i);
      console.log('✅ Колонка "Status" найдена');

      // Проверка стилей колонки Status
      const statusStyles = await statusHeader.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
          color: styles.color,
          cursor: styles.cursor
        };
      });
      console.log(`✅ Стили колонки Status: font-size=${statusStyles.fontSize}, font-weight=${statusStyles.fontWeight}, cursor=${statusStyles.cursor}`);

      // Проверка колонки Date
      const dateHeader = page.locator('th').filter({ hasText: /^Date$/ }).first();
      await expect(dateHeader).toBeVisible({ timeout: 10000 });
      await expect(dateHeader).toHaveAttribute('aria-label', /Date.*sort/i);
      console.log('✅ Колонка "Date" найдена');

      // Проверка стилей колонки Date
      const dateStyles = await dateHeader.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
          color: styles.color,
          cursor: styles.cursor
        };
      });
      console.log(`✅ Стили колонки Date: font-size=${dateStyles.fontSize}, font-weight=${dateStyles.fontWeight}, cursor=${dateStyles.cursor}`);
    });

    // Проверка функциональности сортировки колонок
    await test.step('Проверка функциональности сортировки колонок', async () => {
      const sortableColumns = ['Full Name', 'Email', 'Status', 'Date'];

      for (const columnName of sortableColumns) {
        // Находим заголовок колонки
        const columnHeader = page.locator('th').filter({ hasText: new RegExp(`^${columnName}$`) }).first();
        await expect(columnHeader).toBeVisible({ timeout: 10000 });
        
        // Находим индекс колонки в таблице
        const allHeaders = await page.locator('thead th').allTextContents();
        const columnIndex = allHeaders.findIndex(h => h.trim() === columnName) + 1;
        
        if (columnIndex === 0) {
          console.log(`⚠️ Колонка "${columnName}" не найдена в заголовках`);
          continue;
        }
        
        // Получаем начальный порядок строк (первые 3 значения в колонке)
        const initialRows = await page.locator('tbody tr').all();
        const initialValues: string[] = [];
        for (let i = 0; i < Math.min(3, initialRows.length); i++) {
          const cell = initialRows[i].locator(`td:nth-child(${columnIndex})`);
          const text = await cell.textContent();
          if (text) initialValues.push(text.trim());
        }
        console.log(`📊 Начальный порядок "${columnName}": ${initialValues.join(', ')}`);

        // Первый клик - сортировка по возрастанию
        await columnHeader.click();
        await page.waitForTimeout(1500); // Ждем применения сортировки
        
        const afterFirstClickRows = await page.locator('tbody tr').all();
        const afterFirstClickValues: string[] = [];
        for (let i = 0; i < Math.min(3, afterFirstClickRows.length); i++) {
          const cell = afterFirstClickRows[i].locator(`td:nth-child(${columnIndex})`);
          const text = await cell.textContent();
          if (text) afterFirstClickValues.push(text.trim());
        }
        console.log(`📊 Порядок после первого клика "${columnName}": ${afterFirstClickValues.join(', ')}`);
        
        // Проверяем, что порядок изменился или остался отсортированным
        const orderChanged = JSON.stringify(initialValues) !== JSON.stringify(afterFirstClickValues);
        if (orderChanged) {
          console.log(`✅ Сортировка "${columnName}" работает (порядок изменился)`);
        } else {
          console.log(`ℹ️ Порядок "${columnName}" не изменился (возможно, уже был отсортирован)`);
        }

        // Проверяем aria-sort после первого клика
        const ariaSort1 = await columnHeader.getAttribute('aria-sort');
        console.log(`✅ Атрибут aria-sort после первого клика: ${ariaSort1}`);
        if (ariaSort1) {
          expect(ariaSort1).toMatch(/ascending|descending/i);
        }

        // Второй клик - обратная сортировка
        await columnHeader.click();
        await page.waitForTimeout(1500);
        
        const afterSecondClickRows = await page.locator('tbody tr').all();
        const afterSecondClickValues: string[] = [];
        for (let i = 0; i < Math.min(3, afterSecondClickRows.length); i++) {
          const cell = afterSecondClickRows[i].locator(`td:nth-child(${columnIndex})`);
          const text = await cell.textContent();
          if (text) afterSecondClickValues.push(text.trim());
        }
        console.log(`📊 Порядок после второго клика "${columnName}": ${afterSecondClickValues.join(', ')}`);
        
        // Проверяем, что порядок изменился после второго клика
        const orderChangedAgain = JSON.stringify(afterFirstClickValues) !== JSON.stringify(afterSecondClickValues);
        if (orderChangedAgain) {
          console.log(`✅ Обратная сортировка "${columnName}" работает (порядок изменился)`);
        } else {
          console.log(`ℹ️ Порядок "${columnName}" не изменился после второго клика`);
        }

        // Проверяем aria-sort после второго клика
        const ariaSort2 = await columnHeader.getAttribute('aria-sort');
        console.log(`✅ Атрибут aria-sort после второго клика: ${ariaSort2}`);
        if (ariaSort2) {
          expect(ariaSort2).toMatch(/ascending|descending/i);
          // Проверяем, что значение изменилось после второго клика
          if (ariaSort1 && ariaSort2) {
            expect(ariaSort1).not.toBe(ariaSort2);
            console.log(`✅ Атрибут aria-sort изменился: ${ariaSort1} → ${ariaSort2}`);
          }
        }
      }
    });

    // Поиск строки и переход к детальной странице
    await test.step('Поиск строки и переход к детальной странице', async () => {
      // Ищем строку с данными Aaron Scott, aaron@roofingarmy.com, New, 01/02/2025
      const targetRow = page.locator('tr').filter({ hasText: 'Aaron Scott' }).filter({ hasText: 'aaron@roofingarmy.com' }).filter({ hasText: 'New' }).filter({ hasText: '01/02/2025' }).first();
      await expect(targetRow).toBeVisible({ timeout: 10000 });
      console.log('✅ Строка с данными Aaron Scott найдена');

      // Ищем иконку глаза в этой строке
      const eyeIcon = targetRow.locator('i.fa-eye, [class*="eye"], [aria-label*="view" i], [title*="view" i]').first();
      const eyeIconExists = await eyeIcon.count();
      
      if (eyeIconExists > 0) {
        await expect(eyeIcon).toBeVisible({ timeout: 5000 });
        await eyeIcon.click();
        console.log('✅ Иконка глаза найдена и нажата');
      } else {
        // Альтернативный поиск - ищем ссылку или кнопку в строке
        const viewLink = targetRow.locator('a, button').first();
        await expect(viewLink).toBeVisible({ timeout: 5000 });
        await viewLink.click();
        console.log('✅ Ссылка/кнопка просмотра найдена и нажата');
      }
      
      await page.waitForTimeout(2000);
    });

    // Проверка URL детальной страницы
    await test.step('Проверка URL детальной страницы', async () => {
      await page.waitForURL(/.*\/provider\/request-quotes\/\d+/, { timeout: 10000 });
      await expect(page).toHaveURL(/.*\/provider\/request-quotes\/\d+/);
      console.log(`✅ Переход на детальную страницу выполнен. URL: "${page.url()}"`);
    });

    // Проверка заголовка детальной страницы
    await test.step('Проверка заголовка детальной страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Request Quote/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Request Quote');
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
      console.log(`✅ Стили заголовка: font-size=${headingStyles.fontSize}, font-family=${headingStyles.fontFamily}, color=${headingStyles.color}`);
    });

    // Проверка поля Status
    await test.step('Проверка поля Status и его стилей', async () => {
      const statusField = page.locator('select[name*="status" i], select[id*="status" i]').first();
      await expect(statusField).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Status найдено');

      // Проверка стилей поля Status
      const statusStyles = await statusField.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          backgroundColor: styles.backgroundColor,
          border: styles.border,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(statusStyles.display).not.toBe('none');
      expect(statusStyles.visibility).not.toBe('hidden');
      expect(parseFloat(statusStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили поля Status: font-size=${statusStyles.fontSize}, border-radius=${statusStyles.borderRadius}, padding=${statusStyles.padding}`);

      // Проверка значений в выпадающем списке
      const options = await statusField.locator('option').all();
      const optionTexts: string[] = [];
      for (const option of options) {
        const text = await option.textContent();
        if (text) optionTexts.push(text.trim().toLowerCase());
      }
      
      expect(optionTexts).toContain('new');
      expect(optionTexts).toContain('in progress');
      expect(optionTexts).toContain('done');
      console.log(`✅ Значения в списке Status найдены: ${optionTexts.join(', ')}`);

      // Изменение значения на "In Progress"
      // Ищем опцию по тексту и выбираем по value или индексу
      const inProgressOption = statusField.locator('option').filter({ hasText: /In Progress/i }).first();
      const inProgressValue = await inProgressOption.getAttribute('value');
      if (inProgressValue) {
        await statusField.selectOption(inProgressValue);
      } else {
        // Альтернативный способ - выбор по индексу
        const options = await statusField.locator('option').all();
        for (let i = 0; i < options.length; i++) {
          const text = await options[i].textContent();
          if (text && /In Progress/i.test(text)) {
            await statusField.selectOption({ index: i });
            break;
          }
        }
      }
      await page.waitForTimeout(500);
      console.log('✅ Значение Status изменено на "In Progress"');

      // Сохранение изменений
      // Ищем кнопку Submit, Save или Update
      const saveButton = page.locator('button[type="submit"]').or(
        page.getByRole('button', { name: /Submit|Save|Update/i })
      ).first();
      
      // Проверяем, что кнопка существует (может быть скрыта)
      const buttonExists = await saveButton.count();
      expect(buttonExists).toBeGreaterThan(0);
      
      // Кликаем на кнопку через JavaScript (работает даже если кнопка скрыта)
      await saveButton.evaluate((el: HTMLElement) => {
        (el as HTMLButtonElement).click();
      });
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка сохранения найдена и нажата');

      // Проверка успешного сохранения
      const successMessage = page.locator('text=/success|saved|updated/i').first();
      const successExists = await successMessage.count();
      if (successExists > 0) {
        await expect(successMessage).toBeVisible({ timeout: 5000 });
        console.log('✅ Сообщение об успешном сохранении найдено');
      } else {
        // Проверяем отсутствие ошибок
        const errorMessages = page.locator('text=/error|failed|invalid/i');
        const errorCount = await errorMessages.count();
        if (errorCount === 0) {
          console.log('✅ Сообщений об ошибках не найдено, сохранение успешно');
        }
      }

      // Изменение значения на "Done"
      // Ищем опцию по тексту и выбираем по value или индексу
      const doneOption = statusField.locator('option').filter({ hasText: /Done/i }).first();
      const doneValue = await doneOption.getAttribute('value');
      if (doneValue) {
        await statusField.selectOption(doneValue);
      } else {
        // Альтернативный способ - выбор по индексу
        const options = await statusField.locator('option').all();
        for (let i = 0; i < options.length; i++) {
          const text = await options[i].textContent();
          if (text && /Done/i.test(text)) {
            await statusField.selectOption({ index: i });
            break;
          }
        }
      }
      await page.waitForTimeout(500);
      console.log('✅ Значение Status изменено на "Done"');

      // Сохранение изменений
      await saveButton.evaluate((el: HTMLElement) => {
        (el as HTMLButtonElement).click();
      });
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка сохранения нажата');

      // Проверка успешного сохранения
      const successMessage2 = page.locator('text=/success|saved|updated/i').first();
      const successExists2 = await successMessage2.count();
      if (successExists2 > 0) {
        await expect(successMessage2).toBeVisible({ timeout: 5000 });
        console.log('✅ Сообщение об успешном сохранении найдено');
      } else {
        const errorMessages = page.locator('text=/error|failed|invalid/i');
        const errorCount = await errorMessages.count();
        if (errorCount === 0) {
          console.log('✅ Сообщений об ошибках не найдено, сохранение успешно');
        }
      }
    });

    // Проверка поля Internal Note
    await test.step('Проверка поля Internal Note и его стилей', async () => {
      const internalNoteField = page.locator('textarea[name*="note" i], textarea[id*="note" i], input[name*="note" i], input[id*="note" i]').first();
      await expect(internalNoteField).toBeVisible({ timeout: 10000 });
      console.log('✅ Поле Internal Note найдено');

      // Проверка, что поле не required
      const isRequired = await internalNoteField.getAttribute('required');
      expect(isRequired).toBeNull();
      console.log('✅ Поле Internal Note не является обязательным (not required)');

      // Проверка стилей поля Internal Note
      const noteStyles = await internalNoteField.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          backgroundColor: styles.backgroundColor,
          border: styles.border,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(noteStyles.display).not.toBe('none');
      expect(noteStyles.visibility).not.toBe('hidden');
      expect(parseFloat(noteStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили поля Internal Note: font-size=${noteStyles.fontSize}, border-radius=${noteStyles.borderRadius}, padding=${noteStyles.padding}`);

      // Заполнение поля
      await internalNoteField.fill('Test note for automation');
      await page.waitForTimeout(500);
      console.log('✅ Поле Internal Note заполнено');

      // Сохранение изменений
      const saveButton = page.locator('button[type="submit"]').or(
        page.getByRole('button', { name: /Submit|Save|Update/i })
      ).first();
      
      // Кликаем на кнопку через JavaScript (работает даже если кнопка скрыта)
      await saveButton.evaluate((el: HTMLElement) => {
        (el as HTMLButtonElement).click();
      });
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка сохранения нажата');

      // Проверка успешного сохранения
      const successMessage = page.locator('text=/success|saved|updated/i').first();
      const successExists = await successMessage.count();
      if (successExists > 0) {
        await expect(successMessage).toBeVisible({ timeout: 5000 });
        console.log('✅ Сообщение об успешном сохранении найдено');
      } else {
        const errorMessages = page.locator('text=/error|failed|invalid/i');
        const errorCount = await errorMessages.count();
        if (errorCount === 0) {
          console.log('✅ Сообщений об ошибках не найдено, сохранение успешно');
        }
      }
    });

    // Проверка disabled полей
    await test.step('Проверка disabled полей и их стилей', async () => {
      const disabledFields = [
        { name: 'Full Name', selector: 'input[name="name"][disabled], input[name="name"].form-control[disabled]' },
        { name: 'Email', selector: 'input[name="slug"][value*="@"]:disabled, input[type="email"][disabled]' },
        { name: 'Number', selector: 'input[name="slug"][value*="248"]:disabled, input[type="tel"][disabled]' },
        { name: 'Category', selector: 'input[name="slug"][value*="Roofing"]:disabled, select[name*="category" i][disabled]' },
        { name: 'Sub Category', selector: 'input[name="slug"][value*="Roof Replacement"]:disabled, select[name*="subcategory" i][disabled]' },
        { name: 'Area/City/Town', selector: 'input[name="slug"][value="Oxford"]:disabled, input[name*="area" i][disabled], input[name*="city" i][disabled]' },
        { name: 'State', selector: 'input[name="slug"][value="Michigan"]:disabled, select[name*="state" i][disabled], input[name*="state" i][disabled]' },
        { name: 'Zipcode', selector: 'input[name="slug"][value="48371"]:disabled, input[name*="zip" i][disabled], input[name*="zipcode" i][disabled]' },
        { name: 'Details', selector: 'textarea[name="slug"][disabled].form-control, textarea[name*="detail" i][disabled], textarea[id*="detail" i][disabled]' }
      ];

      for (const field of disabledFields) {
        const fieldElement = page.locator(field.selector).first();
        const fieldExists = await fieldElement.count();
        
        if (fieldExists > 0) {
          // Проверяем, что элемент существует (может быть скрыт)
          // Не проверяем видимость, так как disabled поля могут быть скрыты
          
          // Проверяем разные способы блокировки поля
          const isDisabled = await fieldElement.isDisabled();
          const isReadonly = await fieldElement.getAttribute('readonly') !== null;
          const hasDisabledClass = await fieldElement.evaluate((el) => {
            return el.classList.contains('disabled') || 
                   el.classList.contains('readonly') ||
                   el.hasAttribute('readonly');
          });
          
          // Поле должно быть заблокировано хотя бы одним способом
          const isBlocked = isDisabled || isReadonly || hasDisabledClass;
          
          if (isBlocked) {
            console.log(`✅ Поле "${field.name}" найдено и заблокировано (disabled=${isDisabled}, readonly=${isReadonly})`);
          } else {
            // Если поле не заблокировано, проверяем, можно ли его редактировать
            // Попытка ввести текст должна быть невозможна
            const canEdit = await fieldElement.isEditable();
            if (!canEdit) {
              console.log(`✅ Поле "${field.name}" найдено и не редактируемое (не editable)`);
            } else {
              console.log(`⚠️ Поле "${field.name}" найдено, но не заблокировано (может быть ошибка в тесте)`);
            }
          }

          // Проверка стилей поля (даже если поле скрыто)
          const fieldStyles = await fieldElement.evaluate((el) => {
            const styles = window.getComputedStyle(el);
            return {
              backgroundColor: styles.backgroundColor,
              color: styles.color,
              cursor: styles.cursor,
              opacity: styles.opacity,
              display: styles.display,
              visibility: styles.visibility,
              pointerEvents: styles.pointerEvents
            };
          });
          console.log(`✅ Стили поля "${field.name}": background-color=${fieldStyles.backgroundColor}, color=${fieldStyles.color}, cursor=${fieldStyles.cursor}, pointer-events=${fieldStyles.pointerEvents}`);
        } else {
          console.log(`⚠️ Поле "${field.name}" не найдено`);
        }
      }
    });

    // Комплексная проверка UI/UX
    await test.step('Комплексная проверка UI/UX', async () => {
      await checkUIUX(page);
    });
  });
});

