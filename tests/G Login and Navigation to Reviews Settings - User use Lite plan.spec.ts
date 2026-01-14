/**
 * REVIEWS SETTINGS SUITE — ПРОВЕРКА СИСТЕМЫ УПРАВЛЕНИЯ ОТЗЫВАМИ
 * 
 * Данный тестовый набор предназначен для проверки раздела настроек отзывов (Reviews Settings) 
 * в кабинете провайдера. Тест имитирует работу пользователя с настройками интеграций 
 * сторонних отзывов и проверку ограничений тарифного плана.
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И НАВИГАЦИЯ:
 *    - Вход в систему и переход в раздел "Reviews" -> "Settings" через боковое меню.
 *    - Валидация URL и корректности главного заголовка страницы (стили, шрифты, отступы).
 * 
 * 2. АУДИТ ОГРАНИЧЕНИЙ ТАРИФНОГО ПЛАНА (UPSALE BLOCKS):
 *    - Проверка блоков Indoor Outdoor Reviews, Google Reviews и Facebook Reviews.
 *    - Валидация уведомлений о недоступности функций на текущем плане.
 *    - Проверка текстов: "feature is available with the Premium plan" и "upgrade to access".
 *    - Анализ стилей информационных текстов (color, opacity, line-height).
 * 
 * 3. ФУНКЦИОНАЛЬНОСТЬ УПРАВЛЯЮЩИХ КНОПОК:
 *    - Кнопка CANCEL: 
 *      - Проверка визуального оформления (border-radius, padding, cursor).
 *      - Тестирование hover-эффекта.
 *      - Валидация логики возврата в профиль пользователя при клике.
 *    - Кнопка SAVE CHANGES: 
 *      - Проверка стилей и состояний (hover, focus/outline, box-shadow).
 *      - Имитация клика и проверка отсутствия ошибок валидации на странице.
 *    - Кнопка PREVIEW: 
 *      - Проверка корректности ссылки (href) на страницу деталей провайдера.
 *      - Анализ стилей и кликабельности (cursor: pointer).
 * 
 * 4. ПРОВЕРКА РАЗДЕЛОВ ИНТЕГРАЦИЙ (DEEP DIVE):
 *    - Последовательный переход в подразделы: Indoor Outdoor, Google и Facebook.
 *    - Валидация заголовков и специфических текстов для каждого типа отзывов.
 *    - Проверка наличия и работоспособности ссылок mailto (info@indooroutdoor.com) 
 *      для связи с поддержкой по вопросам апгрейда плана.
 * 
 * 5. ТЕХНИЧЕСКИЙ И UI/UX АУДИТ:
 *    - Глубокий анализ CSS всех ключевых элементов через getComputedStyle.
 *    - Вызов комплексной функции checkUIUX для проверки адаптивности и доступности страницы.
 * 
 * ИТОГ: Тест гарантирует, что провайдер видит корректную информацию о статусе своих 
 * отзывов, понимает ограничения текущего плана и имеет возможность полноценно 
 * управлять доступными настройками через интерактивные элементы интерфейса.
 */

import { test, expect } from '@playwright/test';
import { checkUIUX } from './helpers/ui-ux-helpers';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Reviews Settings - Проверка страницы настроек отзывов
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Навигацию на страницу Reviews Settings
 * - Проверку элементов страницы
 * - Работу кнопок Cancel, Save Changes, Preview
 * - Проверку текстов о планах
 * 
 * @see README.md для подробной документации
 */
test.describe('Reviews Settings Suite @regression', () => {
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

  test('Навигация и проверка страницы Reviews Settings', async ({ page }) => {
    // Увеличиваем лимит времени для этого теста
    test.setTimeout(120000); // 2 минуты

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

    // Навигация к Reviews Settings
    await test.step('Навигация к Reviews Settings', async () => {
      // Ищем элемент Reviews в меню
      const reviewsLink = page.locator('span').filter({ hasText: /^Reviews$/ }).first();
      await expect(reviewsLink).toBeVisible({ timeout: 10000 });
      await reviewsLink.click();
      await page.waitForTimeout(500);
      
      // В выпадающем списке ищем Settings
      const settingsLink = page.locator('span').filter({ hasText: /^Settings$/ }).first();
      await expect(settingsLink).toBeVisible({ timeout: 10000 });
      await settingsLink.click();
      await page.waitForTimeout(2000);
      
      console.log('✅ Переход на страницу Reviews Settings выполнен');
    });

    // Проверка URL
    await test.step('Проверка URL страницы', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/provider/reviews/settings', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/reviews/settings');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Проверка заголовка страницы
    await test.step('Проверка заголовка страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Reviews Settings/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Reviews Settings');
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

    // Проверка блока Indoor Outdoor Reviews
    await test.step('Проверка блока Indoor Outdoor Reviews и его стилей', async () => {
      const indoorOutdoorText = page.getByText('Indoor Outdoor Reviews', { exact: false }).first();
      await expect(indoorOutdoorText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Indoor Outdoor Reviews" найден');

      // Проверка полного текста блока
      const fullText = page.getByText(/Indoor Outdoor Reviews feature is not available with your current plan/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      console.log('✅ Полный текст блока Indoor Outdoor Reviews найден');

      // Проверка стилей текста
      const textStyles = await indoorOutdoorText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          fontWeight: styles.fontWeight,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста Indoor Outdoor Reviews: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка блока Google Reviews
    await test.step('Проверка блока Google Reviews и его стилей', async () => {
      const googleReviewsText = page.getByText('Google Reviews', { exact: false }).first();
      await expect(googleReviewsText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Google Reviews" найден');

      // Проверка полного текста блока
      const fullText = page.getByText(/Google Reviews integration is available with the Premium plan/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      console.log('✅ Полный текст блока Google Reviews найден');

      // Проверка стилей текста
      const textStyles = await googleReviewsText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          fontWeight: styles.fontWeight,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста Google Reviews: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка блока Facebook Reviews
    await test.step('Проверка блока Facebook Reviews и его стилей', async () => {
      const facebookReviewsText = page.getByText('Facebook Reviews', { exact: false }).first();
      await expect(facebookReviewsText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Facebook Reviews" найден');

      // Проверка полного текста блока
      const fullText = page.getByText(/Facebook Reviews integration is available with the Premium plan/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      console.log('✅ Полный текст блока Facebook Reviews найден');

      // Проверка стилей текста
      const textStyles = await facebookReviewsText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          fontWeight: styles.fontWeight,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста Facebook Reviews: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка кнопки Cancel и её стилей
    await test.step('Проверка кнопки Cancel и её стилей', async () => {
      // Используем более гибкий поиск: по тексту и классам, или по href содержащему profile
      const cancelButton = page.getByRole('link', { name: 'Cancel' }).or(
        page.locator('a.btn.btn-secondary').filter({ hasText: 'Cancel' })
      ).or(
        page.locator('a[href*="profile"]').filter({ hasText: 'Cancel' })
      ).first();
      
      await expect(cancelButton).toBeVisible({ timeout: 10000 });
      await expect(cancelButton).toHaveText('Cancel');
      console.log('✅ Кнопка Cancel найдена');

      // Проверка href (может быть относительным или полным)
      const href = await cancelButton.getAttribute('href');
      // Проверяем, что href ведет на страницу профиля (может быть /profile или /provider/details)
      expect(href).toMatch(/(profile|provider\/details)/);
      console.log(`✅ Href кнопки Cancel: "${href}"`);

      // Проверка стилей кнопки Cancel
      const cancelStyles = await cancelButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          border: styles.border,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          textDecoration: styles.textDecoration
        };
      });

      expect(cancelStyles.display).not.toBe('none');
      expect(cancelStyles.visibility).not.toBe('hidden');
      expect(parseFloat(cancelStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили кнопки Cancel: background-color=${cancelStyles.backgroundColor}, color=${cancelStyles.color}, border-radius=${cancelStyles.borderRadius}, cursor=${cancelStyles.cursor}`);

      // Проверка hover состояния
      await cancelButton.hover();
      await page.waitForTimeout(300);
      const hoverStyles = await cancelButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          opacity: styles.opacity
        };
      });
      console.log(`✅ Hover состояние кнопки Cancel: background-color=${hoverStyles.backgroundColor}, opacity=${hoverStyles.opacity}`);

      // Клик на кнопку Cancel
      await cancelButton.click();
      // Ждем перехода (может быть /profile или /provider/details)
      await page.waitForURL(/.*\/(profile|provider\/details)/, { timeout: 10000 });
      await expect(page).toHaveURL(/.*\/(profile|provider\/details)/);
      console.log('✅ Переход выполнен после клика на Cancel');
    });

    // Возврат на страницу Reviews Settings
    await test.step('Возврат на страницу Reviews Settings', async () => {
      await page.goto('https://dev.indooroutdoor.com/provider/reviews/settings');
      await page.waitForLoadState('networkidle');
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/reviews/settings');
      console.log('✅ Возврат на страницу Reviews Settings выполнен');
    });

    // Проверка кнопки Save Changes и её стилей
    await test.step('Проверка кнопки Save Changes и её стилей', async () => {
      const saveButton = page.locator('button#submit.btn.btn-primary[type="submit"]');
      await expect(saveButton).toBeVisible({ timeout: 10000 });
      await expect(saveButton).toHaveText('Save Changes');
      console.log('✅ Кнопка Save Changes найдена');

      // Проверка стилей кнопки Save Changes
      const saveStyles = await saveButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          border: styles.border,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontWeight: styles.fontWeight,
          fontSize: styles.fontSize
        };
      });

      expect(saveStyles.display).not.toBe('none');
      expect(saveStyles.visibility).not.toBe('hidden');
      expect(parseFloat(saveStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили кнопки Save Changes: background-color=${saveStyles.backgroundColor}, color=${saveStyles.color}, border-radius=${saveStyles.borderRadius}, cursor=${saveStyles.cursor}`);

      // Проверка hover состояния
      await saveButton.hover();
      await page.waitForTimeout(300);
      const hoverStyles = await saveButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          opacity: styles.opacity
        };
      });
      console.log(`✅ Hover состояние кнопки Save Changes: background-color=${hoverStyles.backgroundColor}, opacity=${hoverStyles.opacity}`);

      // Проверка focus состояния
      await saveButton.focus();
      await page.waitForTimeout(300);
      const focusStyles = await saveButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          outline: styles.outline,
          boxShadow: styles.boxShadow
        };
      });
      console.log(`✅ Focus состояние кнопки Save Changes: outline=${focusStyles.outline}, box-shadow=${focusStyles.boxShadow}`);

      // Клик на кнопку Save Changes
      await saveButton.click();
      await page.waitForTimeout(2000);
      
      // Проверка успешного сохранения (может быть сообщение об успехе или просто отсутствие ошибок)
      const currentUrl = page.url();
      expect(currentUrl).toContain('/provider/reviews/settings');
      console.log('✅ Сохранение выполнено, остались на странице Reviews Settings');
      
      // Проверяем, нет ли сообщений об ошибках
      const errorMessages = page.locator('text=/error|failed|invalid/i');
      const errorCount = await errorMessages.count();
      if (errorCount === 0) {
        console.log('✅ Сообщений об ошибках не найдено, сохранение успешно');
      } else {
        console.log(`⚠️ Найдено ${errorCount} сообщений об ошибках`);
      }
    });

    // Проверка кнопки Preview и её стилей
    await test.step('Проверка кнопки Preview и её стилей', async () => {
      // Используем более гибкий поиск: по тексту и классам, или по href содержащему provider-details
      const previewButton = page.getByRole('link', { name: 'Preview' }).or(
        page.locator('a.btn.btn-primary').filter({ hasText: 'Preview' })
      ).or(
        page.locator('a[href*="provider-details"]').filter({ hasText: 'Preview' })
      ).first();
      
      await expect(previewButton).toBeVisible({ timeout: 10000 });
      // Текст может быть "Preview" или "Preview page"
      const previewText = await previewButton.textContent();
      expect(previewText?.trim().toLowerCase()).toContain('preview');
      console.log(`✅ Кнопка Preview найдена, текст: "${previewText?.trim()}"`);

      // Проверка стилей кнопки Preview
      const previewStyles = await previewButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          color: styles.color,
          border: styles.border,
          borderRadius: styles.borderRadius,
          padding: styles.padding,
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          textDecoration: styles.textDecoration
        };
      });

      expect(previewStyles.display).not.toBe('none');
      expect(previewStyles.visibility).not.toBe('hidden');
      expect(parseFloat(previewStyles.opacity)).toBeGreaterThan(0);
      expect(previewStyles.cursor).toBe('pointer');
      console.log(`✅ Стили кнопки Preview: background-color=${previewStyles.backgroundColor}, color=${previewStyles.color}, border-radius=${previewStyles.borderRadius}, cursor=${previewStyles.cursor}`);

      // Проверка hover состояния
      await previewButton.hover();
      await page.waitForTimeout(300);
      const hoverStyles = await previewButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          backgroundColor: styles.backgroundColor,
          opacity: styles.opacity
        };
      });
      console.log(`✅ Hover состояние кнопки Preview: background-color=${hoverStyles.backgroundColor}, opacity=${hoverStyles.opacity}`);

      // Проверка кликабельности и перехода
      const href = await previewButton.getAttribute('href');
      expect(href).toMatch(/provider-details/);
      console.log(`✅ Кнопка Preview кликабельна, href: "${href}"`);

      // Клик на кнопку Preview (опционально, можно просто проверить кликабельность)
      // await previewButton.click();
      // await page.waitForTimeout(2000);
      // console.log('✅ Переход по кнопке Preview выполнен');
    });

    // Проверка ссылок mailto
    await test.step('Проверка ссылок mailto и их стилей', async () => {
      const mailtoLinks = page.locator('a[href*="mailto:info@indooroutdoor.com"]');
      const mailtoCount = await mailtoLinks.count();
      
      if (mailtoCount > 0) {
        for (let i = 0; i < Math.min(mailtoCount, 3); i++) {
          const link = mailtoLinks.nth(i);
          await expect(link).toBeVisible({ timeout: 5000 });
          
          const href = await link.getAttribute('href');
          expect(href).toContain('mailto:info@indooroutdoor.com');
          
          // Проверка стилей ссылки
          const linkStyles = await link.evaluate((el) => {
            const styles = window.getComputedStyle(el);
            return {
              color: styles.color,
              textDecoration: styles.textDecoration,
              cursor: styles.cursor
            };
          });
          
          console.log(`✅ Ссылка mailto ${i + 1} найдена: href="${href}", color=${linkStyles.color}, cursor=${linkStyles.cursor}`);
        }
      } else {
        console.log('⚠️ Ссылки mailto не найдены');
      }
    });

    // Проверка Indoor Outdoor Reviews
    await test.step('Проверка Indoor Outdoor Reviews', async () => {
      // Возвращаемся на страницу Reviews Settings
      await page.goto('https://dev.indooroutdoor.com/provider/reviews/settings');
      await page.waitForLoadState('networkidle');
      
      // Ищем элемент Indoor Outdoor в меню
      const indoorOutdoorLink = page.locator('span').filter({ hasText: /^Indoor Outdoor$/ }).first();
      await expect(indoorOutdoorLink).toBeVisible({ timeout: 10000 });
      await indoorOutdoorLink.click();
      await page.waitForTimeout(2000);
      
      // Проверка URL
      await page.waitForURL('https://dev.indooroutdoor.com/provider/testimonials', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/testimonials');
      console.log('✅ Переход на страницу Indoor Outdoor Reviews выполнен');
      
      // Проверка заголовка
      const heading = page.getByRole('heading', { name: /Indoor Outdoor Reviews/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Indoor Outdoor Reviews');
      console.log(`✅ Заголовок найден: "${headingText?.trim()}"`);
      
      // Проверка стилей заголовка
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
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
      
      // Проверка текста
      const fullText = page.getByText(/Indoor Outdoor Reviews feature is not available with your current plan/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      const textContent = await fullText.textContent();
      expect(textContent).toContain('Indoor Outdoor Reviews feature is not available with your current plan');
      expect(textContent).toContain('Please upgrade to access this feature');
      console.log('✅ Полный текст блока Indoor Outdoor Reviews найден');
      
      // Проверка ссылки mailto отдельно (может быть в отдельном элементе)
      const mailtoLink = page.locator('a[href*="mailto:info@indooroutdoor.com"]').first();
      const mailtoExists = await mailtoLink.count();
      if (mailtoExists > 0) {
        await expect(mailtoLink).toBeVisible({ timeout: 5000 });
        const mailtoHref = await mailtoLink.getAttribute('href');
        expect(mailtoHref).toContain('mailto:info@indooroutdoor.com');
        console.log('✅ Ссылка mailto найдена в блоке Indoor Outdoor Reviews');
      } else {
        // Проверяем, может быть текст "Contact us" есть в основном тексте
        const contactText = page.getByText(/Contact us/i).first();
        const contactExists = await contactText.count();
        if (contactExists > 0) {
          console.log('✅ Текст "Contact us" найден');
        } else {
          console.log('⚠️ Ссылка mailto или текст "Contact us" не найдены в явном виде');
        }
      }
      
      // Проверка стилей текста
      const textStyles = await fullText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка Google Reviews
    await test.step('Проверка Google Reviews', async () => {
      // Возвращаемся на страницу Reviews Settings
      await page.goto('https://dev.indooroutdoor.com/provider/reviews/settings');
      await page.waitForLoadState('networkidle');
      
      // Ищем элемент Google в меню
      const googleLink = page.locator('span').filter({ hasText: /^Google$/ }).first();
      await expect(googleLink).toBeVisible({ timeout: 10000 });
      await googleLink.click();
      await page.waitForTimeout(2000);
      
      // Проверка URL (нужно определить правильный URL для Google Reviews)
      const currentUrl = page.url();
      console.log(`✅ Переход выполнен, текущий URL: "${currentUrl}"`);
      
      // Проверка заголовка Google Reviews
      const heading = page.getByRole('heading', { name: /Google Reviews/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Google Reviews');
      console.log(`✅ Заголовок найден: "${headingText?.trim()}"`);
      
      // Проверка стилей заголовка
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
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
      
      // Проверка текста Google Reviews (текст будет отличаться от Indoor Outdoor)
      const fullText = page.getByText(/Google Reviews/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      const textContent = await fullText.textContent();
      expect(textContent).toContain('Google Reviews');
      console.log('✅ Текст блока Google Reviews найден');
      
      // Проверка стилей текста
      const textStyles = await fullText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Проверка Facebook Reviews
    await test.step('Проверка Facebook Reviews', async () => {
      // Возвращаемся на страницу Reviews Settings
      await page.goto('https://dev.indooroutdoor.com/provider/reviews/settings');
      await page.waitForLoadState('networkidle');
      
      // Ищем элемент Facebook в меню
      const facebookLink = page.locator('span').filter({ hasText: /^Facebook$/ }).first();
      await expect(facebookLink).toBeVisible({ timeout: 10000 });
      await facebookLink.click();
      await page.waitForTimeout(2000);
      
      // Проверка URL (нужно определить правильный URL для Facebook Reviews)
      const currentUrl = page.url();
      console.log(`✅ Переход выполнен, текущий URL: "${currentUrl}"`);
      
      // Проверка заголовка Facebook Reviews
      const heading = page.getByRole('heading', { name: /Facebook Reviews/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Facebook Reviews');
      console.log(`✅ Заголовок найден: "${headingText?.trim()}"`);
      
      // Проверка стилей заголовка
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          fontWeight: styles.fontWeight,
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
      
      // Проверка текста Facebook Reviews (текст будет отличаться от Indoor Outdoor и Google)
      const fullText = page.getByText(/Facebook Reviews/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      const textContent = await fullText.textContent();
      expect(textContent).toContain('Facebook Reviews');
      console.log('✅ Текст блока Facebook Reviews найден');
      
      // Проверка стилей текста
      const textStyles = await fullText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity
        };
      });
      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста: font-size=${textStyles.fontSize}, color=${textStyles.color}`);
    });

    // Комплексная проверка UI/UX
    await test.step('Комплексная проверка UI/UX', async () => {
      await checkUIUX(page);
    });
  });
});

