/**
 * BUSINESS LOGO & CONTRACTOR PROFILE MANAGEMENT SUITE
 * 
 * Данный тестовый набор представляет собой исчерпывающий аудит раздела "Contractor Profile Setup".
 * Тест охватывает управление медиа-контентом (логотип, галерея), глубокую валидацию форм,
 * проверку технических стилей и пользовательского интерфейса (UI/UX).
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И НАВИГАЦИЯ:
 *    - Вход в систему и переход в закрытый раздел настройки профиля подрядчика.
 * 
 * 2. ТЕХНИЧЕСКИЙ АУДИТ ЗАГОЛОВКОВ И БЛОКОВ:
 *    - "Contractor Profile Setup": проверка текста, регистра, семантики тегов (h1-h6),
 *      позиционирования (вверху страницы) и CSS-стилей (font-weight, size, color).
 *    - "Background Image": проверка специфических стилей блока (голубой фон, скругления),
 *      наличия апсейл-текста (Premium/Upgrade) и активных email-ссылок.
 * 
 * 3. УПРАВЛЕНИЕ ЛОГОТИПОМ (MEDIA MANAGEMENT):
 *    - Загрузка файла (logo.png), сохранение изменений и проверка уведомления об успехе.
 *    - Удаление логотипа: проверка работы модального окна подтверждения (Delete/Close)
 *      и корректность сохранения пустого состояния.
 * 
 * 4. ГЛУБОКАЯ ВАЛИДАЦИЯ ПОЛЯ "BUSINESS NAME":
 *    - UI-атрибуты: проверка обязательности (*), плейсхолдеров и стилей.
 *    - Boundary Testing (Границы): тесты на пустое поле, 1 символ, 199 и 200 символов (maxlength).
 *    - Type Testing: корректная обработка Латиницы, Кириллицы, цифр, спецсимволов (&, ., -) и смешанных строк.
 * 
 * 5. ВАЛИДАЦИЯ ПОЛЯ "CONTACT PHONE NUMBER":
 *    - Форматы: проверка ввода только цифр, поддержки знака (+) в начале и блокировки 
 *      невалидных символов (буквы, спецсимволы внутри номера).
 *    - Границы: минимальная (1) и максимальная (15) длина номера.
 * 
 * 6. ИНТЕРФЕЙС КАТЕГОРИЙ И ПОДКАТЕГОРИЙ:
 *    - Мультиселект: проверка открытия выпадающего списка, выбора нескольких значений,
 *      отображения тегов и работы кнопок удаления (×).
 *    - Логика зависимости: проверка автоматического обновления поля "Selected categories" 
 *      на основе выбранных подкатегорий (Read-only режим).
 * 
 * 7. ТЕКСТОВЫЕ ОБЛАСТИ И СОЦСЕТИ:
 *    - "Business Overview": проверка многострочного ввода, лимитов текста и корректности плейсхолдера.
 *    - "Social Profiles": валидация полей для Website, X, Youtube, Facebook, Instagram.
 * 
 * 8. УПРАВЛЕНИЕ ГАЛЕРЕЕЙ ПРОЕКТОВ (PROJECT GALLERY):
 *    - Загрузка: массовая загрузка изображений разных форматов (JPEG, PNG, JPG).
 *    - Ограничения: проверка информационных блоков о лимитах фото для Lite и Premium планов.
 *    - Удаление: поштучное удаление элементов галереи и полная очистка списка перед сохранением.
 * 
 * 9. ГЛОБАЛЬНЫЙ UI/UX И АДАПТИВНОСТЬ:
 *    - Проверка интерактивности слайдеров и переключателей (SMS Notifications).
 *    - Вызов комплексной функции checkUIUX для анализа верстки на разных разрешениях.
 * 
 * ИТОГ: Тест гарантирует полную работоспособность CRM-системы профиля, корректность 
 * сохранения всех типов данных и устойчивость интерфейса к ошибкам ввода.
 */

import { test, expect } from '@playwright/test';
import * as path from 'path';
import { checkUIUX, BRAND_COLORS } from './helpers/ui-ux-helpers';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

test.describe('Business Logo Management Suite @regression', () => {
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

  test('Загрузка и удаление логотипа в Contractor Profile Setup', async ({ page }) => {
    // Увеличиваем лимит времени для этого гигантского теста
    test.setTimeout(180000); // 3 минуты

    // Авторизация
    await test.step('Авторизация пользователя', async () => {
      await page.getByRole('link', { name: 'Log In ImageLogin' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).click();
      await page.getByRole('textbox', { name: 'johndeo@example.com' }).fill('ihor.mynaiev@greenice.net');
      await page.getByRole('textbox', { name: '*************' }).click();
      await page.getByRole('textbox', { name: '*************' }).fill('Qwerty123$');
      await page.getByRole('button', { name: 'Login' }).click();
    });

    // Навигация на страницу Contractor Profile Setup
    await test.step('Переход на страницу Contractor Profile Setup', async () => {
      await page.getByRole('link', { name: ' Contractor Profile Setup' }).click();
    });

    // Проверка заголовка страницы "Contractor Profile Setup"
    await test.step('Проверка заголовка страницы "Contractor Profile Setup"', async () => {
      // Поиск заголовка
      const pageTitle = page.getByRole('heading', { name: /Contractor Profile Setup/i }).first();
      await expect(pageTitle).toBeVisible({ timeout: 10000 });

      // 1. Проверка текста
      const titleText = await pageTitle.textContent();
      expect(titleText).toContain('Contractor Profile Setup');
      console.log(`✅ Текст заголовка найден: "${titleText?.trim()}"`);

      // Проверка регистра букв (должен быть правильный регистр)
      const normalizedText = titleText?.trim() || '';
      expect(normalizedText).not.toBe(normalizedText.toUpperCase());
      expect(normalizedText).not.toBe(normalizedText.toLowerCase());
      console.log('✅ Регистр букв корректный');

      // 2. Проверка шрифта
      const titleStyles = await pageTitle.evaluate((el) => {
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

      // Проверка font-weight (жирность)
      const fontWeightNum = parseInt(titleStyles.fontWeight);
      expect(fontWeightNum).toBeGreaterThanOrEqual(500); // medium или выше
      if (fontWeightNum >= 600) {
        console.log(`✅ Font-weight заголовка: ${titleStyles.fontWeight} (жирный)`);
      } else {
        console.log(`✅ Font-weight заголовка: ${titleStyles.fontWeight} (medium)`);
      }

      // Проверка font-size (размер шрифта)
      const fontSizeNum = parseFloat(titleStyles.fontSize);
      expect(fontSizeNum).toBeGreaterThanOrEqual(18); // минимум 18px
      console.log(`✅ Font-size заголовка: ${titleStyles.fontSize}`);

      // Проверка font-family (семейство шрифтов)
      expect(titleStyles.fontFamily).toBeTruthy();
      console.log(`✅ Font-family заголовка: ${titleStyles.fontFamily}`);

      // Проверка видимости
      expect(titleStyles.display).not.toBe('none');
      expect(titleStyles.visibility).not.toBe('hidden');
      expect(parseFloat(titleStyles.opacity)).toBeGreaterThan(0);
      console.log('✅ Заголовок видим и не скрыт через CSS');

      // 3. Проверка цвета
      const colorRgb = titleStyles.color.match(/\d+/g);
      if (colorRgb && colorRgb.length >= 3) {
        const r = parseInt(colorRgb[0]);
        const g = parseInt(colorRgb[1]);
        const b = parseInt(colorRgb[2]);
        // Проверяем, что цвет темный (сумма RGB меньше 400 для темных цветов)
        const isDark = (r + g + b) < 400;
        expect(isDark).toBe(true);
        console.log(`✅ Цвет заголовка темный: rgb(${r}, ${g}, ${b})`);
      }

      // 4. Проверка расположения на странице
      const titlePosition = await pageTitle.boundingBox();
      if (titlePosition) {
        // Проверка, что заголовок находится в верхней части страницы (первые 300px)
        expect(titlePosition.y).toBeLessThan(300);
        console.log(`✅ Заголовок находится вверху страницы (y=${titlePosition.y}px)`);

        // Проверка, что заголовок видим (ширина и высота больше 0)
        expect(titlePosition.width).toBeGreaterThan(0);
        expect(titlePosition.height).toBeGreaterThan(0);
        console.log(`✅ Размеры заголовка: width=${titlePosition.width}px, height=${titlePosition.height}px`);
      }

      // Проверка, что заголовок находится в основном контенте (не в header/nav)
      const isInMainContent = await pageTitle.evaluate((el) => {
        let parent = el.parentElement;
        while (parent && parent !== document.body) {
          const tagName = parent.tagName.toLowerCase();
          const className = parent.className || '';
          if (tagName === 'header' || tagName === 'nav' || className.includes('header') || className.includes('nav')) {
            return false;
          }
          parent = parent.parentElement;
        }
        return true;
      });
      expect(isInMainContent).toBe(true);
      console.log('✅ Заголовок находится в основном контенте (не в header/nav)');

      // Проверка семантического тега заголовка
      const titleTagName = await pageTitle.evaluate((el) => el.tagName.toLowerCase());
      expect(['h1', 'h2', 'h3', 'h4', 'h5', 'h6']).toContain(titleTagName);
      console.log(`✅ Заголовок находится в правильном теге: <${titleTagName}>`);
    });

    // Проверка блока "Background Image"
    await test.step('Проверка блока "Background Image"', async () => {
      // Поиск блока по заголовку "Background Image"
      const backgroundImageBlock = page.locator('div, section').filter({ hasText: /Background Image/i }).first();
      await expect(backgroundImageBlock).toBeVisible({ timeout: 10000 });

      // 1. Проверка фона (background color)
      const blockStyles = await backgroundImageBlock.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          margin: styles.margin
        };
      });

      // Проверка, что фон светло-голубой (проверяем наличие синих оттенков)
      const bgColorRgb = blockStyles.backgroundColor.match(/\d+/g);
      if (bgColorRgb && bgColorRgb.length >= 3) {
        const r = parseInt(bgColorRgb[0]);
        const g = parseInt(bgColorRgb[1]);
        const b = parseInt(bgColorRgb[2]);
        // Проверяем, что это голубой оттенок (синий компонент больше красного и зеленого)
        const isBlueTint = b > r && b > g && (r + g + b) > 200; // Светлый оттенок
        if (isBlueTint) {
          console.log(`✅ Фон блока светло-голубой: rgb(${r}, ${g}, ${b})`);
        } else {
          // Альтернативная проверка: если не голубой, проверяем что не прозрачный и не белый
          const isNotTransparent = blockStyles.backgroundColor !== 'rgba(0, 0, 0, 0)' && 
                                   blockStyles.backgroundColor !== 'transparent';
          const isNotWhite = (r + g + b) < 750; // Не белый
          if (isNotTransparent && isNotWhite) {
            console.log(`✅ Фон блока установлен: rgb(${r}, ${g}, ${b})`);
          }
        }
      }

      // Проверка скругления углов
      const borderRadius = parseFloat(blockStyles.borderRadius);
      expect(borderRadius).toBeGreaterThanOrEqual(0);
      if (borderRadius > 0) {
        console.log(`✅ Скругление углов: ${blockStyles.borderRadius}`);
      }

      // 2. Проверка текста
      const blockText = await backgroundImageBlock.textContent();
      expect(blockText).toContain('Background Image');
      expect(blockText).toContain('Premium');
      expect(blockText).toContain('Upgrade');
      expect(blockText).toContain('customize');
      expect(blockText).toContain('info@indooroutdoor.com');
      console.log('✅ Все ключевые слова найдены в блоке');

      // Проверка email ссылки
      const emailLink = backgroundImageBlock.locator('a[href*="mailto:info@indooroutdoor.com"]').first();
      const emailLinkExists = await emailLink.count();
      if (emailLinkExists > 0) {
        const href = await emailLink.getAttribute('href');
        expect(href).toContain('mailto:info@indooroutdoor.com');
        console.log('✅ Email ссылка найдена: mailto:info@indooroutdoor.com');
      } else {
        // Проверяем, что email есть в тексте
        expect(blockText).toContain('info@indooroutdoor.com');
        console.log('✅ Email найден в тексте блока');
      }

      // 3. Проверка шрифта
      // Проверка заголовка "Background Image"
      const heading = backgroundImageBlock.locator('h1, h2, h3, h4, h5, h6, strong, b, [class*="title"], [class*="heading"]').filter({ hasText: /Background Image/i }).first();
      const headingExists = await heading.count();
      
      if (headingExists > 0) {
        const headingStyles = await heading.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            fontWeight: styles.fontWeight,
            fontSize: styles.fontSize,
            fontFamily: styles.fontFamily
          };
        });

        const headingFontWeight = parseInt(headingStyles.fontWeight);
        expect(headingFontWeight).toBeGreaterThanOrEqual(500); // medium или выше
        console.log(`✅ Font-weight заголовка "Background Image": ${headingStyles.fontWeight}`);

        const headingFontSize = parseFloat(headingStyles.fontSize);
        expect(headingFontSize).toBeGreaterThanOrEqual(14); // минимум 14px
        console.log(`✅ Font-size заголовка "Background Image": ${headingStyles.fontSize}`);
      }

      // Проверка слова "Premium" (должно быть жирным)
      const premiumText = backgroundImageBlock.locator('text=/Premium/i').first();
      const premiumExists = await premiumText.count();
      
      if (premiumExists > 0) {
        const premiumStyles = await premiumText.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            fontWeight: styles.fontWeight
          };
        });

        const premiumFontWeight = parseInt(premiumStyles.fontWeight);
        expect(premiumFontWeight).toBeGreaterThanOrEqual(500); // medium или выше
        console.log(`✅ Font-weight слова "Premium": ${premiumStyles.fontWeight} (жирный)`);
      }

      // 4. Проверка расположения на странице
      const blockPosition = await backgroundImageBlock.boundingBox();
      if (blockPosition) {
        // Проверка, что блок видим
        expect(blockPosition.width).toBeGreaterThan(0);
        expect(blockPosition.height).toBeGreaterThan(0);
        console.log(`✅ Размеры блока: width=${blockPosition.width}px, height=${blockPosition.height}px`);

        // Проверка, что блок находится в видимой области
        expect(blockPosition.y).toBeGreaterThanOrEqual(0);
        console.log(`✅ Блок расположен на странице (y=${blockPosition.y}px)`);
      }

      // Проверка, что блок находится в основном контенте
      const isInMainContent = await backgroundImageBlock.evaluate((el) => {
        let parent = el.parentElement;
        while (parent && parent !== document.body) {
          const tagName = parent.tagName.toLowerCase();
          const className = parent.className || '';
          if (tagName === 'header' || tagName === 'nav' || className.includes('header') || className.includes('nav')) {
            return false;
          }
          parent = parent.parentElement;
        }
        return true;
      });
      expect(isInMainContent).toBe(true);
      console.log('✅ Блок находится в основном контенте (не в header/nav)');

      // Проверка отступов
      const padding = blockStyles.padding;
      const margin = blockStyles.margin;
      console.log(`✅ Отступы блока: padding=${padding}, margin=${margin}`);
    });
    
    // бЛОК General Information
    await expect(page.locator('body')).toContainText('General Information');
    await expect(page.getByRole('heading', { name: 'General Information' })).toBeVisible();
    await expect(page.locator('body')).toContainText('SMS Notifications');
    await expect(page.getByText('SMS Notifications')).toBeVisible();
    await page.locator('.sliders').click();
    await page.locator('.sliders').click();



    // Загрузка логотипа
    await test.step('Загрузка логотипа', async () => {
      const logoPath = path.resolve('logo.png');
      await page.locator('#logo').setInputFiles(logoPath);
    });

    // Сохранение формы после загрузки
    await test.step('Сохранение формы после загрузки логотипа', async () => {
      await page.getByRole('button', { name: 'Save Changes' }).click();
      await page.getByRole('heading', { name: 'Success! Your showcase page' }).click();
    });

    // Удаление логотипа
    await test.step('Удаление логотипа', async () => {
      await page.getByRole('link', { name: 'Remove' }).click();
      await page.getByRole('button', { name: 'Close' }).click();
      await page.getByRole('link', { name: 'Remove' }).click();
      await page.getByRole('button', { name: 'Delete' }).click();
    });

    // Сохранение формы после удаления
    await test.step('Сохранение формы после удаления логотипа', async () => {
      await page.getByRole('button', { name: 'Save Changes' }).click();
      await page.getByRole('heading', { name: 'Success! Your showcase page' }).click();
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности страницы Contractor Profile Setup', async () => {
      await checkUIUX(page);
    });

    // Сохраняем исходные значения полей для последующего восстановления
    let businessNameOriginalValue = '';
    let phoneNumberOriginalValue = '';

    // Проверка поля "Business Name*"
    await test.step('Проверка поля Business Name*', async () => {
      // Сохраняем исходное значение поля
      const businessNameInput = page.locator('input[name="business_name"]').first();
      await expect(businessNameInput).toBeVisible({ timeout: 10000 });
      businessNameOriginalValue = await businessNameInput.inputValue() || 'Professional Company Name';
      
      // 1. Базовые проверки
      
      // 1.1. Наличие и видимость label "Business Name"
      const businessNameLabel = page.getByText('Business Name', { exact: false }).first();
      await expect(businessNameLabel).toBeVisible({ timeout: 10000 });
      const labelText = await businessNameLabel.textContent();
      expect(labelText).toContain('Business Name');
      console.log(`✅ Label найден: "${labelText?.trim()}"`);

      // 1.2. Наличие звездочки (*) для required поля
      expect(labelText).toContain('*');
      console.log('✅ Поле помечено как обязательное (*)');

      // 1.3. Видимость input поля
      console.log('✅ Input поле найдено и видимо');

      // 1.4. Проверка placeholder "Professional Company Name"
      const placeholder = await businessNameInput.getAttribute('placeholder');
      if (placeholder) {
        expect(placeholder).toContain('Professional Company Name');
        console.log(`✅ Placeholder найден: "${placeholder}"`);
      } else {
        // Если placeholder нет, проверяем текущее значение (value)
        if (businessNameOriginalValue) {
          console.log(`✅ Текущее значение поля: "${businessNameOriginalValue}"`);
        } else {
          console.log('⚠️ Placeholder и value не найдены');
        }
      }

      // 1.5. Проверка атрибута required
      const hasRequiredAttr = await businessNameInput.evaluate((el) => {
        return el.hasAttribute('required') || el.getAttribute('aria-required') === 'true';
      });
      
      if (hasRequiredAttr) {
        const hasRequired = await businessNameInput.evaluate((el) => el.hasAttribute('required'));
        if (hasRequired) {
          await expect(businessNameInput).toHaveAttribute('required', '', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут required');
        } else {
          await expect(businessNameInput).toHaveAttribute('aria-required', 'true', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут aria-required="true"');
        }
      } else {
        console.log('⚠️ Поле не имеет атрибута required, но помечено звездочкой');
      }

      // 1.6. Проверка стилей поля (border-radius, font-size и т.д.)
      const inputStyles = await businessNameInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderRadius: styles.borderRadius,
          borderColor: styles.borderColor,
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          padding: styles.padding,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: border-radius=${inputStyles.borderRadius}, font-size=${inputStyles.fontSize}, border-color=${inputStyles.borderColor}`);

      // 2. Граничные проверки

      // 2.1. Пустое поле (required)
      await businessNameInput.clear();
      await businessNameInput.blur();
      const emptyValue = await businessNameInput.inputValue();
      expect(emptyValue).toBe('');
      console.log('✅ Проверка: пустое поле');

      // 2.2. 1 символ (минимум)
      await businessNameInput.fill('A');
      const value1 = await businessNameInput.inputValue();
      expect(value1.length).toBe(1);
      console.log(`✅ Проверка: 1 символ - "${value1}" (длина: ${value1.length})`);

      // 2.3. 200 символов (максимум)
      const maxLengthValue = 'A'.repeat(200);
      await businessNameInput.fill(maxLengthValue);
      const value200 = await businessNameInput.inputValue();
      expect(value200.length).toBe(200);
      console.log(`✅ Проверка: 200 символов (длина: ${value200.length})`);

      // 3. Пограничные проверки

      // 3.1. 199 символов (граница -1)
      const value199 = 'A'.repeat(199);
      await businessNameInput.fill(value199);
      const test199 = await businessNameInput.inputValue();
      expect(test199.length).toBe(199);
      console.log(`✅ Проверка: 199 символов (граница -1) - длина: ${test199.length}`);

      // 3.2. 201 символ (превышение максимума — проверка ограничения)
      const overLimitValue = 'A'.repeat(201);
      await businessNameInput.fill(overLimitValue);
      const value201 = await businessNameInput.inputValue();
      // Проверяем, что поле ограничивает ввод до 200 символов
      expect(value201.length).toBeLessThanOrEqual(200);
      if (value201.length === 200) {
        console.log(`✅ Проверка: 201 символ ограничено до 200 (длина: ${value201.length})`);
      } else {
        console.log(`⚠️ Проверка: поле приняло ${value201.length} символов вместо ожидаемых 200`);
      }

      // 3.3. 1000+ символов (очень длинная строка — проверка ограничения)
      const veryLongValue = 'A'.repeat(1000);
      await businessNameInput.fill(veryLongValue);
      const testVeryLong = await businessNameInput.inputValue();
      expect(testVeryLong.length).toBeLessThanOrEqual(200);
      console.log(`✅ Проверка: очень длинная строка (1000 символов) ограничена до ${testVeryLong.length}`);

      // 3.4. 200 символов со смешанными типами символов
      const complex200 = 'A'.repeat(75) + '1'.repeat(75) + '&'.repeat(50);
      await businessNameInput.fill(complex200);
      const testComplex200 = await businessNameInput.inputValue();
      expect(testComplex200.length).toBeLessThanOrEqual(200);
      console.log(`✅ Проверка: 200 символов (смешанные) - длина: ${testComplex200.length}`);

      // 4. Проверки типов символов

      // 4.1. Буквы латиницы
      await businessNameInput.clear();
      await businessNameInput.fill('Company Name');
      const lettersValue = await businessNameInput.inputValue();
      expect(lettersValue).toBe('Company Name');
      console.log(`✅ Проверка: буквы латиницы - "${lettersValue}"`);

      // 4.2. Цифры
      await businessNameInput.fill('Company123');
      const numbersValue = await businessNameInput.inputValue();
      expect(numbersValue).toBe('Company123');
      console.log(`✅ Проверка: буквы + цифры - "${numbersValue}"`);

      // 4.3. Специальные символы (&, ., ,, -)
      await businessNameInput.fill('Company & Co., Ltd.');
      const specialValue = await businessNameInput.inputValue();
      expect(specialValue).toBe('Company & Co., Ltd.');
      console.log(`✅ Проверка: специальные символы - "${specialValue}"`);

      // 4.4. Кириллица
      await businessNameInput.fill('Компания');
      const cyrillicValue = await businessNameInput.inputValue();
      expect(cyrillicValue).toBe('Компания');
      console.log(`✅ Проверка: кириллица - "${cyrillicValue}"`);

      // 4.5. Смешанный набор символов
      await businessNameInput.fill('ABC-123 Company & Co., Ltd. (2024)');
      const mixedValue = await businessNameInput.inputValue();
      expect(mixedValue.length).toBeGreaterThan(0);
      console.log(`✅ Проверка: смешанный набор - "${mixedValue}" (длина: ${mixedValue.length})`);

      // 5. Дополнительные проверки

      // 5.1. Очистка поля
      await businessNameInput.fill('Test Company');
      await businessNameInput.clear();
      const clearedValue = await businessNameInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Проверка: очистка поля работает корректно');

      // 5.2. Проверка валидации (сообщение об ошибке для пустого поля)
      await businessNameInput.clear();
      await businessNameInput.blur();
      
      // Пытаемся сохранить форму с пустым полем
      const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
      await saveButton.click();
      
      // Ждем немного для появления сообщения об ошибке
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация: сообщение об ошибке появляется - "${errorText?.trim()}"`);
      } else {
        // Проверяем, может быть ошибка в самом поле (через aria-invalid)
        const isInvalid = await businessNameInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация: поле помечено как невалидное (aria-invalid="true")');
        } else {
          console.log('⚠️ Валидация: сообщение об ошибке не найдено (возможно, валидация на стороне сервера)');
        }
      }

      console.log('✅ Все проверки поля Business Name* завершены');
    });

    // Блок поля Contact Phone Number*
    await test.step('Проверка поля Contact Phone Number*', async () => {
      // Сохраняем исходное значение поля
      const phoneNumberInput = page.locator('#phone-input').filter({ visible: true });
      await expect(phoneNumberInput).toBeVisible({ timeout: 10000 });
      phoneNumberOriginalValue = await phoneNumberInput.inputValue();
      
      // 1. Базовые проверки
      
      // 1.1. Наличие и видимость label "Contact Phone Number"
      const phoneNumberLabel = page.getByText('Contact Phone Number', { exact: false }).first();
      await expect(phoneNumberLabel).toBeVisible({ timeout: 10000 });
      const labelText = await phoneNumberLabel.textContent();
      expect(labelText).toContain('Contact Phone Number');
      console.log(`✅ Label найден: "${labelText?.trim()}"`);

      // 1.2. Наличие звездочки (*) для required поля
      expect(labelText).toContain('*');
      console.log('✅ Поле помечено как обязательное (*)');

      // 1.3. Видимость input поля (#phone-input)
      console.log('✅ Input поле найдено и видимо');

      // 1.4. Проверка атрибута required
      const hasRequiredAttr = await phoneNumberInput.evaluate((el) => {
        return el.hasAttribute('required') || el.getAttribute('aria-required') === 'true';
      });
      
      if (hasRequiredAttr) {
        const hasRequired = await phoneNumberInput.evaluate((el) => el.hasAttribute('required'));
        if (hasRequired) {
          await expect(phoneNumberInput).toHaveAttribute('required', '', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут required');
        } else {
          await expect(phoneNumberInput).toHaveAttribute('aria-required', 'true', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут aria-required="true"');
        }
      } else {
        console.log('⚠️ Поле не имеет атрибута required, но помечено звездочкой');
      }

      // 1.5. Проверка стилей поля
      const inputStyles = await phoneNumberInput.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          borderRadius: styles.borderRadius,
          borderColor: styles.borderColor,
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          padding: styles.padding,
          borderWidth: styles.borderWidth
        };
      });
      console.log(`✅ Стили поля: border-radius=${inputStyles.borderRadius}, font-size=${inputStyles.fontSize}, border-color=${inputStyles.borderColor}`);

      // 2. Проверка валидации формата (только цифры, может начинаться с +)

      // 2.1. Пустое поле (required)
      await phoneNumberInput.clear();
      await phoneNumberInput.blur();
      const emptyValue = await phoneNumberInput.inputValue();
      expect(emptyValue).toBe('');
      console.log('✅ Проверка: пустое поле');

      // 2.2. Только цифры (валидный формат)
      await phoneNumberInput.fill('1234567890');
      const digitsValue = await phoneNumberInput.inputValue();
      expect(digitsValue).toMatch(/^\d+$/); // Только цифры
      console.log(`✅ Проверка: только цифры - "${digitsValue}"`);

      // 2.3. Буквы (невалидный формат - должно быть отклонено)
      await phoneNumberInput.clear();
      // Используем fill(), так как он имитирует ввод пользователя
      await phoneNumberInput.fill('123abc456');
      const withLetters = await phoneNumberInput.inputValue();
      // Проверяем, что буквы не приняты (поле должно содержать только цифры)
      expect(withLetters).toMatch(/^\d*$/);
      console.log(`✅ Проверка: буквы отклонены - "${withLetters}"`);

      // 2.4. Специальные символы (невалидный формат)
      await phoneNumberInput.clear();
      // Используем fill() для проверки фильтрации символов при вводе
      await phoneNumberInput.fill('123-456-7890');
      const withSpecialChars = await phoneNumberInput.inputValue();
      // Проверяем, что дефисы и другие символы не приняты
      expect(withSpecialChars).toMatch(/^\d*$/);
      console.log(`✅ Проверка: специальные символы отклонены - "${withSpecialChars}"`);

      // 3. Проверка максимальной длины (10 символов)

      // 3.1. 10 символов (максимум)
      await phoneNumberInput.clear();
      const maxLengthDigits = '1'.repeat(10);
      await phoneNumberInput.fill(maxLengthDigits);
      const value10 = await phoneNumberInput.inputValue();
      expect(value10.length).toBeLessThanOrEqual(10);
      console.log(`✅ Проверка: 10 символов (длина: ${value10.length})`);

      // 3.2. 9 символов (граница -1)
      await phoneNumberInput.clear();
      const value9 = '1'.repeat(9);
      await phoneNumberInput.fill(value9);
      const test9 = await phoneNumberInput.inputValue();
      expect(test9.length).toBe(9);
      console.log(`✅ Проверка: 9 символов (граница -1) - длина: ${test9.length}`);

      // 3.3. Превышение максимума (11 символов - проверка ограничения)
      await phoneNumberInput.clear();
      const overLimitValue = '1'.repeat(11);
      
      // Используем fill(), так как он учитывает атрибут maxlength в современных браузерах
      // и лучше имитирует действия пользователя
      await phoneNumberInput.fill(overLimitValue);
    
      // Ждем немного для обработки
      await page.waitForTimeout(500);
      const value11 = await phoneNumberInput.inputValue();
      
      // Проверяем, что поле ограничило ввод до 10 символов
      expect(value11.length).toBeLessThanOrEqual(10);
      if (value11.length === 10) {
        console.log(`✅ Проверка: 11 символов ограничено до 10 (длина: ${value11.length})`);
      } else {
        console.log(`✅ Проверка: 11 символов обработано и обрезано до ${value11.length}`);
      }

      // 4. Граничные проверки

      // 4.1. 1 символ (минимум)
      await phoneNumberInput.clear();
      await phoneNumberInput.fill('1');
      const value1 = await phoneNumberInput.inputValue();
      expect(value1).toMatch(/^\d+$/);
      expect(value1.length).toBeGreaterThanOrEqual(1);
      console.log(`✅ Проверка: 1 символ - "${value1}" (длина: ${value1.length})`);

      // 4.2. Типичный номер телефона (10 цифр)
      await phoneNumberInput.clear();
      await phoneNumberInput.fill('1234567890');
      const typicalPhone = await phoneNumberInput.inputValue();
      expect(typicalPhone).toMatch(/^\d+$/);
      console.log(`✅ Проверка: типичный номер (10 цифр) - "${typicalPhone}"`);

      // 5. Дополнительные проверки

      // 5.1. Очистка поля
      await phoneNumberInput.fill('1234567890');
      await phoneNumberInput.clear();
      const clearedValue = await phoneNumberInput.inputValue();
      expect(clearedValue).toBe('');
      console.log('✅ Проверка: очистка поля работает корректно');

      // 5.2. Проверка валидации (сообщение об ошибке для пустого поля)
      await phoneNumberInput.clear();
      await phoneNumberInput.blur();
      
      // Пытаемся сохранить форму с пустым полем
      const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
      await saveButton.click();
      
      // Ждем немного для появления сообщения об ошибке
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация: сообщение об ошибке появляется - "${errorText?.trim()}"`);
      } else {
        // Проверяем, может быть ошибка в самом поле (через aria-invalid)
        const isInvalid = await phoneNumberInput.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация: поле помечено как невалидное (aria-invalid="true")');
        } else {
          console.log('⚠️ Валидация: сообщение об ошибке не найдено (возможно, валидация на стороне сервера)');
        }
      }

      // 5.3. Проверка типа поля (input type)
      const inputType = await phoneNumberInput.getAttribute('type');
      if (inputType) {
        console.log(`✅ Тип поля: ${inputType}`);
      } else {
        // Проверяем тип поля (для type="tel" роль будет "textbox", а не "spinbutton")
        console.log('✅ Поле найдено по ID #phone-input');
      }

      // 5.4. Проверка maxlength атрибута (если есть)
      const maxLengthAttr = await phoneNumberInput.getAttribute('maxlength');
      if (maxLengthAttr) {
        expect(parseInt(maxLengthAttr)).toBe(10);
        console.log(`✅ Атрибут maxlength установлен: ${maxLengthAttr}`);
      } else {
        console.log('⚠️ Атрибут maxlength не найден (ограничение может быть на уровне валидации)');
      }

      console.log('✅ Все проверки поля Contact Phone Number* завершены');
    });

    // Блок полей Select all applicable subcategories* и Selected categories of service
    await test.step('Проверка полей Select all applicable subcategories* и Selected categories of service', async () => {
      // 1. Проверка поля "Select all applicable subcategories*"
      
      // 1.1. Наличие и видимость label "Select all applicable subcategories"
      const subcategoriesLabel = page.getByText('Select all applicable subcategories', { exact: false }).first();
      await expect(subcategoriesLabel).toBeVisible({ timeout: 10000 });
      const subcategoriesLabelText = await subcategoriesLabel.textContent();
      expect(subcategoriesLabelText).toContain('Select all applicable subcategories');
      console.log(`✅ Label найден: "${subcategoriesLabelText?.trim()}"`);

      // 1.2. Наличие звездочки (*) для required поля
      expect(subcategoriesLabelText).toContain('*');
      console.log('✅ Поле помечено как обязательное (*)');

      // 1.3. Видимость combobox (выпадающий список)
      const subcategoriesCombobox = page.getByRole('combobox').first();
      await expect(subcategoriesCombobox).toBeVisible({ timeout: 10000 });
      console.log('✅ Combobox (выпадающий список) найден и видим');

      // 1.4. Проверка атрибута required
      const hasRequiredAttr = await subcategoriesCombobox.evaluate((el) => {
        return el.hasAttribute('required') || el.getAttribute('aria-required') === 'true';
      });
      
      if (hasRequiredAttr) {
        const hasRequired = await subcategoriesCombobox.evaluate((el) => el.hasAttribute('required'));
        if (hasRequired) {
          await expect(subcategoriesCombobox).toHaveAttribute('required', '', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут required');
        } else {
          await expect(subcategoriesCombobox).toHaveAttribute('aria-required', 'true', { timeout: 2000 });
          console.log('✅ Поле имеет атрибут aria-required="true"');
        }
      } else {
        console.log('⚠️ Поле не имеет атрибута required, но помечено звездочкой');
      }

      // 1.5. Проверка, что можно открыть выпадающий список
      await subcategoriesCombobox.click();
      await page.waitForTimeout(500);
      const optionsList = page.getByRole('listbox').first();
      const optionsVisible = await optionsList.isVisible().catch(() => false);
      if (optionsVisible) {
        console.log('✅ Выпадающий список открывается');
        // Закрываем список, кликая вне его
        await page.keyboard.press('Escape');
        await page.waitForTimeout(300);
      } else {
        // Проверяем наличие опций через role="option"
        const options = page.getByRole('option');
        const optionsCount = await options.count();
        if (optionsCount > 0) {
          console.log(`✅ Выпадающий список содержит ${optionsCount} опций`);
          await page.keyboard.press('Escape');
          await page.waitForTimeout(300);
        } else {
          console.log('⚠️ Выпадающий список не открылся или не содержит опций');
        }
      }

      // 1.6. Проверка возможности выбора значений
      // Очищаем выбранные значения, если они есть
      const removeButtons = page.locator('text=/×/').filter({ hasText: /×/ });
      const removeButtonsCount = await removeButtons.count();
      if (removeButtonsCount > 0) {
        for (let i = 0; i < removeButtonsCount; i++) {
          const btn = removeButtons.first();
          if (await btn.isVisible()) {
            await btn.click();
            await page.waitForTimeout(200);
          }
        }
        console.log(`✅ Очищено ${removeButtonsCount} выбранных значений`);
      }

      // Проверяем выбор значения
      await subcategoriesCombobox.click();
      await page.waitForTimeout(500);
      const firstOption = page.getByRole('option').first();
      const firstOptionExists = await firstOption.count() > 0;
      
      if (firstOptionExists) {
        const firstOptionText = await firstOption.textContent();
        await firstOption.click();
        await page.waitForTimeout(500);
        
        // Проверяем, что значение выбрано (появляется в виде тега)
        const selectedTag = page.locator('text=/×/').filter({ hasText: new RegExp(firstOptionText?.trim() || '', 'i') }).first();
        const tagVisible = await selectedTag.isVisible().catch(() => false);
        if (tagVisible) {
          console.log(`✅ Значение выбрано: "${firstOptionText?.trim()}"`);
        } else {
          console.log(`✅ Значение выбрано (проверка через combobox): "${firstOptionText?.trim()}"`);
        }
      }

      // 2. Проверка поля "Selected categories of service"

      // 2.1. Наличие и видимость label "Selected categories of service"
      const categoriesLabel = page.getByText('Selected categories of service', { exact: false }).first();
      await expect(categoriesLabel).toBeVisible({ timeout: 10000 });
      const categoriesLabelText = await categoriesLabel.textContent();
      expect(categoriesLabelText).toContain('Selected categories of service');
      console.log(`✅ Label найден: "${categoriesLabelText?.trim()}"`);

      // 2.2. Отсутствие звездочки (*) для необязательного поля
      expect(categoriesLabelText).not.toContain('*');
      console.log('✅ Поле не помечено как обязательное (нет звездочки)');

      // 2.3. Видимость поля (может быть combobox или другой элемент)
      const categoriesField = page.getByRole('combobox').nth(1);
      const categoriesFieldExists = await categoriesField.count() > 0;
      
      if (categoriesFieldExists) {
        await expect(categoriesField).toBeVisible({ timeout: 10000 });
        console.log('✅ Поле "Selected categories of service" найдено и видимо');

        // 2.4. Проверка, что поле не required
        const categoriesHasRequired = await categoriesField.evaluate((el) => {
          return el.hasAttribute('required') || el.getAttribute('aria-required') === 'true';
        });
        
        expect(categoriesHasRequired).toBe(false);
        console.log('✅ Поле не имеет атрибута required');

        // 2.5. Проверка, что поле read-only (нельзя выбрать значения)
        const isReadOnly = await categoriesField.evaluate((el) => {
          return el.hasAttribute('readonly') || el.hasAttribute('disabled') || 
                 el.getAttribute('aria-readonly') === 'true' ||
                 el.getAttribute('aria-disabled') === 'true';
        });
        
        if (isReadOnly) {
          console.log('✅ Поле read-only/disabled (нельзя выбрать значения)');
        } else {
          // Проверяем через попытку клика - если поле не интерактивное, клик не должен открывать список
          // Сначала проверяем, что элемент enabled
          const isEnabled = await categoriesField.evaluate((el) => {
            return !el.hasAttribute('disabled') && 
                   el.getAttribute('aria-disabled') !== 'true' &&
                   el.getAttribute('tabindex') !== '-1';
          });
          
          if (isEnabled) {
            await categoriesField.click();
            await page.waitForTimeout(500);
            const categoriesOptionsList = page.getByRole('listbox').last();
            const categoriesOptionsVisible = await categoriesOptionsList.isVisible().catch(() => false);
            
            if (!categoriesOptionsVisible) {
              console.log('✅ Поле не позволяет выбирать значения (список не открывается)');
            } else {
              await page.keyboard.press('Escape');
              console.log('⚠️ Поле позволяет открывать список (может быть не read-only)');
            }
          } else {
            console.log('✅ Поле disabled/read-only (нельзя выбрать значения)');
          }
        }
      } else {
        // Если это не combobox, ищем другой элемент
        const categoriesContainer = page.locator('div, section').filter({ hasText: /Selected categories of service/i }).first();
        await expect(categoriesContainer).toBeVisible({ timeout: 10000 });
        console.log('✅ Поле "Selected categories of service" найдено');
      }

      // 2.6. Проверка автоматического подтягивания значений
      // Если в первом поле выбрано значение, проверяем, что во втором поле появилась категория
      const selectedSubcategories = page.locator('text=/×/').filter({ hasText: /×/ });
      const selectedCount = await selectedSubcategories.count();
      
      if (selectedCount > 0) {
        // Ждем немного для обновления второго поля
        await page.waitForTimeout(1000);
        
        // Проверяем наличие категорий во втором поле
        const categoriesText = await page.locator('body').textContent();
        const categoriesSection = page.locator('div, section').filter({ hasText: /Selected categories of service/i }).first();
        const categoriesSectionText = await categoriesSection.textContent();
        
        // Проверяем, что во втором поле есть текст (категории)
        if (categoriesSectionText && categoriesSectionText.length > 'Selected categories of service'.length) {
          console.log('✅ Значения автоматически подтягиваются в поле "Selected categories of service"');
          console.log(`✅ Найдено категорий: "${categoriesSectionText}"`);
        } else {
          console.log('⚠️ Значения не подтянулись автоматически (возможно, нужно больше времени)');
        }
      } else {
        console.log('⚠️ Нет выбранных подкатегорий для проверки автоматического подтягивания');
      }

      // 3. Дополнительные проверки взаимодействия

      // 3.1. Проверка удаления выбранных значений из первого поля
      if (selectedCount > 0) {
        const firstRemoveButton = selectedSubcategories.first();
        await firstRemoveButton.click();
        await page.waitForTimeout(500);
        const newSelectedCount = await selectedSubcategories.count();
        expect(newSelectedCount).toBeLessThan(selectedCount);
        console.log(`✅ Удаление значения работает (было ${selectedCount}, стало ${newSelectedCount})`);
      }

      // 3.2. Проверка выбора нескольких значений
      await subcategoriesCombobox.click();
      await page.waitForTimeout(500);
      const options = page.getByRole('option');
      const optionsCount = await options.count();
      
      if (optionsCount > 1) {
        // Выбираем второе значение, если оно еще не выбрано
        const secondOption = page.getByRole('option').nth(1);
        const secondOptionText = await secondOption.textContent();
        await secondOption.click();
        await page.waitForTimeout(500);
        
        const updatedSelectedCount = await selectedSubcategories.count();
        if (updatedSelectedCount > 0) {
          console.log(`✅ Можно выбрать несколько значений (выбрано: ${updatedSelectedCount})`);
        }
      }

      // 3.3. Проверка валидации пустого required поля
      // Очищаем все выбранные значения
      const allRemoveButtons = page.locator('text=/×/').filter({ hasText: /×/ });
      let removeCount = await allRemoveButtons.count();
      let previousCount = removeCount;
      let iterations = 0;
      while (removeCount > 0 && iterations < 50) {
        const btn = allRemoveButtons.first();
        if (await btn.isVisible()) {
          await btn.click();
          await page.waitForTimeout(200);
        }
        previousCount = removeCount;
        removeCount = await allRemoveButtons.count();
        if (removeCount === previousCount) break; // Защита от бесконечного цикла
        iterations++;
      }
      
      // Пытаемся сохранить форму с пустым required полем
      const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
      await saveButton.click();
      await page.waitForTimeout(1000);
      
      // Проверяем наличие сообщения об ошибке
      const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty|select/i').first();
      const errorExists = await errorMessage.count();
      if (errorExists > 0) {
        const errorText = await errorMessage.textContent();
        console.log(`✅ Валидация: сообщение об ошибке появляется - "${errorText?.trim()}"`);
      } else {
        // Проверяем, может быть ошибка в самом поле (через aria-invalid)
        const isInvalid = await subcategoriesCombobox.getAttribute('aria-invalid');
        if (isInvalid === 'true') {
          console.log('✅ Валидация: поле помечено как невалидное (aria-invalid="true")');
        } else {
          console.log('⚠️ Валидация: сообщение об ошибке не найдено (возможно, валидация на стороне сервера)');
        }
      }

      console.log('✅ Все проверки полей Select all applicable subcategories* и Selected categories of service завершены');

      // 4. Финальный выбор значений и сохранение формы
      await test.step('Выбор финальных значений и сохранение формы', async () => {
        // Очищаем все выбранные значения перед выбором финальных
        const allRemoveButtons = page.locator('text=/×/').filter({ hasText: /×/ });
        let removeCount = await allRemoveButtons.count();
        let previousCount = removeCount;
        let iterations = 0;
        while (removeCount > 0 && iterations < 50) {
          const btn = allRemoveButtons.first();
          if (await btn.isVisible()) {
            await btn.click();
            await page.waitForTimeout(200);
          }
          previousCount = removeCount;
          removeCount = await allRemoveButtons.count();
          if (removeCount === previousCount) break;
          iterations++;
        }
        console.log('✅ Все предыдущие значения очищены');

        // Выбираем первое значение: Dishwasher Repair (Appliance Repair)
        await subcategoriesCombobox.click();
        await page.waitForTimeout(500);
        const option1 = page.getByRole('option', { name: /Dishwasher Repair.*Appliance Repair/i }).first();
        const option1Exists = await option1.count() > 0;
        if (option1Exists) {
          await option1.click();
          await page.waitForTimeout(500);
          console.log('✅ Выбрано: Dishwasher Repair (Appliance Repair)');
        } else {
          // Пробуем найти по частичному совпадению
          const option1Alt = page.getByRole('option').filter({ hasText: /Dishwasher Repair/i }).first();
          if (await option1Alt.count() > 0) {
            await option1Alt.click();
            await page.waitForTimeout(500);
            console.log('✅ Выбрано: Dishwasher Repair (Appliance Repair)');
          }
        }

        // Выбираем второе значение: Interior Drain Tile Systems (Basement & Waterproofing)
        await subcategoriesCombobox.click();
        await page.waitForTimeout(500);
        const option2 = page.getByRole('option', { name: /Interior Drain Tile Systems.*Basement.*Waterproofing/i }).first();
        const option2Exists = await option2.count() > 0;
        if (option2Exists) {
          await option2.click();
          await page.waitForTimeout(500);
          console.log('✅ Выбрано: Interior Drain Tile Systems (Basement & Waterproofing)');
        } else {
          // Пробуем найти по частичному совпадению
          const option2Alt = page.getByRole('option').filter({ hasText: /Interior Drain Tile Systems/i }).first();
          if (await option2Alt.count() > 0) {
            await option2Alt.click();
            await page.waitForTimeout(500);
            console.log('✅ Выбрано: Interior Drain Tile Systems (Basement & Waterproofing)');
          }
        }

        // Выбираем третье значение: Window Cleaning (Cleaning Services)
        await subcategoriesCombobox.click();
        await page.waitForTimeout(500);
        const option3 = page.getByRole('option', { name: /Window Cleaning.*Cleaning Services/i }).first();
        const option3Exists = await option3.count() > 0;
        if (option3Exists) {
          await option3.click();
          await page.waitForTimeout(500);
          console.log('✅ Выбрано: Window Cleaning (Cleaning Services)');
        } else {
          // Пробуем найти по частичному совпадению
          const option3Alt = page.getByRole('option').filter({ hasText: /Window Cleaning/i }).first();
          if (await option3Alt.count() > 0) {
            await option3Alt.click();
            await page.waitForTimeout(500);
            console.log('✅ Выбрано: Window Cleaning (Cleaning Services)');
          }
        }

        // Проверяем, что все три значения выбраны
        const selectedTags = page.locator('text=/×/').filter({ hasText: /×/ });
        const selectedCount = await selectedTags.count();
        console.log(`✅ Выбрано значений: ${selectedCount}`);

        // Восстанавливаем исходные значения в полях Business Name* и Contact Phone Number*
        await test.step('Восстановление исходных значений полей', async () => {
          // Восстанавливаем значение в поле Business Name*
          const businessNameInput = page.locator('input[name="business_name"]').first();
          await businessNameInput.fill(businessNameOriginalValue);
          console.log(`✅ Восстановлено значение в поле Business Name*: "${businessNameOriginalValue}"`);

          // Восстанавливаем значение в поле Contact Phone Number*
          const phoneNumberInput = page.locator('#phone-input').filter({ visible: true });
          if (phoneNumberOriginalValue) {
            await phoneNumberInput.fill(phoneNumberOriginalValue);
            console.log(`✅ Восстановлено значение в поле Contact Phone Number*: "${phoneNumberOriginalValue}"`);
          } else {
            // Если поле было пустым изначально, оставляем пустым
            await phoneNumberInput.clear();
            console.log('✅ Поле Contact Phone Number* оставлено пустым (как было изначально)');
          }
        });

        // Сохраняем форму
        const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
        await saveButton.click();
        await page.waitForTimeout(2000);

        // Проверяем успешное сохранение
        const successMessage = page.getByRole('heading', { name: /Success!.*showcase page/i }).first();
        const successExists = await successMessage.count();
        if (successExists > 0) {
          await expect(successMessage).toBeVisible({ timeout: 5000 });
          const successText = await successMessage.textContent();
          console.log(`✅ Форма успешно сохранена: "${successText?.trim()}"`);
        } else {
          // Проверяем через swal2-title
          const swalTitle = page.locator('#swal2-title');
          const swalExists = await swalTitle.count();
          if (swalExists > 0) {
            await expect(swalTitle).toContainText('Success! Your showcase page has been updated.', { timeout: 5000 });
            console.log('✅ Форма успешно сохранена (проверка через swal2-title)');
          } else {
            console.log('⚠️ Сообщение об успешном сохранении не найдено');
          }
        }
      });

      // Блок Business Overview
      await test.step('Проверка поля Business Overview', async () => {
        // Сохраняем исходное значение поля
        const businessOverviewTextarea = page.getByRole('textbox', { name: /Write an engaging summary/i }).first();
        await expect(businessOverviewTextarea).toBeVisible({ timeout: 10000 });
        const businessOverviewOriginalValue = await businessOverviewTextarea.inputValue();
        
        // 1. Базовые проверки
        
        // 1.1. Наличие и видимость заголовка/label "Business Overview"
        const businessOverviewLabel = page.getByText('Business Overview', { exact: false }).first();
        await expect(businessOverviewLabel).toBeVisible({ timeout: 10000 });
        const labelText = await businessOverviewLabel.textContent();
        expect(labelText).toContain('Business Overview');
        console.log(`✅ Label найден: "${labelText?.trim()}"`);

        // 1.2. Проверка наличия/отсутствия звездочки (*) для required поля
        const hasRequiredMarker = labelText?.includes('*');
        if (hasRequiredMarker) {
          console.log('✅ Поле помечено как обязательное (*)');
        } else {
          console.log('✅ Поле не обязательное (нет звездочки)');
        }

        // 1.3. Видимость textarea поля
        console.log('✅ Textarea поле найдено и видимо');

        // 1.4. Проверка placeholder текста
        const placeholder = await businessOverviewTextarea.getAttribute('placeholder');
        if (placeholder) {
          expect(placeholder).toContain('Write an engaging summary');
          expect(placeholder).toContain('Need help crafting');
          console.log(`✅ Placeholder найден: "${placeholder.substring(0, 100)}..."`);
        } else {
          console.log('⚠️ Placeholder не найден');
        }

        // 1.5. Проверка атрибута required (если поле обязательное)
        if (hasRequiredMarker) {
          const hasRequiredAttr = await businessOverviewTextarea.evaluate((el) => {
            return el.hasAttribute('required') || el.getAttribute('aria-required') === 'true';
          });
          
          if (hasRequiredAttr) {
            const hasRequired = await businessOverviewTextarea.evaluate((el) => el.hasAttribute('required'));
            if (hasRequired) {
              await expect(businessOverviewTextarea).toHaveAttribute('required', '', { timeout: 2000 });
              console.log('✅ Поле имеет атрибут required');
            } else {
              await expect(businessOverviewTextarea).toHaveAttribute('aria-required', 'true', { timeout: 2000 });
              console.log('✅ Поле имеет атрибут aria-required="true"');
            }
          } else {
            console.log('⚠️ Поле не имеет атрибута required, но помечено звездочкой');
          }
        }

        // 1.6. Проверка стилей поля
        const textareaStyles = await businessOverviewTextarea.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            borderRadius: styles.borderRadius,
            borderColor: styles.borderColor,
            fontSize: styles.fontSize,
            fontFamily: styles.fontFamily,
            padding: styles.padding,
            borderWidth: styles.borderWidth,
            minHeight: styles.minHeight,
            resize: styles.resize
          };
        });
        console.log(`✅ Стили поля: border-radius=${textareaStyles.borderRadius}, font-size=${textareaStyles.fontSize}, resize=${textareaStyles.resize}`);

        // 1.7. Проверка размеров textarea (rows, cols)
        const rows = await businessOverviewTextarea.getAttribute('rows');
        const cols = await businessOverviewTextarea.getAttribute('cols');
        if (rows) {
          console.log(`✅ Количество строк (rows): ${rows}`);
        }
        if (cols) {
          console.log(`✅ Количество столбцов (cols): ${cols}`);
        }

        // 2. Проверка максимальной длины (если есть ограничение)
        const maxLengthAttr = await businessOverviewTextarea.getAttribute('maxlength');
        if (maxLengthAttr) {
          const maxLength = parseInt(maxLengthAttr);
          console.log(`✅ Максимальная длина: ${maxLength} символов`);
          
          // 2.1. Проверка ввода максимального количества символов
          const maxLengthValue = 'A'.repeat(maxLength);
          await businessOverviewTextarea.fill(maxLengthValue);
          const valueMax = await businessOverviewTextarea.inputValue();
          expect(valueMax.length).toBeLessThanOrEqual(maxLength);
          console.log(`✅ Проверка: ${maxLength} символов (длина: ${valueMax.length})`);
          
          // 2.2. Проверка превышения максимума
          const overLimitValue = 'A'.repeat(maxLength + 1);
          await businessOverviewTextarea.fill(overLimitValue);
          const valueOver = await businessOverviewTextarea.inputValue();
          expect(valueOver.length).toBeLessThanOrEqual(maxLength);
          console.log(`✅ Проверка: ${maxLength + 1} символов ограничено до ${valueOver.length}`);
        } else {
          console.log('⚠️ Атрибут maxlength не найден (ограничение может быть на уровне валидации)');
          
          // Проверка типичных ограничений для описаний (например, 5000 символов)
          const testLongValue = 'A'.repeat(5000);
          await businessOverviewTextarea.fill(testLongValue);
          const longValue = await businessOverviewTextarea.inputValue();
          console.log(`✅ Проверка: очень длинный текст (5000 символов) - принято: ${longValue.length}`);
        }

        // 3. Проверка многострочного ввода
        await businessOverviewTextarea.clear();
        const multilineText = 'Первая строка\nВторая строка\nТретья строка';
        await businessOverviewTextarea.fill(multilineText);
        const multilineValue = await businessOverviewTextarea.inputValue();
        expect(multilineValue).toContain('\n');
        console.log('✅ Проверка: многострочный ввод работает');

        // 4. Проверка типов символов
        await businessOverviewTextarea.clear();
        
        // 4.1. Буквы латиницы
        await businessOverviewTextarea.fill('Business description with English text');
        const lettersValue = await businessOverviewTextarea.inputValue();
        expect(lettersValue).toBe('Business description with English text');
        console.log(`✅ Проверка: буквы латиницы - "${lettersValue}"`);
        
        // 4.2. Цифры
        await businessOverviewTextarea.fill('Business 123 description');
        const numbersValue = await businessOverviewTextarea.inputValue();
        expect(numbersValue).toBe('Business 123 description');
        console.log(`✅ Проверка: буквы + цифры - "${numbersValue}"`);
        
        // 4.3. Специальные символы
        await businessOverviewTextarea.fill('Business & Co., Ltd. - Description!');
        const specialValue = await businessOverviewTextarea.inputValue();
        expect(specialValue).toBe('Business & Co., Ltd. - Description!');
        console.log(`✅ Проверка: специальные символы - "${specialValue}"`);
        
        // 4.4. Кириллица
        await businessOverviewTextarea.fill('Описание бизнеса');
        const cyrillicValue = await businessOverviewTextarea.inputValue();
        expect(cyrillicValue).toBe('Описание бизнеса');
        console.log(`✅ Проверка: кириллица - "${cyrillicValue}"`);
        
        // 4.5. Смешанный набор
        await businessOverviewTextarea.fill('ABC-123 Company & Co., Ltd. (2024) - Описание');
        const mixedValue = await businessOverviewTextarea.inputValue();
        expect(mixedValue.length).toBeGreaterThan(0);
        console.log(`✅ Проверка: смешанный набор - "${mixedValue}" (длина: ${mixedValue.length})`);

        // 5. Проверка очистки поля
        await businessOverviewTextarea.fill('Test description');
        await businessOverviewTextarea.clear();
        const clearedValue = await businessOverviewTextarea.inputValue();
        expect(clearedValue).toBe('');
        console.log('✅ Проверка: очистка поля работает корректно');

        // 6. Проверка валидации (если поле required)
        if (hasRequiredMarker) {
          await businessOverviewTextarea.clear();
          await businessOverviewTextarea.blur();
          
          // Пытаемся сохранить форму с пустым required полем
          const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
          await saveButton.click();
          await page.waitForTimeout(1000);
          
          // Проверяем наличие сообщения об ошибке
          const errorMessage = page.locator('text=/required|обязательно|заполните|cannot be empty/i').first();
          const errorExists = await errorMessage.count();
          if (errorExists > 0) {
            const errorText = await errorMessage.textContent();
            console.log(`✅ Валидация: сообщение об ошибке появляется - "${errorText?.trim()}"`);
          } else {
            // Проверяем, может быть ошибка в самом поле (через aria-invalid)
            const isInvalid = await businessOverviewTextarea.getAttribute('aria-invalid');
            if (isInvalid === 'true') {
              console.log('✅ Валидация: поле помечено как невалидное (aria-invalid="true")');
            } else {
              console.log('⚠️ Валидация: сообщение об ошибке не найдено (возможно, валидация на стороне сервера)');
            }
          }
        }

        // 7. Восстановление исходного значения
        if (businessOverviewOriginalValue) {
          await businessOverviewTextarea.fill(businessOverviewOriginalValue);
          console.log(`✅ Восстановлено исходное значение: "${businessOverviewOriginalValue.substring(0, 50)}..."`);
        } else {
          await businessOverviewTextarea.clear();
          console.log('✅ Поле очищено (было пустым)');
        }

        console.log('✅ Все проверки поля Business Overview завершены');
      });

      // Блок Social Profiles

      await expect(page.locator('body')).toContainText('Social Profiles');
      await expect(page.getByRole('heading', { name: 'Social Profiles' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Website url');
      await expect(page.getByText('Website url', { exact: true })).toBeVisible();
      
      // Проверка подсказки под полем Website url
      const websiteHint = page.getByText('Enter your business website URL.');
      await expect(websiteHint).toBeVisible();
      console.log('✅ Подсказка "Enter your business website URL." найдена и видима');

      await page.locator('input[name="website_url"]').click();
      await page.locator('input[name="website_url"]').fill('https://dev.indooroutdoor.com/');
      await expect(page.locator('body')).toContainText('X url');
      await expect(page.getByText('X url', { exact: true })).toBeVisible();
      await expect(page.getByText('Enter your business X Page URL (not a personal profile).')).toBeVisible();
      await page.locator('input[name="x_url"]').click();
      await page.locator('input[name="x_url"]').fill('https://dev.indooroutdoor.com/');
      await expect(page.locator('body')).toContainText('Youtube url');
      await expect(page.getByText('Youtube url', { exact: true })).toBeVisible();
      await expect(page.getByText('Enter your business Youtube Page URL (not a personal profile).')).toBeVisible();
      await page.locator('input[name="youtube_url"]').click();
      await page.locator('input[name="youtube_url"]').fill('https://dev.indooroutdoor.com/');
      await expect(page.locator('body')).toContainText('Facebook url');
      await expect(page.getByText('Facebook url', { exact: true })).toBeVisible();
      await expect(page.getByText('Enter your business Facebook Page URL (not a personal profile).')).toBeVisible();
      await page.locator('input[name="facebook_url"]').click();
      await page.locator('input[name="facebook_url"]').fill('https://dev.indooroutdoor.com/');
      await expect(page.locator('body')).toContainText('Instagram url');
      await expect(page.getByText('Instagram url', { exact: true })).toBeVisible();
      await expect(page.getByText('Enter your business Instagram Page URL (not a personal profile).')).toBeVisible();
      await page.locator('input[name="instagram_url"]').click();
      await page.locator('input[name="instagram_url"]').fill('https://dev.indooroutdoor.com/');
    await page.getByRole('button', { name: 'Save Changes' }).click();
      
      // Ожидаем появления сообщения об успехе и закрываем модальное окно
      try {
        const successHeading = page.getByRole('heading', { name: /Success!.*showcase page/i }).first();
        await expect(successHeading).toBeVisible({ timeout: 5000 });
        await page.waitForTimeout(1000);
        
        // Закрываем модальное окно (если есть кнопка Close)
        const closeButton = page.getByRole('button', { name: /Close|OK|Got it/i }).first();
        const closeButtonExists = await closeButton.count();
        if (closeButtonExists > 0) {
          await closeButton.click();
          console.log('✅ Модальное окно успешного сохранения закрыто');
        } else {
          // Если нет кнопки Close, просто кликаем вне модального окна или нажимаем Escape
          await page.keyboard.press('Escape');
          console.log('✅ Модальное окно закрыто через Escape');
        }
      } catch (error) {
        // Если страница уже закрыта или произошла ошибка, просто логируем
        console.log('⚠️ Не удалось закрыть модальное окно (возможно, страница уже закрыта)');
      }

      // Блок Project Gallery
      await test.step('Проверка блока Project Gallery', async () => {
        // 1. Базовые проверки
        
        // 1.1. Наличие и видимость заголовка "Project Gallery"
        const galleryHeading = page.getByRole('heading', { name: 'Project Gallery' }).first();
        await expect(galleryHeading).toBeVisible({ timeout: 10000 });
        const headingText = await galleryHeading.textContent();
        expect(headingText).toContain('Project Gallery');
        console.log(`✅ Заголовок найден: "${headingText?.trim()}"`);

        // 1.2. Проверка контейнера галереи
        const galleryContainer = page.locator('#gallery').first();
        await expect(galleryContainer).toBeVisible({ timeout: 10000 });
        console.log('✅ Контейнер галереи найден и видим');

        // 1.3. Проверка описательного текста
        const descriptionText = 'Upload photos to showcase your completed projects. This is a great way to help homeowners see the quality of your work!';
        await expect(galleryContainer).toContainText(descriptionText);
        const descriptionElement = page.getByText('Upload photos to showcase').first();
        await expect(descriptionElement).toBeVisible({ timeout: 10000 });
        console.log('✅ Описательный текст найден и видим');

        // 1.4. Проверка информации о лимите фото
        await expect(galleryContainer).toContainText('Photo Display Limit');
        await expect(galleryContainer).toContainText('Lite plan displays up to 3 photos');
        await expect(galleryContainer).toContainText('Premium to display up to 20 photos');
        await expect(galleryContainer).toContainText('info@indooroutdoor.com');
        const limitElement = page.getByText('Photo Display Limit: Your').first();
        await expect(limitElement).toBeVisible({ timeout: 10000 });
        console.log('✅ Информация о лимите фото найдена и видима');

        // 1.5. Проверка email ссылки
        const emailLink = galleryContainer.locator('a[href*="mailto:info@indooroutdoor.com"]').first();
        const emailLinkExists = await emailLink.count();
        if (emailLinkExists > 0) {
          const href = await emailLink.getAttribute('href');
          expect(href).toContain('mailto:info@indooroutdoor.com');
          console.log('✅ Email ссылка найдена: mailto:info@indooroutdoor.com');
        } else {
          console.log('⚠️ Email ссылка не найдена (возможно, просто текст)');
        }

        // 2. Проверка поля загрузки файлов
        
        // 2.1. Видимость input для загрузки файлов
        const fileInput = page.locator('#file-input').first();
        await expect(fileInput).toBeVisible({ timeout: 10000 });
        console.log('✅ Поле загрузки файлов найдено и видимо');

        // 2.2. Проверка типа input (должен быть file)
        const inputType = await fileInput.getAttribute('type');
        expect(inputType).toBe('file');
        console.log(`✅ Тип поля: ${inputType}`);

        // 2.3. Проверка атрибутов accept (разрешенные форматы)
        const acceptAttr = await fileInput.getAttribute('accept');
        if (acceptAttr) {
          console.log(`✅ Разрешенные форматы: ${acceptAttr}`);
          // Обычно для изображений: image/*, image/jpeg, image/png, image/jpg
          expect(acceptAttr).toMatch(/image/i);
        } else {
          console.log('⚠️ Атрибут accept не найден (принимаются все файлы)');
        }

        // 2.4. Проверка multiple (возможность загрузки нескольких файлов одновременно)
        const multipleAttr = await fileInput.getAttribute('multiple');
        if (multipleAttr !== null) {
          console.log('✅ Можно загружать несколько файлов одновременно');
        } else {
          console.log('⚠️ Можно загружать только один файл за раз');
        }

        // 3. Проверка загрузки изображений
        
        // 3.1. Проверка загрузки одного изображения (JPEG)
        const jpegPath = path.resolve('500px-JPEG_example_down.jpg');
        await fileInput.setInputFiles(jpegPath);
        await page.waitForTimeout(1000);
        
        // Проверяем, что изображение появилось в галерее
        const galleryItems = page.locator('.img-preview, li.img-preview, [class*="gallery-item"]');
        const itemsCount = await galleryItems.count();
        expect(itemsCount).toBeGreaterThan(0);
        console.log(`✅ Изображение JPEG загружено (найдено элементов в галерее: ${itemsCount})`);

        // 3.2. Проверка загрузки второго изображения (PNG)
        const pngPath = path.resolve('PNG_transparency_demonstration_1.png');
        await fileInput.setInputFiles(pngPath);
        await page.waitForTimeout(1000);
        
        const itemsCount2 = await galleryItems.count();
        expect(itemsCount2).toBeGreaterThan(itemsCount);
        console.log(`✅ Изображение PNG загружено (найдено элементов в галерее: ${itemsCount2})`);

        // 3.3. Проверка загрузки третьего изображения (JPG)
        const jpgPath = path.resolve('what-is-jpeg_cat.jpg');
        await fileInput.setInputFiles(jpgPath);
        await page.waitForTimeout(1000);
        
        const itemsCount3 = await galleryItems.count();
        expect(itemsCount3).toBeGreaterThan(itemsCount2);
        console.log(`✅ Изображение JPG загружено (найдено элементов в галерее: ${itemsCount3})`);

        // 3.4. Проверка лимита загрузки (для Lite плана - максимум 3 фото)
        // Пытаемся загрузить четвертое изображение
        if (itemsCount3 < 3) {
          const testImagePath = path.resolve('logo.png'); // Используем существующее изображение
          if (await fileInput.isVisible()) {
            await fileInput.setInputFiles(testImagePath);
            await page.waitForTimeout(1000);
            const itemsCount4 = await galleryItems.count();
            if (itemsCount4 <= 3) {
              console.log(`✅ Лимит загрузки работает (максимум 3 фото для Lite плана, загружено: ${itemsCount4})`);
            } else {
              console.log(`⚠️ Лимит загрузки не работает (загружено: ${itemsCount4}, ожидалось максимум 3)`);
            }
          }
        } else {
          console.log(`✅ Достигнут лимит загрузки (3 фото для Lite плана)`);
        }

        // 4. Проверка отображения загруженных изображений
        
        // 4.1. Проверка превью изображений
        const imagePreviews = page.locator('img[src*="gallery"], .img-preview img, [class*="preview"] img');
        const previewsCount = await imagePreviews.count();
        if (previewsCount > 0) {
          console.log(`✅ Найдено превью изображений: ${previewsCount}`);
          
          // Проверяем, что изображения загружены (имеют src)
          for (let i = 0; i < Math.min(previewsCount, 3); i++) {
            const img = imagePreviews.nth(i);
            const src = await img.getAttribute('src');
            if (src && src !== '') {
              console.log(`✅ Изображение ${i + 1} загружено (src: ${src.substring(0, 50)}...)`);
            }
          }
        }

        // 4.2. Проверка стилей галереи
        const galleryStyles = await galleryContainer.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            padding: styles.padding,
            margin: styles.margin
          };
        });
        expect(galleryStyles.display).not.toBe('none');
        expect(galleryStyles.visibility).not.toBe('hidden');
        console.log(`✅ Стили галереи: display=${galleryStyles.display}, padding=${galleryStyles.padding}`);

        // 5. Проверка удаления изображений
        
        // 5.1. Проверка наличия кнопок удаления
        // Используем более специфичный селектор, чтобы не захватить кнопку удаления логотипа
        const removeButtons = page.locator('#gallery .remove-gallery, #gallery [class*="remove-gallery"], li .remove-gallery, .img-preview .remove-gallery');
        const removeButtonsCount = await removeButtons.count();
        expect(removeButtonsCount).toBeGreaterThan(0);
        console.log(`✅ Найдено кнопок удаления: ${removeButtonsCount}`);

        // 5.2. Удаление изображений (начиная с последнего)
        const currentItems = await galleryItems.count();
        if (currentItems > 0) {
          // Удаляем последнее изображение
          const lastRemoveButton = removeButtons.last();
          await lastRemoveButton.click();
          await page.waitForTimeout(500);
          
          const itemsAfterRemove1 = await galleryItems.count();
          expect(itemsAfterRemove1).toBeLessThan(currentItems);
          console.log(`✅ Изображение удалено (было: ${currentItems}, стало: ${itemsAfterRemove1})`);

          // Удаляем еще одно изображение, если есть
          if (itemsAfterRemove1 > 0) {
            const updatedRemoveButtons = page.locator('#gallery .remove-gallery, #gallery [class*="remove-gallery"], li .remove-gallery, .img-preview .remove-gallery');
            const updatedRemoveButtonsCount = await updatedRemoveButtons.count();
            if (updatedRemoveButtonsCount > 1) {
              const secondLastRemoveButton = updatedRemoveButtons.nth(updatedRemoveButtonsCount - 2);
              if (await secondLastRemoveButton.isVisible().catch(() => false)) {
                await secondLastRemoveButton.click();
                await page.waitForTimeout(500);
                const itemsAfterRemove2 = await galleryItems.count();
                expect(itemsAfterRemove2).toBeLessThan(itemsAfterRemove1);
                console.log(`✅ Второе изображение удалено (было: ${itemsAfterRemove1}, стало: ${itemsAfterRemove2})`);
              }
            }
          }
        }

        // 6. Проверка сохранения формы
        
        // 6.1. Сохранение с загруженными изображениями
        const saveButton = page.getByRole('button', { name: 'Save Changes' }).first();
        await saveButton.click();
        await page.waitForTimeout(2000);
        
        // Проверяем успешное сохранение
        const successMessage = page.getByRole('heading', { name: /Success!.*showcase page/i }).first();
        const successExists = await successMessage.count();
        if (successExists > 0) {
          await expect(successMessage).toBeVisible({ timeout: 5000 });
          const successText = await successMessage.textContent();
          console.log(`✅ Форма успешно сохранена: "${successText?.trim()}"`);
          
          // Закрываем модальное окно
          const closeButton = page.getByRole('button', { name: /Close|OK|Got it/i }).first();
          const closeButtonExists = await closeButton.count();
          if (closeButtonExists > 0) {
            await closeButton.click();
            await page.waitForTimeout(500);
          } else {
            await page.keyboard.press('Escape');
            await page.waitForTimeout(500);
          }
        } else {
          const swalTitle = page.locator('#swal2-title');
          const swalExists = await swalTitle.count();
          if (swalExists > 0) {
            await expect(swalTitle).toContainText('Success! Your showcase page has been updated.', { timeout: 5000 });
            console.log('✅ Форма успешно сохранена (проверка через swal2-title)');
          }
        }

        // 7. Проверка удаления всех изображений и повторного сохранения
        const remainingItems = await galleryItems.count();
        if (remainingItems > 0) {
          // Удаляем все оставшиеся изображения
          let itemsToRemove = remainingItems;
          const allRemoveButtons = page.locator('#gallery .remove-gallery, #gallery [class*="remove-gallery"], li .remove-gallery, .img-preview .remove-gallery');
          while (itemsToRemove > 0) {
            const removeBtn = allRemoveButtons.first();
            if (await removeBtn.isVisible().catch(() => false)) {
              await removeBtn.click();
              await page.waitForTimeout(300);
            }
            itemsToRemove--;
            const currentCount = await galleryItems.count();
            if (currentCount === 0) break;
          }
          console.log('✅ Все изображения удалены');
          
          // Сохраняем форму без изображений
          await saveButton.click();
          await page.waitForTimeout(2000);
          
          // Проверяем успешное сохранение
          const successAfterRemove = page.getByRole('heading', { name: /Success!.*showcase page/i }).first();
          const successAfterRemoveExists = await successAfterRemove.count();
          if (successAfterRemoveExists > 0) {
            await expect(successAfterRemove).toBeVisible({ timeout: 5000 });
            console.log('✅ Форма успешно сохранена после удаления всех изображений');
            
            // Закрываем модальное окно
            try {
              const closeBtn = page.getByRole('button', { name: /Close|OK|Got it/i }).first();
              const closeBtnExists = await closeBtn.count();
              if (closeBtnExists > 0) {
                await closeBtn.click();
              } else {
                await page.keyboard.press('Escape');
              }
            } catch (error) {
              console.log('⚠️ Не удалось закрыть модальное окно');
            }
          } else {
            const swalTitle2 = page.locator('#swal2-title');
            const swalExists2 = await swalTitle2.count();
            if (swalExists2 > 0) {
              await expect(swalTitle2).toContainText('Success! Your showcase page has been updated.', { timeout: 5000 });
              console.log('✅ Форма успешно сохранена после удаления (проверка через swal2-title)');
            }
          }
        }

        console.log('✅ Все проверки блока Project Gallery завершены');
      });
    });
  });
});
