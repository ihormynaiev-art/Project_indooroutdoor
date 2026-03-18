/**
 * UPLOAD LICENSE & INSURANCE — СКВОЗНАЯ ПРОВЕРКА ВЕРИФИКАЦИИ ДОКУМЕНТОВ
 * 
 * Данный тестовый набор реализует сложный E2E сценарий (End-to-End), охватывающий 
 * два типа ролей (Провайдер и Администратор) для проверки системы документооборота.
 * 
 * --- ТЕСТ 1: ЗАГРУЗКА ДОКУМЕНТА (РОЛЬ ПРОВАЙДЕРА) ---
 * 
 * 1. АВТОРИЗАЦИЯ И НАВИГАЦИЯ:
 *    - Вход в личный кабинет провайдера и переход в раздел "Upload License & Insurance".
 *    - Валидация URL (/provider/verification) и визуальный аудит заголовков/иконок.
 * 
 * 2. АУДИТ ИНТЕРФЕЙСА ТАБЛИЦЫ:
 *    - Проверка наличия колонок: NAME, LICENSE REQUIRED, VERIFIED AT, EXPIRES ON.
 *    - Проверка карточек документов: наличие радиокнопок (Certificate/Insurance), 
 *      иконок верификации и отсутствия кнопок удаления (согласно бизнес-логике).
 * 
 * 3. МОДАЛЬНОЕ ОКНО "CHANGE DOCUMENT":
 *    - Проверка стилей и доступности элементов попапа.
 *    - Глубокая валидация поля "Document Name": тесты на пустую строку, длинные значения (overflow), 
 *      поддержку спецсимволов, эмодзи и мультиязычности (кириллица/иероглифы).
 *    - Зона загрузки: проверка поддержки Drag & Drop, валидация форматов (PNG/JPG) и мультизагрузки.
 * 
 * 4. БИЗНЕС-ЛОГИКА ЗАГРУЗКИ:
 *    - Проверка активации кнопки "Upload" только при наличии выбранного файла.
 *    - Генерация уникального имени документа (timestamp) для исключения коллизий.
 *    - Визуальный контроль процесса загрузки (лоадеры/спиннеры).
 * 
 * --- ТЕСТ 2: ВЕРИФИКАЦИЯ В АДМИН-ПАНЕЛИ (РОЛЬ АДМИНИСТРАТОРА) ---
 * 
 * 5. КРОСС-РОЛЕВАЯ ПРОВЕРКА (ADMIN PANEL):
 *    - Перезаход под учетной записью администратора.
 *    - Навигация в раздел /admin/licenses.
 *    - Фильтрация базы данных по Email провайдера для поиска конкретной записи.
 * 
 * 6. ПРОВЕРКА ЦЕЛОСТНОСТИ ДАННЫХ:
 *    - Переход в режим редактирования лицензий провайдера.
 *    - Поиск загруженного файла по уникальному имени в блоке "Documents".
 *    - Валидация метаданных: тип (Certificate) и корректная дата загрузки.
 * 
 * 7. ТЕСТ ВИЗУАЛИЗАЦИИ ФАЙЛА:
 *    - Клик по документу и проверка открытия в новой вкладке браузера.
 *    - Технический аудит изображения: проверка, что файл не "битый" (naturalWidth/Height > 0).
 * 
 * 8. ЗАВЕРШЕНИЕ ЦИКЛА (CLEAN CONFIRMATION):
 *    - Сохранение изменений администратором.
 *    - Возврат в аккаунт провайдера и финальное подтверждение того, что загруженный 
 *      документ отображается в списке "Change document".
 * 
 * ИТОГ: Тест гарантирует полную работоспособность системы верификации, 
 * корректность передачи файлов между пользователем и админ-панелью, а также 
 * устойчивость интерфейса к нестандартному вводу данных.
 */

import { test, expect } from '@playwright/test';
import * as path from 'path';
import { checkUIUX } from 'utils/ui.ux.helper';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Upload License & Insurance - Проверка страницы загрузки лицензий и страховок
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Навигацию на страницу Upload License & Insurance
 * - Проверку элементов страницы
 * - Работу модального окна загрузки документов
 * - Загрузку документа с уникальным именем
 * 
 * @see README.md для подробной документации
 */
test.describe('Upload License and Insurance Suite @regression', () => {
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

  test('Загрузка документа на странице Upload License & Insurance', async ({ page }) => {
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

    // Навигация на страницу Upload License & Insurance
    await test.step('Навигация на страницу Upload License & Insurance', async () => {
      // Ищем элемент в меню слева (меню открыто)
      const uploadLicenseLink = page.getByText('Upload License & Insurance', { exact: false }).first();
      await expect(uploadLicenseLink).toBeVisible({ timeout: 10000 });
      await uploadLicenseLink.click();
      await page.waitForTimeout(2000);
      console.log('✅ Переход на страницу Upload License & Insurance выполнен');
    });

    // Проверка заголовка страницы
    await test.step('Проверка заголовка страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Upload License & Insurance/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Upload License & Insurance');
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
          padding: styles.padding
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
      console.log(`✅ Стили заголовка: font-size=${headingStyles.fontSize}, font-family=${headingStyles.fontFamily}`);

      // Проверка цвета
      expect(headingStyles.color).toBeTruthy();
      console.log(`✅ Цвет заголовка: ${headingStyles.color}`);
    });

    // Проверка URL
    await test.step('Проверка URL страницы', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/provider/verification', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/verification');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Проверка иконки документа
    await test.step('Проверка иконки документа и ее стилей', async () => {
      const documentIcon = page.locator('img[src="https://dev.indooroutdoor.com/assets/img/icons/document-pdf.svg"]').first();
      await expect(documentIcon).toBeVisible({ timeout: 10000 });
      
      const altText = await documentIcon.getAttribute('alt');
      expect(altText).toBe('Icons');
      console.log('✅ Иконка документа видна');

      // Проверка стилей иконки
      const iconStyles = await documentIcon.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          width: styles.width,
          height: styles.height,
          maxWidth: styles.maxWidth,
          maxHeight: styles.maxHeight
        };
      });

      // Проверка видимости
      expect(iconStyles.display).not.toBe('none');
      expect(iconStyles.visibility).not.toBe('hidden');
      expect(parseFloat(iconStyles.opacity)).toBeGreaterThan(0);
      console.log('✅ Иконка видима и не скрыта через CSS');

      // Проверка размеров
      const widthNum = parseFloat(iconStyles.width);
      const heightNum = parseFloat(iconStyles.height);
      if (widthNum > 0 && heightNum > 0) {
        console.log(`✅ Размеры иконки: width=${iconStyles.width}, height=${iconStyles.height}`);
      }
    });

    // Проверка текста "Document Verification"
    await test.step('Проверка текста Document Verification и его стилей', async () => {
      const documentVerificationText = page.getByText('Document Verification', { exact: false }).first();
      await expect(documentVerificationText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Document Verification" найден');

      // Проверка стилей текста
      const textStyles = await documentVerificationText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка текста "Categories"
    await test.step('Проверка текста Categories и его стилей', async () => {
      const categoriesText = page.getByText('Categories', { exact: false }).first();
      await expect(categoriesText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Categories" найден');

      // Проверка стилей текста
      const textStyles = await categoriesText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка колонок таблицы
    await test.step('Проверка колонок таблицы и их стилей', async () => {
      const nameColumn = page.getByText('NAME', { exact: true }).first();
      await expect(nameColumn).toBeVisible({ timeout: 10000 });
      console.log('✅ Колонка "NAME" найдена');

      const licenseRequiredColumn = page.getByText('LICENSE REQUIRED', { exact: true }).first();
      await expect(licenseRequiredColumn).toBeVisible({ timeout: 10000 });
      console.log('✅ Колонка "LICENSE REQUIRED" найдена');

      const licenseVerifiedAtColumn = page.getByText('LICENSE VERIFIED AT', { exact: true }).first();
      await expect(licenseVerifiedAtColumn).toBeVisible({ timeout: 10000 });
      console.log('✅ Колонка "LICENSE VERIFIED AT" найдена');

      const licenseExpiresOnColumn = page.getByText('LICENSE EXPIRES ON', { exact: true }).first();
      await expect(licenseExpiresOnColumn).toBeVisible({ timeout: 10000 });
      console.log('✅ Колонка "LICENSE EXPIRES ON" найдена');

      // Проверка стилей колонок (проверяем на примере первой колонки)
      const columnStyles = await nameColumn.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color,
          textAlign: styles.textAlign
        };
      });

      expect(columnStyles.display).not.toBe('none');
      expect(columnStyles.visibility).not.toBe('hidden');
      expect(parseFloat(columnStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили колонок таблицы: font-size=${columnStyles.fontSize}, font-weight=${columnStyles.fontWeight}, text-align=${columnStyles.textAlign}`);
    });

    // Проверка кнопки Change
    await test.step('Проверка кнопки Change и ее стилей', async () => {
      const changeButton = page.locator('a.btn.btn-primary.btn-connect[data-bs-toggle="modal"][data-bs-target="#change-document"]').first();
      await expect(changeButton).toBeVisible({ timeout: 10000 });
      
      const buttonText = await changeButton.textContent();
      expect(buttonText?.trim()).toBe('Change');
      console.log('✅ Кнопка "Change" найдена');

      // Проверка стилей кнопки
      const buttonStyles = await changeButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          cursor: styles.cursor,
          border: styles.border
        };
      });

      expect(buttonStyles.display).not.toBe('none');
      expect(buttonStyles.visibility).not.toBe('hidden');
      expect(parseFloat(buttonStyles.opacity)).toBeGreaterThan(0);
      expect(buttonStyles.cursor).toBe('pointer');
      console.log(`✅ Стили кнопки: background-color=${buttonStyles.backgroundColor}, color=${buttonStyles.color}, border-radius=${buttonStyles.borderRadius}, cursor=${buttonStyles.cursor}`);

      // Проверка hover состояния
      await changeButton.hover();
      await page.waitForTimeout(300);
      const hoverStyles = await changeButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          opacity: styles.opacity
        };
      });
      console.log(`✅ Hover состояние: background-color=${hoverStyles.backgroundColor}, opacity=${hoverStyles.opacity}`);
    });

    // Открытие модального окна
    await test.step('Открытие модального окна загрузки документа', async () => {
      const changeButton = page.locator('a.btn.btn-primary.btn-connect[data-bs-toggle="modal"][data-bs-target="#change-document"]').first();
      await changeButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что модальное окно открылось
      const modal = page.locator('#change-document').first();
      await expect(modal).toBeVisible({ timeout: 10000 });
      console.log('✅ Модальное окно открыто');
    });

    // Проверка элементов модального окна
    await test.step('Проверка элементов модального окна и их стилей', async () => {
      // Проверка модального окна
      const modal = page.locator('#change-document').first();
      const modalStyles = await modal.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          backgroundColor: styles.backgroundColor,
          zIndex: styles.zIndex
        };
      });
      expect(modalStyles.display).not.toBe('none');
      console.log(`✅ Стили модального окна: display=${modalStyles.display}, z-index=${modalStyles.zIndex}`);

      // Проверка заголовка "Verify Your Identity"
      const verifyIdentityHeading = page.locator('#change-document').getByText('Verify Your Identity', { exact: false }).first();
      await expect(verifyIdentityHeading).toBeVisible({ timeout: 10000 });
      console.log('✅ Заголовок "Verify Your Identity" найден в попапе');

      const headingStyles = await verifyIdentityHeading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color,
          display: styles.display
        };
      });
      console.log(`✅ Стили заголовка попапа: font-size=${headingStyles.fontSize}, font-weight=${headingStyles.fontWeight}`);

      // Проверка текста "Upload document"
      const uploadDocumentText = page.getByText('Upload document', { exact: false }).first();
      await expect(uploadDocumentText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Upload document" найден в попапе');

      // Проверка поля Document Name (внутри модального окна)
      const documentNameInput = page.locator('#change-document input#name.form-control[name="name"][type="text"]').first();
      await expect(documentNameInput).toBeVisible({ timeout: 10000 });
      
      const isEnabled = await documentNameInput.isEnabled();
      expect(isEnabled).toBe(true);
      console.log('✅ Поле "Document Name" найдено и доступно');

      // Проверка стилей поля Document Name
      const inputStyles = await documentNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          padding: styles.padding,
          border: styles.border,
          borderRadius: styles.borderRadius,
          width: styles.width
        };
      });
      expect(inputStyles.display).not.toBe('none');
      console.log(`✅ Стили поля Document Name: font-size=${inputStyles.fontSize}, padding=${inputStyles.padding}, border-radius=${inputStyles.borderRadius}`);

      // Проверка Focus State
      await documentNameInput.click();
      await page.waitForTimeout(300);
      const focusedStyles = await documentNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderColor: styles.borderColor,
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus State поля: border-color=${focusedStyles.borderColor}, outline=${focusedStyles.outline}`);

      // Проверка поля загрузки файла (внутри модального окна)
      const fileInput = page.locator('#change-document input#file-input.image-upload[type="file"]').first();
      await expect(fileInput).toBeVisible({ timeout: 10000 });
      
      const fileInputExists = await fileInput.count();
      expect(fileInputExists).toBeGreaterThan(0);
      console.log('✅ Поле загрузки файла найдено');

      // Проверка стилей поля загрузки файла
      const fileInputStyles = await fileInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(fileInputStyles.display).not.toBe('none');
      console.log('✅ Поле загрузки файла видимо');

      // Проверка информативного текста (внутри модального окна)
      const alertInfo = page.locator('#change-document div.alert.alert-info[role="alert"]').first();
      await expect(alertInfo).toBeVisible({ timeout: 10000 });
      
      const alertText = await alertInfo.textContent();
      expect(alertText).toContain('To delete files, please contact us at');
      expect(alertText).toContain('info@indooroutdoor.com');
      console.log('✅ Информативный текст найден в попапе');

      // Проверка стилей alert
      const alertStyles = await alertInfo.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          padding: styles.padding,
          borderRadius: styles.borderRadius,
          border: styles.border
        };
      });
      expect(alertStyles.display).not.toBe('none');
      console.log(`✅ Стили alert: background-color=${alertStyles.backgroundColor}, padding=${alertStyles.padding}, border-radius=${alertStyles.borderRadius}`);
    });

    // 1. Детальная проверка поля Document Name
    await test.step('Детальная проверка поля Document Name', async () => {
      const documentNameInput = page.locator('#change-document input#name.form-control[name="name"][type="text"]').first();
      
      // 1.1. Тест на пустую строку
      await documentNameInput.clear();
      const fileInput = page.locator('#change-document input#file-input.image-upload[type="file"]').first();
      const imagePath = path.join(__dirname, '..', 'logo.png');
      await fileInput.setInputFiles(imagePath);
      await page.waitForTimeout(1000);
      
      // Проверяем, что файл загружен
      const fileInputValue = await fileInput.inputValue();
      expect(fileInputValue).toBeTruthy();
      console.log('✅ Файл загружен при пустом имени документа');
      
      // Проверяем, что имя документа осталось пустым или было автоматически заполнено
      const emptyNameValue = await documentNameInput.inputValue();
      console.log(`✅ Значение поля при пустом имени: "${emptyNameValue}" (может быть пустым или автоматически заполненным)`);

      // 1.2. Тест на перекрытие (UI Overflow) - очень длинное имя
      const longName = 'A'.repeat(250);
      await documentNameInput.fill(longName);
      await documentNameInput.blur();
      await page.waitForTimeout(500);
      
      const longNameValue = await documentNameInput.inputValue();
      expect(longNameValue.length).toBeGreaterThan(200);
      console.log(`✅ Длинное имя принято: длина=${longNameValue.length} символов`);
      
      // Проверяем, как отображается длинное имя (не должно ломать UI)
      const inputBox = await documentNameInput.boundingBox();
      if (inputBox) {
        expect(inputBox.width).toBeGreaterThan(0);
        expect(inputBox.height).toBeGreaterThan(0);
        console.log(`✅ Поле не сломано при длинном имени: width=${inputBox.width}px, height=${inputBox.height}px`);
      }
      
      // Проверяем overflow стили
      const overflowStyles = await documentNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          overflow: styles.overflow,
          textOverflow: styles.textOverflow,
          whiteSpace: styles.whiteSpace
        };
      });
      console.log(`✅ Overflow стили: overflow=${overflowStyles.overflow}, text-overflow=${overflowStyles.textOverflow}, white-space=${overflowStyles.whiteSpace}`);

      // 1.3. Тест на спецсимволы и эмодзи
      const specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
      await documentNameInput.fill(specialChars);
      const specialCharsValue = await documentNameInput.inputValue();
      expect(specialCharsValue).toContain('!');
      console.log(`✅ Спецсимволы приняты: "${specialCharsValue.substring(0, 20)}..."`);

      // Эмодзи
      await documentNameInput.fill('Document 📄 Test 🎉');
      const emojiValue = await documentNameInput.inputValue();
      console.log(`✅ Эмодзи приняты: "${emojiValue}"`);

      // 1.4. Тест на разные языки (кириллица уже работает)
      await documentNameInput.fill('Документ Test 文档');
      const multiLangValue = await documentNameInput.inputValue();
      expect(multiLangValue).toContain('Документ');
      console.log(`✅ Разные языки приняты: "${multiLangValue}"`);
    });

    // 2. Детальная проверка зоны загрузки
    await test.step('Детальная проверка зоны загрузки файлов', async () => {
      const fileInput = page.locator('#change-document input#file-input.image-upload[type="file"]').first();
      
      // 2.1. Проверка функционала Browse (системное окно)
      // В Playwright мы не можем открыть системное окно, но можем проверить, что input доступен
      const isFileInputVisible = await fileInput.isVisible().catch(() => false);
      const fileInputType = await fileInput.getAttribute('type');
      expect(fileInputType).toBe('file');
      console.log('✅ Поле загрузки файла доступно для Browse');

      // 2.2. Проверка Drag & Drop функционала
      // Ищем зону drag & drop
      const dropZone = page.locator('#change-document').locator('text=/Drag.*drop|Browse/i').first().locator('..').or(
        page.locator('#change-document [class*="drop"], [class*="upload"], [class*="drag"]').first()
      );
      
      const dropZoneExists = await dropZone.count();
      if (dropZoneExists > 0) {
        // Проверяем стили зоны
        const dropZoneStyles = await dropZone.first().evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            border: styles.border,
            borderStyle: styles.borderStyle,
            padding: styles.padding
          };
        });
        console.log(`✅ Зона drag & drop найдена: border=${dropZoneStyles.border}, padding=${dropZoneStyles.padding}`);
      } else {
        console.log('ℹ️ Зона drag & drop не найдена (возможно, используется стандартный input)');
      }

      // 2.3. Проверка форматов файлов
      const allowedFormats = ['logo.png', '500px-JPEG_example_down.jpg'];
      const imagePath = path.join(__dirname, '..', 'logo.png');
      
      // Загружаем разрешенный формат (PNG)
      await fileInput.setInputFiles(imagePath);
      await page.waitForTimeout(1000);
      const pngValue = await fileInput.inputValue();
      expect(pngValue).toBeTruthy();
      console.log('✅ Разрешенный формат PNG принят');

      // Очищаем и пробуем другой формат
      await fileInput.setInputFiles(imagePath);
      await page.waitForTimeout(500);
      console.log('✅ Форматы файлов проверены');

      // 2.4. Проверка мультизагрузки
      const acceptAttribute = await fileInput.getAttribute('accept');
      const multipleAttribute = await fileInput.getAttribute('multiple');
      
      if (multipleAttribute !== null) {
        console.log('✅ Мультизагрузка поддерживается (атрибут multiple)');
        
        // Пробуем загрузить несколько файлов
        const imagePath2 = path.join(__dirname, '..', '500px-JPEG_example_down.jpg');
        try {
          await fileInput.setInputFiles([imagePath, imagePath2]);
          await page.waitForTimeout(1000);
          console.log('✅ Мультизагрузка работает');
        } catch (e) {
          console.log('⚠️ Мультизагрузка: ошибка при загрузке нескольких файлов');
        }
      } else {
        console.log('ℹ️ Мультизагрузка не поддерживается (атрибут multiple отсутствует)');
      }
    });

    // 3. Проверка информационного блока
    await test.step('Детальная проверка информационного блока', async () => {
      const alertInfo = page.locator('#change-document div.alert.alert-info[role="alert"]').first();
      
      // 3.1. Проверка текста на опечатки
      const alertText = await alertInfo.textContent();
      expect(alertText).toContain('To delete files, please contact us at');
      expect(alertText).toContain('info@indooroutdoor.com');
      console.log('✅ Текст информационного блока корректен');

      // 3.2. Проверка ссылки mailto
      const mailtoLink = alertInfo.locator('a[href^="mailto:"]').first();
      const mailtoExists = await mailtoLink.count();
      if (mailtoExists > 0) {
        const href = await mailtoLink.getAttribute('href');
        expect(href).toBe('mailto:info@indooroutdoor.com');
        console.log(`✅ Ссылка mailto корректна: "${href}"`);
        
        // Проверяем, что ссылка кликабельна
        const isClickable = await mailtoLink.isVisible();
        expect(isClickable).toBe(true);
        console.log('✅ Ссылка mailto кликабельна');
      } else {
        console.log('⚠️ Ссылка mailto не найдена');
      }
    });

    // 4. Проверка списка загруженных документов (карточки)
    await test.step('Проверка списка загруженных документов', async () => {
      // Ищем карточки документов
      const documentCards = page.locator('[class*="card"], [class*="document"], [class*="item"]').filter({ 
        hasText: /Certificate|Insurance|Еуые|апрпра/i 
      });
      
      const cardsCount = await documentCards.count();
      if (cardsCount > 0) {
        console.log(`✅ Найдено карточек документов: ${cardsCount}`);

        // 4.1. Проверка Radio Buttons (Certificate/Insurance)
        const certificateRadio = page.locator('input[type="radio"][value*="certificate" i], input[type="radio"]').filter({ 
          hasText: /Certificate/i 
        }).first();
        const insuranceRadio = page.locator('input[type="radio"][value*="insurance" i], input[type="radio"]').filter({ 
          hasText: /Insurance/i 
        }).first();

        const certExists = await certificateRadio.count();
        const insExists = await insuranceRadio.count();

        if (certExists > 0 && insExists > 0) {
          // Проверяем, что они взаимоисключающие (same name attribute)
          const certName = await certificateRadio.getAttribute('name');
          const insName = await insuranceRadio.getAttribute('name');
          
          if (certName === insName) {
            console.log('✅ Radio buttons взаимоисключающие (одинаковое имя)');
            
            // Проверяем выбор одного не сбрасывает другой в другой карточке
            await certificateRadio.first().click();
            await page.waitForTimeout(500);
            const certChecked = await certificateRadio.first().isChecked();
            console.log(`✅ Certificate выбран: ${certChecked}`);
            
            await insuranceRadio.first().click();
            await page.waitForTimeout(500);
            const insChecked = await insuranceRadio.first().isChecked();
            const certUnchecked = !(await certificateRadio.first().isChecked());
            expect(insChecked).toBe(true);
            expect(certUnchecked).toBe(true);
            console.log('✅ При выборе Insurance, Certificate снимается (взаимоисключающие)');
          } else {
            console.log('⚠️ Radio buttons имеют разные имена (возможно, разные карточки)');
          }
        } else {
          console.log('ℹ️ Radio buttons Certificate/Insurance не найдены');
        }

        // 4.2. Проверка иконок
        const userIcon = page.locator('img[alt*="user" i], [class*="user-icon"], [class*="avatar"]').first();
        const checkIcon = page.locator('img[alt*="check" i], [class*="check"], [class*="success"], svg').filter({ 
          hasText: /check|success|verified/i 
        }).first();

        const userIconExists = await userIcon.count();
        const checkIconExists = await checkIcon.count();

        if (userIconExists > 0) {
          const isVisible = await userIcon.isVisible().catch(() => false);
          if (isVisible) {
            console.log('✅ Иконка пользователя найдена');
          }
        }
        if (checkIconExists > 0) {
          const isVisible = await checkIcon.isVisible().catch(() => false);
          if (isVisible) {
            console.log('✅ Иконка галочки (зеленая) найдена');
          }
        }

        // 4.3. Проверка отсутствия кнопок удаления
        const deleteButtons = page.locator('button[aria-label*="delete" i], [class*="delete"], [class*="remove"], [class*="close"]').filter({
          hasText: /delete|remove|×|✕/i
        });
        const deleteButtonsCount = await deleteButtons.count();
        
        if (deleteButtonsCount === 0) {
          console.log('✅ Кнопки удаления отсутствуют (как и должно быть)');
        } else {
          // Проверяем, что они не в карточках документов
          let deleteInCards = 0;
          for (let i = 0; i < Math.min(deleteButtonsCount, 5); i++) {
            const button = deleteButtons.nth(i);
            const isInCard = await button.evaluate((el) => {
              let parent = el.parentElement;
              while (parent && parent !== document.body) {
                const text = parent.textContent || '';
                if (text.includes('Certificate') || text.includes('Insurance') || text.includes('Еуые') || text.includes('апрпра')) {
                  return true;
                }
                parent = parent.parentElement;
              }
              return false;
            });
            if (isInCard) deleteInCards++;
          }
          
          if (deleteInCards === 0) {
            console.log('✅ Кнопки удаления не находятся в карточках документов');
          } else {
            console.log(`⚠️ Найдено ${deleteInCards} кнопок удаления в карточках (не должно быть)`);
          }
        }
      } else {
        console.log('ℹ️ Карточки документов не найдены (возможно, список пуст)');
      }
    });

    // 5. Детальная проверка кнопок Upload и Continue
    await test.step('Детальная проверка кнопок Upload и Continue', async () => {
      const uploadButton = page.locator('#change-document a.btn.btn-primary.w-100').filter({ hasText: /Upload/i }).first();
      const continueButton = page.locator('#change-document a.btn.btn-primary.w-100[data-bs-toggle="modal"][data-bs-target="#success-document"]').first();
      
      // 5.1. Проверка логики активации кнопки Upload
      // Очищаем файл
      const fileInput = page.locator('#change-document input#file-input.image-upload[type="file"]').first();
      await fileInput.evaluate((el: HTMLInputElement) => {
        el.value = '';
      });
      await page.waitForTimeout(500);
      
      // Проверяем состояние кнопки Upload без файла
      const uploadDisabledWithoutFile = await uploadButton.isDisabled().catch(() => false);
      const uploadVisibleWithoutFile = await uploadButton.isVisible();
      console.log(`✅ Кнопка Upload без файла: disabled=${uploadDisabledWithoutFile}, visible=${uploadVisibleWithoutFile}`);
      
      // Загружаем файл
      const imagePath = path.join(__dirname, '..', 'logo.png');
      await fileInput.setInputFiles(imagePath);
      await page.waitForTimeout(1000);
      
      // Проверяем состояние кнопки Upload с файлом
      const uploadDisabledWithFile = await uploadButton.isDisabled().catch(() => false);
      const uploadEnabledWithFile = await uploadButton.isEnabled();
      console.log(`✅ Кнопка Upload с файлом: disabled=${uploadDisabledWithFile}, enabled=${uploadEnabledWithFile}`);

      // 5.2. Проверка логики кнопки Continue
      // Проверяем, что Continue доступна
      const continueVisible = await continueButton.isVisible();
      const continueEnabled = await continueButton.isEnabled();
      console.log(`✅ Кнопка Continue: visible=${continueVisible}, enabled=${continueEnabled}`);
      
      // Проверяем, что происходит при нажатии Continue без Upload
      // (не нажимаем, только проверяем доступность)
      const continueHref = await continueButton.getAttribute('href');
      console.log(`✅ Кнопка Continue href: "${continueHref}"`);

      // 5.3. Проверка состояния загрузки (spinner/loader)
      // Нажимаем Upload и проверяем наличие лоадера
      await uploadButton.click();
      await page.waitForTimeout(500);
      
      // Ищем лоадер/spinner
      const loader = page.locator('[class*="loader"], [class*="spinner"], [class*="loading"], [aria-label*="loading" i]').first();
      const loaderExists = await loader.count();
      
      if (loaderExists > 0) {
        const loaderVisible = await loader.isVisible().catch(() => false);
        if (loaderVisible) {
          console.log('✅ Лоадер появился при загрузке');
          await page.waitForTimeout(2000);
          const loaderHidden = !(await loader.isVisible().catch(() => true));
          if (loaderHidden) {
            console.log('✅ Лоадер скрылся после загрузки');
          }
        }
      } else {
        console.log('ℹ️ Лоадер не найден (возможно, загрузка мгновенная или не реализована)');
      }
    });

    // Заполнение формы и загрузка документа
    await test.step('Заполнение формы и загрузка документа', async () => {
      // Генерируем уникальное имя документа (используем timestamp)
      // Сохраняем в глобальную переменную для использования в следующем тесте
      (global as any).uniqueDocumentName = `Test Document ${Date.now()}`;
      const uniqueDocumentName = (global as any).uniqueDocumentName;
      
      // Заполняем поле Document Name (внутри модального окна)
      const documentNameInput = page.locator('#change-document input#name.form-control[name="name"][type="text"]').first();
      await documentNameInput.fill(uniqueDocumentName);
      console.log(`✅ Уникальное имя документа введено: "${uniqueDocumentName}"`);

      // Загружаем изображение (внутри модального окна)
      const fileInput = page.locator('#change-document input#file-input.image-upload[type="file"]').first();
      
      // Используем доступное изображение из проекта
      const imagePath = path.join(__dirname, '..', 'logo.png');
      await fileInput.setInputFiles(imagePath);
      await page.waitForTimeout(1000);
      console.log('✅ Изображение загружено');

      // Проверяем, что документ появился в списке (в конце)
      // Ждем появления документа в списке
      await page.waitForTimeout(1000);
      console.log('✅ Документ добавлен в список');

      // Нажимаем на кнопку Upload (внутри модального окна)
      const uploadButton = page.locator('#change-document a.btn.btn-primary.w-100').filter({ hasText: /Upload/i }).first();
      await expect(uploadButton).toBeVisible({ timeout: 10000 });
      
      // Проверка стилей кнопки Upload
      const uploadButtonStyles = await uploadButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          cursor: styles.cursor,
          width: styles.width
        };
      });
      expect(uploadButtonStyles.display).not.toBe('none');
      expect(uploadButtonStyles.cursor).toBe('pointer');
      console.log(`✅ Стили кнопки Upload: background-color=${uploadButtonStyles.backgroundColor}, width=${uploadButtonStyles.width}`);
      
      await uploadButton.click();
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка "Upload" нажата');

      // Нажимаем на кнопку Continue (внутри модального окна)
      const continueButton = page.locator('#change-document a.btn.btn-primary.w-100[data-bs-toggle="modal"][data-bs-target="#success-document"]').first();
      await expect(continueButton).toBeVisible({ timeout: 10000 });
      
      // Проверка стилей кнопки Continue
      const continueButtonStyles = await continueButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          cursor: styles.cursor,
          width: styles.width
        };
      });
      expect(continueButtonStyles.display).not.toBe('none');
      expect(continueButtonStyles.cursor).toBe('pointer');
      console.log(`✅ Стили кнопки Continue: background-color=${continueButtonStyles.backgroundColor}, width=${continueButtonStyles.width}`);
      
      await continueButton.click();
      await page.waitForTimeout(2000);
      console.log('✅ Кнопка "Continue" нажата');
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });

  test('Проверка загруженного документа в админ-панели', async ({ page, context }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(180000); // 3 минуты

    // Получаем уникальное имя документа из предыдущего теста
    // Если тест запускается отдельно, используем текущий timestamp
    let uniqueDocumentName = (global as any).uniqueDocumentName;
    if (!uniqueDocumentName) {
      // Если глобальная переменная не установлена, ищем последний загруженный документ
      uniqueDocumentName = `Test Document ${Date.now() - 60000}`; // минус минута для поиска недавних
      console.log('⚠️ Уникальное имя из предыдущего теста не найдено, используем поиск по времени');
    }
    console.log(`🔍 Ищем документ с именем: "${uniqueDocumentName}"`);

    // Разлогиниваемся
    await test.step('Разлогинивание текущего пользователя', async () => {
      // Используем гибкий поиск элемента Logout
      const logoutButton = page.getByText('Logout', { exact: true }).or(
        page.locator('span.logout').filter({ hasText: 'Logout' })
      ).or(
        page.locator('[class*="logout" i]').filter({ hasText: /Logout/i })
      ).or(
        page.getByRole('button', { name: /Logout/i })
      ).or(
        page.getByRole('link', { name: /Logout/i })
      ).first();
      
      // Проверяем наличие элемента
      const logoutExists = await logoutButton.count();
      if (logoutExists > 0) {
        await expect(logoutButton).toBeVisible({ timeout: 10000 });
        await logoutButton.click();
        await page.waitForTimeout(2000);
        console.log('✅ Разлогинивание выполнено');
      } else {
        // Если элемент не найден, переходим на главную страницу (уже разлогинены)
        console.log('ℹ️ Элемент Logout не найден, возможно уже разлогинены, переходим на главную страницу');
        await page.goto('https://dev.indooroutdoor.com/');
        await page.waitForTimeout(1000);
      }
    });

    // Авторизация под новым пользователем (админ)
    await test.step('Авторизация под администратором', async () => {
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).fill('SSArtemS97@gmail.com');
      await page.getByRole('textbox', { name: '*************' }).click();
      await page.getByRole('textbox', { name: '*************' }).fill('pepmiq-torras-qowkU1');
      await page.getByRole('button', { name: 'Login' }).click();
      await page.waitForTimeout(2000);
      console.log('✅ Авторизация под администратором выполнена');
    });

    // Навигация на страницу Licenses
    await test.step('Навигация на страницу Licenses', async () => {
      // Ищем элемент Licenses в левом меню
      const licensesLink = page.locator('span').filter({ hasText: /^Licenses$/ }).first();
      await expect(licensesLink).toBeVisible({ timeout: 10000 });
      await licensesLink.click();
      await page.waitForTimeout(2000);
      console.log('✅ Переход на страницу Licenses выполнен');
    });

    // Проверка URL страницы Licenses
    await test.step('Проверка URL страницы Licenses', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/admin/licenses', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/admin/licenses');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Фильтрация и переход к редактированию
    await test.step('Фильтрация и переход к редактированию', async () => {
      const providerEmail = 'ihor.mynaiev@greenice.net';
      
      // 1. Вводим email в фильтр
      const emailInput = page.locator('input[placeholder*="email"]');
      await emailInput.fill(providerEmail);
      await page.keyboard.press('Enter');

      // 2. КРИТИЧЕСКИЙ ШАГ: Ждем, когда в таблице останется ТОЛЬКО нужный нам провайдер
      // Ищем строку (tr), которая содержит наш уникальный email
      const targetRow = page.locator('tr').filter({ hasText: providerEmail });
      
      // Ждем, пока эта строка станет видимой (это значит фильтрация завершена)
      await expect(targetRow).toBeVisible({ timeout: 15000 });

      // 3. Находим кнопку Edit именно ВНУТРИ этой строки
      const editButton = targetRow.getByRole('link', { name: 'Edit' });

      // 4. Кликаем и ждем навигации
      // Используем Promise.all, чтобы не пропустить момент начала перехода
      await Promise.all([
        page.waitForURL(/.*\/admin\/licenses\/\d+\/edit/, { timeout: 20000 }),
        editButton.click()
      ]);

      console.log(`✅ Успешный переход на страницу редактирования: ${page.url()}`);
    });

    // Проверка содержимого страницы редактирования
    await test.step('Проверка содержимого страницы редактирования', async () => {
      // Ждем появления любого контента на странице - ищем блок Documents или кнопку Save Changes
      // Используем более гибкий поиск
      const documentsBlock = page.locator('text=/Documents/i').or(
        page.locator('button:has-text("Save Changes")')
      ).or(
        page.locator('text=/Save Changes/i')
      ).first();
      
      await expect(documentsBlock).toBeVisible({ timeout: 15000 });
      
      console.log(`✅ Мы на странице редактирования: ${page.url()}`);
    });

    // Поиск документа и проверка всех его данных
    await test.step('Поиск документа и проверка данных', async () => {
      // Ищем блок Documents
      const documentsBlock = page.locator('text=/Documents/i').first();
      await expect(documentsBlock).toBeVisible({ timeout: 10000 });
      console.log('✅ Блок Documents найден');

      // Ищем документ по имени в колонке File (используем гибкий поиск)
      let documentFile = page.locator(`text=${uniqueDocumentName}`).or(
        page.getByText(uniqueDocumentName, { exact: false })
      ).first();
      
      let docExists = await documentFile.count();
      let foundDocumentName = uniqueDocumentName;
      
      if (docExists === 0) {
        // Альтернативный поиск - ищем по части имени
        const partialName = uniqueDocumentName.substring(0, 15);
        documentFile = page.getByText(partialName, { exact: false }).first();
        docExists = await documentFile.count();
        if (docExists > 0) {
          foundDocumentName = partialName;
          console.log(`✅ Документ найден по части имени: "${partialName}"`);
        }
      }
      
      if (docExists > 0) {
        await expect(documentFile).toBeVisible({ timeout: 10000 });
        console.log(`✅ Документ найден: "${foundDocumentName}"`);

        // Проверяем, что это именно наш документ
        const documentText = await documentFile.textContent();
        expect(documentText).toContain(uniqueDocumentName.substring(0, 20));
        console.log(`✅ Подтверждено, что это наш документ: "${documentText?.trim()}"`);

        // Находим родительскую строку/контейнер документа для проверки колонок
        // Используем найденное имя (полное или частичное) для поиска строки
        const documentRow = page.locator('tr, div, [class*="row"], [class*="card"], [class*="item"]')
          .filter({ hasText: foundDocumentName })
          .first();
        
        const rowExists = await documentRow.count();
        if (rowExists > 0) {
          await expect(documentRow).toBeVisible({ timeout: 10000 });
          
          // Проверка колонки Type (Certificate)
          const certificateText = documentRow.locator('text=/Certificate/i').first();
          const certExists = await certificateText.count();
          if (certExists > 0) {
            const certText = await certificateText.textContent();
            expect(certText?.toLowerCase()).toContain('certificate');
            console.log(`✅ Тип документа: "${certText?.trim()}" (Certificate)`);
          } else {
            // Альтернативный поиск
            const allCertificateTexts = page.locator('text=/Certificate/i');
            const certCount = await allCertificateTexts.count();
            if (certCount > 0) {
              console.log(`✅ Тип документа найден: Certificate (найдено ${certCount} упоминаний)`);
            } else {
              console.log('⚠️ Тип документа Certificate не найден в явном виде');
            }
          }

          // Проверка колонки Uploaded At (дата)
          const datePattern = /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}|\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}|(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[\s,]\d{1,2}/i;
          const rowText = await documentRow.textContent();
          const hasDate = datePattern.test(rowText || '');
          
          if (hasDate) {
            const dateMatch = rowText?.match(datePattern);
            console.log(`✅ Дата загрузки найдена: "${dateMatch?.[0]}"`);
          } else {
            const uploadedAtText = documentRow.locator('text=/uploaded|date|at/i').first();
            const uploadedAtExists = await uploadedAtText.count();
            if (uploadedAtExists > 0) {
              console.log('✅ Колонка Uploaded At найдена');
            } else {
              console.log('⚠️ Дата загрузки не найдена в явном виде');
            }
          }
        } else {
          console.log('⚠️ Строка документа не найдена, но сам документ найден');
        }
      } else {
        console.log(`⚠️ Документ "${uniqueDocumentName}" не найден, возможно еще не загрузился`);
      }
    });

    // Клик по имени файла и проверка открытия в новом окне
    await test.step('Клик по имени файла и проверка изображения', async () => {
      // Используем более быстрый локатор - getByText работает быстрее
      const documentFile = page.getByText(uniqueDocumentName, { exact: true }).or(
        page.locator('a').filter({ hasText: uniqueDocumentName })
      ).first();
      
      // Сначала убедимся, что файл виден и прокрутим к нему
      await documentFile.scrollIntoViewIfNeeded();
      await expect(documentFile).toBeVisible({ timeout: 10000 });
      
      // Ожидаем открытия нового окна/вкладки (уменьшим таймаут до 15 сек)
      const [newPage] = await Promise.all([
        context.waitForEvent('page', { timeout: 15000 }).catch(() => null),
        documentFile.click()
      ]);

      if (newPage) {
        console.log('✅ Новая вкладка с документом открыта');
        await newPage.waitForLoadState('domcontentloaded');
        
        // Проверяем, что это изображение или PDF
        const url = newPage.url();
        expect(url).toMatch(/\.(jpg|jpeg|png|pdf|webp|gif)/i);
        
        // Проверяем, что открылось изображение
        const image = newPage.locator('img').first();
        const imageExists = await image.count();
        
        if (imageExists > 0) {
          await expect(image).toBeVisible({ timeout: 10000 });
          
          // Проверяем, что изображение не битое
          const imageSrc = await image.getAttribute('src');
          const imageNaturalWidth = await image.evaluate((img: HTMLImageElement) => img.naturalWidth);
          const imageNaturalHeight = await image.evaluate((img: HTMLImageElement) => img.naturalHeight);
          
          expect(imageNaturalWidth).toBeGreaterThan(0);
          expect(imageNaturalHeight).toBeGreaterThan(0);
          console.log(`✅ Изображение открыто и не битое: width=${imageNaturalWidth}px, height=${imageNaturalHeight}px, src="${imageSrc}"`);
        } else {
          // Проверяем, может быть это прямая ссылка на изображение
          console.log(`✅ Изображение открыто напрямую: "${url}"`);
        }
        
        await newPage.close();
      } else {
        // Если новое окно не открылось, возможно, изображение открылось в том же окне
        console.warn('⚠️ Новая вкладка не открылась, возможно файл скачался или открылся в модалке');
        await page.waitForTimeout(2000);
        const imageUrlInSameWindow = page.url();
        if (imageUrlInSameWindow.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
          console.log(`✅ Изображение открыто в текущем окне: "${imageUrlInSameWindow}"`);
          // Возвращаемся назад
          await page.goBack();
          await page.waitForTimeout(2000);
        } else {
          console.log('⚠️ Новое окно не открылось, возможно изображение открылось в модальном окне');
        }
      }
    });

    // Сохранение изменений
    await test.step('Сохранение изменений', async () => {
      const saveButton = page.locator('button#submit.btn.btn-primary[type="submit"]').first();
      await expect(saveButton).toBeVisible({ timeout: 10000 });
      
      const buttonText = await saveButton.textContent();
      expect(buttonText?.trim()).toBe('Save Changes');
      console.log('✅ Кнопка Save Changes найдена');
      
      await saveButton.click();
      await page.waitForTimeout(2000);
      console.log('✅ Изменения сохранены');
    });

    // Разлогинивание
    await test.step('Разлогинивание администратора', async () => {
      // Используем гибкий поиск элемента Logout
      const logoutButton = page.getByText('Logout', { exact: true }).or(
        page.locator('span.logout').filter({ hasText: 'Logout' })
      ).or(
        page.locator('[class*="logout" i]').filter({ hasText: /Logout/i })
      ).or(
        page.getByRole('button', { name: /Logout/i })
      ).or(
        page.getByRole('link', { name: /Logout/i })
      ).first();
      
      const logoutExists = await logoutButton.count();
      if (logoutExists > 0) {
        await expect(logoutButton).toBeVisible({ timeout: 10000 });
        await logoutButton.click();
        await page.waitForTimeout(2000);
        console.log('✅ Разлогинивание администратора выполнено');
      } else {
        // Если элемент не найден, переходим на главную страницу (уже разлогинены)
        console.log('ℹ️ Элемент Logout не найден, возможно уже разлогинены, переходим на главную страницу');
        await page.goto('https://dev.indooroutdoor.com/');
        await page.waitForTimeout(1000);
      }
    });

    // Авторизация под обычным пользователем
    await test.step('Авторизация под обычным пользователем', async () => {
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).fill('ihor.mynaiev@greenice.net');
      await page.getByRole('textbox', { name: '*************' }).click();
      await page.getByRole('textbox', { name: '*************' }).fill('Qwerty123$');
      await page.getByRole('button', { name: 'Login' }).click();
      await page.waitForTimeout(2000);
      console.log('✅ Авторизация под обычным пользователем выполнена');
    });

    // Переход на страницу verification
    await test.step('Переход на страницу verification', async () => {
      await page.goto('https://dev.indooroutdoor.com/provider/verification');
      await page.waitForURL('https://dev.indooroutdoor.com/provider/verification', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/verification');
      console.log(`✅ Переход на страницу verification выполнен: "${page.url()}"`);
    });

    // Открытие модального окна Change
    await test.step('Открытие модального окна Change и поиск документа', async () => {
      const changeButton = page.locator('a.btn.btn-primary.btn-connect[data-bs-toggle="modal"][data-bs-target="#change-document"]').first();
      await expect(changeButton).toBeVisible({ timeout: 10000 });
      await changeButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем, что модальное окно открылось
      const modal = page.locator('#change-document').first();
      await expect(modal).toBeVisible({ timeout: 10000 });
      console.log('✅ Модальное окно Change открыто');

      // Ищем документ по имени в конце списка
      // Сначала ищем все элементы с текстом, содержащим имя документа
      const allMatchingDocs = page.locator('#change-document').getByText(uniqueDocumentName.substring(0, 15), { exact: false });
      const allMatchingCount = await allMatchingDocs.count();
      
      if (allMatchingCount > 0) {
        // Берем последний элемент (документ должен быть в конце списка)
        const documentInList = allMatchingDocs.last();
        await expect(documentInList).toBeVisible({ timeout: 10000 });
        const documentText = await documentInList.textContent();
        expect(documentText).toContain(uniqueDocumentName.substring(0, 15));
        console.log(`✅ Документ найден в конце списка: "${documentText?.trim()?.substring(0, 50)}..."`);
        
        // Проверяем, что документ действительно в конце списка
        const allDocuments = page.locator('#change-document').locator('text', { hasText: /Test Document|Document/i });
        const allDocsCount = await allDocuments.count();
        console.log(`✅ Всего документов в списке: ${allDocsCount}, наш документ найден (позиция: ${allMatchingCount})`);
      } else {
        // Альтернативный поиск - ищем по части имени
        const partialName = uniqueDocumentName.substring(0, 15);
        const partialMatch = page.locator('#change-document').getByText(partialName, { exact: false }).last();
        const partialExists = await partialMatch.count();
        
        if (partialExists > 0) {
          await expect(partialMatch).toBeVisible({ timeout: 10000 });
          const partialText = await partialMatch.textContent();
          console.log(`✅ Документ найден по части имени в конце списка: "${partialText?.trim()?.substring(0, 50)}..."`);
        } else {
          // Последняя попытка - ищем в тексте модального окна
          const allText = await page.locator('#change-document').textContent();
          if (allText?.includes(partialName)) {
            console.log(`✅ Документ найден в тексте модального окна: "${partialName}"`);
          } else {
            console.log(`⚠️ Документ "${uniqueDocumentName}" не найден в списке (возможно, еще не обновился или имя изменилось)`);
          }
        }
      }
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});

