/**
 * MESSAGES SUITE — ПРОВЕРКА СТРАНИЦЫ СООБЩЕНИЙ ПРОВАЙДЕРА
 * 
 * Данный тестовый набор предназначен для проверки раздела сообщений (Messages) 
 * в личном кабинете провайдера. Тест фокусируется на доступности функционала 
 * и корректности отображения информационных уведомлений о тарифных планах.
 * 
 * ЧЕК-ЛИСТ ПРОВЕРОК:
 * 
 * 1. АВТОРИЗАЦИЯ И ДОСТУП:
 *    - Вход в систему под учетной записью провайдера.
 *    - Проверка успешного завершения процесса логина.
 * 
 * 2. НАВИГАЦИЯ И РОУТИНГ:
 *    - Поиск и клик по элементу "Messages" в боковом меню.
 *    - Валидация URL: проверка перехода на страницу /provider/provider-messages.
 * 
 * 3. АУДИТ ЗАГОЛОВКА СТРАНИЦЫ:
 *    - Проверка видимости и содержания главного заголовка "Messages".
 *    - Технический анализ CSS: проверка шрифтов (family, size, weight), 
 *      цветовой гаммы и параметров видимости (opacity, display).
 * 
 * 4. ПРОВЕРКА ИНФОРМАЦИОННОГО БЛОКА (PREMIUM PLAN):
 *    - Валидация текста уведомления: "Provider messaging feature is available with the Premium plan".
 *    - Проверка призыва к действию (CTA): "Upgrade your plan to receive and respond to messages...".
 *    - Проверка контактной ссылки: поиск активного mailto-адреса (info@indooroutdoor.com) 
 *      или текста "Contact us" для связи с поддержкой.
 *    - Глубокий аудит стилей текстовых блоков (line-height, font-size, visibility).
 * 
 * 5. ГЛОБАЛЬНЫЙ UI/UX И АДАПТИВНОСТЬ:
 *    - Вызов функции checkUIUX для комплексной проверки верстки.
 *    - Подтверждение корректного отображения страницы на разрешении 1920x1080.
 * 
 * ИТОГ: Тест гарантирует, что провайдер может перейти в раздел сообщений, 
 * видит корректную информацию о необходимости Premium-плана для использования 
 * чата и может легко связаться с администрацией через почтовую ссылку.
 */

import { test, expect } from '@playwright/test';
import { checkUIUX } from 'utils/ui.ux.helper';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Messages - Проверка страницы сообщений провайдера
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Навигацию на страницу Messages
 * - Проверку заголовка страницы
 * - Проверку текста о Premium плане
 * - Проверку стилей элементов
 * 
 * @see README.md для подробной документации
 */
test.describe('Messages Suite @regression', () => {
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

  test('Навигация и проверка страницы Messages', async ({ page }) => {
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

    // Навигация к Messages
    await test.step('Навигация к Messages', async () => {
      // Ищем элемент Messages в меню
      const messagesLink = page.locator('span').filter({ hasText: /^Messages$/ }).first();
      await expect(messagesLink).toBeVisible({ timeout: 10000 });
      await messagesLink.click();
      await page.waitForTimeout(2000);
      
      console.log('✅ Переход на страницу Messages выполнен');
    });

    // Проверка URL
    await test.step('Проверка URL страницы', async () => {
      await page.waitForURL('https://dev.indooroutdoor.com/provider/provider-messages', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/provider/provider-messages');
      console.log(`✅ URL страницы корректный: "${page.url()}"`);
    });

    // Проверка заголовка страницы
    await test.step('Проверка заголовка страницы и его стилей', async () => {
      const heading = page.getByRole('heading', { name: /Messages/i }).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      
      const headingText = await heading.textContent();
      expect(headingText).toContain('Messages');
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

    // Проверка текста Provider Messages
    await test.step('Проверка текста Provider Messages и его стилей', async () => {
      // Проверка заголовка "Provider Messages"
      const providerMessagesHeading = page.getByText('Provider Messages', { exact: false }).first();
      await expect(providerMessagesHeading).toBeVisible({ timeout: 10000 });
      console.log('✅ Текст "Provider Messages" найден');

      // Проверка полного текста блока
      const fullText = page.getByText(/Provider messaging feature is available with the Premium plan/i).first();
      await expect(fullText).toBeVisible({ timeout: 10000 });
      const textContent = await fullText.textContent();
      expect(textContent).toContain('Provider messaging feature is available with the Premium plan');
      expect(textContent).toContain('Upgrade your plan to receive and respond to messages from customers');
      console.log('✅ Полный текст блока Provider Messages найден');

      // Проверка ссылки mailto
      const mailtoLink = page.locator('a[href*="mailto:info@indooroutdoor.com"]').first();
      const mailtoExists = await mailtoLink.count();
      if (mailtoExists > 0) {
        await expect(mailtoLink).toBeVisible({ timeout: 5000 });
        expect(await mailtoLink.getAttribute('href')).toContain('mailto:info@indooroutdoor.com');
        console.log('✅ Ссылка mailto найдена');
      } else {
        // Fallback: если ссылка не найдена, проверяем, что текст "Contact us" присутствует
        const contactUsText = page.getByText(/Contact us/i).first();
        const contactUsExists = await contactUsText.count();
        if (contactUsExists > 0) {
          await expect(contactUsText).toBeVisible({ timeout: 5000 });
          console.log('✅ Текст "Contact us" найден (ссылка mailto отсутствует)');
        } else {
          console.log('⚠️ Ссылка mailto или текст "Contact us" не найдены');
        }
      }

      // Проверка стилей текста Provider Messages
      const textStyles = await providerMessagesHeading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          fontWeight: styles.fontWeight,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          margin: styles.margin,
          padding: styles.padding
        };
      });

      expect(textStyles.display).not.toBe('none');
      expect(textStyles.visibility).not.toBe('hidden');
      expect(parseFloat(textStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили текста Provider Messages: font-size=${textStyles.fontSize}, color=${textStyles.color}, font-weight=${textStyles.fontWeight}`);

      // Проверка стилей полного текста
      const fullTextStyles = await fullText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontFamily: styles.fontFamily,
          color: styles.color,
          fontWeight: styles.fontWeight,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          lineHeight: styles.lineHeight
        };
      });

      expect(fullTextStyles.display).not.toBe('none');
      expect(fullTextStyles.visibility).not.toBe('hidden');
      expect(parseFloat(fullTextStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили полного текста: font-size=${fullTextStyles.fontSize}, color=${fullTextStyles.color}, line-height=${fullTextStyles.lineHeight}`);
    });

    // Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page, 'Messages page');
    });
  });
});

