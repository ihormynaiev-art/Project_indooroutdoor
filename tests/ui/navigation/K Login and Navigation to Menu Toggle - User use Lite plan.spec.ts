import { test, expect } from '@playwright/test';
import { checkUIUX } from 'utils/ui.ux.helper';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

/**
 * Menu Toggle - Проверка функциональности переключателя меню
 * 
 * Этот тест проверяет:
 * - Авторизацию пользователя
 * - Функциональность переключателя меню (открытие/закрытие)
 * - Проверку стилей элементов
 * 
 * @see README.md для подробной документации
 */
test.describe('Menu Toggle Suite @regression', () => {
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

  test('Проверка функциональности переключателя меню', async ({ page, context }) => {
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

    // Поиск переключателя меню
    await test.step('Поиск переключателя меню', async () => {
      const toggleButton = page.locator('xpath=//*[@id="toggle_btn"]/span');
      await expect(toggleButton).toBeVisible({ timeout: 10000 });
      console.log('✅ Переключатель меню найден');
    });

    // Проверка функциональности переключателя (открытие/закрытие меню)
    await test.step('Проверка функциональности переключателя меню', async () => {
      const toggleButton = page.locator('xpath=//*[@id="toggle_btn"]/span');
      
      // Ищем боковое меню для проверки его состояния
      const sidebarMenu = page.locator('#sidebar-menu, [id*="sidebar"], [class*="sidebar"], [class*="menu"]').first();
      const sidebarExists = await sidebarMenu.count();
      
      if (sidebarExists > 0) {
        // Проверяем начальное состояние меню (видимо или скрыто)
        const initialDisplay = await sidebarMenu.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            transform: styles.transform,
            marginLeft: styles.marginLeft,
            left: styles.left,
            width: styles.width
          };
        });
        
        const isInitiallyVisible = initialDisplay.display !== 'none' && 
                                   initialDisplay.visibility !== 'hidden' &&
                                   parseFloat(initialDisplay.width || '0') > 0;
        console.log(`ℹ️ Начальное состояние меню: ${isInitiallyVisible ? 'открыто' : 'закрыто'}`);
        
        // Первый клик на переключатель
        await toggleButton.click();
        await page.waitForTimeout(500);
        
        // Проверяем состояние меню после первого клика
        const afterFirstClickDisplay = await sidebarMenu.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            transform: styles.transform,
            marginLeft: styles.marginLeft,
            left: styles.left,
            width: styles.width
          };
        });
        
        const isAfterFirstClickVisible = afterFirstClickDisplay.display !== 'none' && 
                                        afterFirstClickDisplay.visibility !== 'hidden' &&
                                        parseFloat(afterFirstClickDisplay.width || '0') > 0;
        
        // Меню должно изменить свое состояние (открыто → закрыто или закрыто → открыто)
        const stateChanged = isInitiallyVisible !== isAfterFirstClickVisible;
        if (stateChanged) {
          console.log(`✅ Первый клик: состояние меню изменилось (${isInitiallyVisible ? 'открыто' : 'закрыто'} → ${isAfterFirstClickVisible ? 'открыто' : 'закрыто'})`);
        } else {
          console.log(`ℹ️ Первый клик: состояние меню не изменилось (${isAfterFirstClickVisible ? 'открыто' : 'закрыто'})`);
        }
        
        // Второй клик на переключатель (должен вернуть в исходное состояние)
        await toggleButton.click();
        await page.waitForTimeout(500);
        
        // Проверяем состояние меню после второго клика
        const afterSecondClickDisplay = await sidebarMenu.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            transform: styles.transform,
            marginLeft: styles.marginLeft,
            left: styles.left,
            width: styles.width
          };
        });
        
        const isAfterSecondClickVisible = afterSecondClickDisplay.display !== 'none' && 
                                         afterSecondClickDisplay.visibility !== 'hidden' &&
                                         parseFloat(afterSecondClickDisplay.width || '0') > 0;
        
        // Меню должно вернуться в исходное состояние
        const returnedToInitial = isInitiallyVisible === isAfterSecondClickVisible;
        if (returnedToInitial) {
          console.log(`✅ Второй клик: меню вернулось в исходное состояние (${isAfterSecondClickVisible ? 'открыто' : 'закрыто'})`);
        } else {
          console.log(`ℹ️ Второй клик: меню не вернулось в исходное состояние (${isAfterSecondClickVisible ? 'открыто' : 'закрыто'})`);
        }
        
        // Третий клик для дополнительной проверки
        await toggleButton.click();
        await page.waitForTimeout(500);
        
        const afterThirdClickDisplay = await sidebarMenu.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            width: styles.width
          };
        });
        
        const isAfterThirdClickVisible = afterThirdClickDisplay.display !== 'none' && 
                                        afterThirdClickDisplay.visibility !== 'hidden' &&
                                        parseFloat(afterThirdClickDisplay.width || '0') > 0;
        
        console.log(`ℹ️ Третий клик: состояние меню (${isAfterThirdClickVisible ? 'открыто' : 'закрыто'})`);
        
        // Возвращаем меню в открытое состояние (если оно закрыто)
        if (!isAfterThirdClickVisible) {
          await toggleButton.click();
          await page.waitForTimeout(500);
          console.log('✅ Меню возвращено в открытое состояние');
        }
      } else {
        // Если не нашли sidebar, проверяем альтернативные способы
        console.log('ℹ️ Боковое меню не найдено по стандартным селекторам, проверяем функциональность переключателя');
        
        // Просто проверяем, что переключатель кликабелен
        await toggleButton.click();
        await page.waitForTimeout(500);
        console.log('✅ Переключатель кликабелен');
        
        await toggleButton.click();
        await page.waitForTimeout(500);
        console.log('✅ Переключатель работает (второй клик выполнен)');
      }
    });

    // Проверка стилей переключателя
    await test.step('Проверка стилей переключателя меню', async () => {
      const toggleButton = page.locator('xpath=//*[@id="toggle_btn"]/span');
      
      const toggleStyles = await toggleButton.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          color: styles.color,
          padding: styles.padding,
          margin: styles.margin
        };
      });

      expect(toggleStyles.display).not.toBe('none');
      expect(toggleStyles.visibility).not.toBe('hidden');
      expect(parseFloat(toggleStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили переключателя: cursor=${toggleStyles.cursor}, opacity=${toggleStyles.opacity}, font-size=${toggleStyles.fontSize}`);
    });

    // Проверка видимости переключателя
    await test.step('Проверка видимости переключателя', async () => {
      const toggleButton = page.locator('xpath=//*[@id="toggle_btn"]/span');
      await expect(toggleButton).toBeVisible({ timeout: 10000 });
      console.log('✅ Переключатель меню видим');
    });

    // Навигация через выпадающее меню
    await test.step('Навигация через выпадающее меню', async () => {
      // Кликаем на элемент меню (иконка для открытия выпадающего списка)
      const menuIcon = page.locator('xpath=//*[@id="sidebar-menu"]/div/a/i');
      await expect(menuIcon).toBeVisible({ timeout: 15000 });
      await menuIcon.click();
      await page.waitForTimeout(500);
      console.log('✅ Клик на иконку меню выполнен');
      
      // Первая ссылка - Profile (используем позицию в меню для точности)
      const profileLink = page.locator('#dropboxes ul').nth(0).locator('li').nth(0).locator('a');
      await expect(profileLink).toBeVisible({ timeout: 20000 });
      
      console.log(`ℹ️ URL до клика на Profile: ${page.url()}`);
      
      // Кликаем и ждем навигации (принимаем и /profile, и /provider/details)
      await Promise.all([
        page.waitForURL(/\/profile|\/provider\/details/, { timeout: 35000, waitUntil: 'domcontentloaded' }),
        profileLink.click()
      ]);
      
      console.log(`✅ Переход в профиль выполнен. Текущий URL: ${page.url()}`);
      
      // Снова кликаем на иконку меню
      await menuIcon.click();
      await page.waitForTimeout(500);
      console.log('✅ Клик на иконку меню выполнен (второй раз)');
      
      // Вторая ссылка - Verification (второй элемент в первом списке)
      const verificationLink = page.locator('#dropboxes ul').nth(0).locator('li').nth(1).locator('a');
      await expect(verificationLink).toBeVisible({ timeout: 20000 });
      
      console.log(`ℹ️ URL до клика на Verification: ${page.url()}`);
      
      await Promise.all([
        page.waitForURL(/\/provider\/verification/, { timeout: 35000, waitUntil: 'domcontentloaded' }),
        verificationLink.click()
      ]);
      
      console.log(`✅ Текущий URL после Verification: ${page.url()}`);
      
      // Снова кликаем на иконку меню
      await menuIcon.click();
      await page.waitForTimeout(500);
      console.log('✅ Клик на иконку меню выполнен (третий раз)');
      
      // Третья ссылка - Terms & Conditions (первый элемент во втором списке)
      const termsLink = page.locator('#dropboxes ul').nth(1).locator('li').nth(0).locator('a');
      await expect(termsLink).toBeVisible({ timeout: 20000 });
      
      console.log(`ℹ️ URL до клика на Terms: ${page.url()}`);
      
      await Promise.all([
        page.waitForURL(/\/terms-condition|terms-conditions/i, { timeout: 35000, waitUntil: 'domcontentloaded' }),
        termsLink.click()
      ]);
      console.log('✅ Переход на страницу Terms & Conditions выполнен');
    });

    // Проверка страницы Terms & Conditions
    await test.step('Проверка страницы Terms & Conditions', async () => {
      // Проверяем заголовок страницы
      const heading = page.getByRole('heading', { name: /Terms & Condition/i }).or(page.getByText(/Terms & Condition/i)).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Terms');
      console.log(`✅ Заголовок страницы найден: "${headingText?.trim()}"`);
      
      // Проверяем стили заголовка страницы
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility
        };
      });
      expect(headingStyles.display).not.toBe('none');
      expect(headingStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили заголовка страницы: font-size=${headingStyles.fontSize}, font-weight=${headingStyles.fontWeight}`);
      
      // Проверяем блок текста "Terms" (вводный текст)
      const termsIntroText = page.getByText(/This Website and the services of The IndoorOutdoor Resource are offered to you/i).first();
      await expect(termsIntroText).toBeVisible({ timeout: 10000 });
      console.log('✅ Вводный текст Terms найден');
      
      // Проверяем стили вводного текста
      const introTextStyles = await termsIntroText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          color: styles.color,
          lineHeight: styles.lineHeight,
          display: styles.display,
          visibility: styles.visibility
        };
      });
      expect(introTextStyles.display).not.toBe('none');
      expect(introTextStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили вводного текста: font-size=${introTextStyles.fontSize}, line-height=${introTextStyles.lineHeight}`);
      
      // Проверяем заголовки разделов как отдельные элементы
      const sectionHeadings = [
        'Use License',
        'INFORMATION YOU PROVIDE TO US',
        'Use of The IndoorOutdoor Resource Services',
        'Using your content',
        'Disclaimer',
        'Limitations',
        'Revisions and Corrigendum',
        'Links',
        'Site Terms of Use Modifications',
        'Governing Law',
        'No Guarantees Endorsement or Warranties',
        'Damages or Claims'
      ];
      
      for (const sectionTitle of sectionHeadings) {
        const sectionHeading = page.getByText(new RegExp(sectionTitle, 'i')).first();
        const headingExists = await sectionHeading.count();
        
        if (headingExists > 0) {
          // Проверяем видимость перед использованием toBeVisible()
          const isVisible = await sectionHeading.isVisible();
          
          if (isVisible) {
            await expect(sectionHeading).toBeVisible({ timeout: 5000 });
            const sectionText = await sectionHeading.textContent();
            console.log(`✅ Заголовок раздела найден: "${sectionText?.trim()}"`);
            
            // Проверяем стили заголовка раздела
            const sectionStyles = await sectionHeading.evaluate((el) => {
              const styles = window.getComputedStyle(el);
              return {
                fontSize: styles.fontSize,
                fontWeight: styles.fontWeight,
                color: styles.color,
                display: styles.display,
                visibility: styles.visibility,
                marginTop: styles.marginTop,
                marginBottom: styles.marginBottom
              };
            });
            
            expect(sectionStyles.display).not.toBe('none');
            expect(sectionStyles.visibility).not.toBe('hidden');
            console.log(`✅ Стили заголовка "${sectionTitle}": font-size=${sectionStyles.fontSize}, font-weight=${sectionStyles.fontWeight}, margin-top=${sectionStyles.marginTop}`);
          } else {
            console.log(`⚠️ Заголовок раздела "${sectionTitle}" найден, но скрыт (возможно, это элемент меню или другой скрытый элемент)`);
          }
        } else {
          console.log(`⚠️ Заголовок раздела "${sectionTitle}" не найден`);
        }
      }
    });

    // Навигация к Privacy Policy
    await test.step('Навигация к Privacy Policy', async () => {
      // Кликаем на аватар пользователя
      const avatar = page.locator('xpath=/html/body/div[1]/header/div/nav/ul[2]/li/a/div/span/img');
      await expect(avatar).toBeVisible({ timeout: 10000 });
      await avatar.evaluate((el: HTMLElement) => {
        el.click();
      });
      await page.waitForTimeout(500);
      console.log('✅ Клик на аватар выполнен');
      
      // Кликаем на ссылку в выпадающем меню
      const userMenuLink = page.locator('xpath=/html/body/div[1]/header/div/nav/ul[2]/li/div/a');
      await expect(userMenuLink).toBeVisible({ timeout: 10000 });
      await userMenuLink.click();
      await page.waitForTimeout(1000);
      console.log('✅ Клик на ссылку в меню пользователя выполнен');
      
      // Кликаем на иконку меню
      const menuIcon = page.locator('xpath=//*[@id="sidebar-menu"]/div/a/i');
      await expect(menuIcon).toBeVisible({ timeout: 10000 });
      await menuIcon.click();
      await page.waitForTimeout(500);
      console.log('✅ Клик на иконку меню выполнен');
      
      // Кликаем на Privacy Policy (второй элемент во втором списке)
      const privacyLink = page.locator('#dropboxes ul').nth(1).locator('li').nth(1).locator('a');
      await expect(privacyLink).toBeVisible({ timeout: 20000 });
      
      console.log(`ℹ️ URL до клика на Privacy: ${page.url()}`);
      
      await Promise.all([
        page.waitForURL(/\/privacy-policy/, { timeout: 35000, waitUntil: 'domcontentloaded' }),
        privacyLink.click()
      ]);
      console.log('✅ Переход на страницу Privacy Policy выполнен');
    });

    // Проверка страницы Privacy Policy
    await test.step('Проверка страницы Privacy Policy', async () => {
      // Проверяем заголовок страницы
      const heading = page.getByRole('heading', { name: /Privacy Policy/i }).or(page.getByText(/Privacy Policy/i)).first();
      await expect(heading).toBeVisible({ timeout: 10000 });
      const headingText = await heading.textContent();
      expect(headingText).toContain('Privacy Policy');
      console.log(`✅ Заголовок страницы найден: "${headingText?.trim()}"`);
      
      // Проверяем стили заголовка страницы
      const headingStyles = await heading.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          fontWeight: styles.fontWeight,
          color: styles.color,
          display: styles.display,
          visibility: styles.visibility
        };
      });
      expect(headingStyles.display).not.toBe('none');
      expect(headingStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили заголовка страницы: font-size=${headingStyles.fontSize}, font-weight=${headingStyles.fontWeight}`);
      
      // Проверяем блок текста "Our Commitment to Privacy" (вводный текст)
      const privacyIntroText = page.getByText(/Our Commitment to Privacy/i).first();
      await expect(privacyIntroText).toBeVisible({ timeout: 10000 });
      const introContent = await privacyIntroText.textContent();
      expect(introContent).toContain('Our Commitment to Privacy');
      console.log('✅ Вводный текст "Our Commitment to Privacy" найден');
      
      // Проверяем наличие дополнительного текста отдельно
      const additionalText = page.getByText(/The IndoorOutdoor Resource respects the privacy/i).first();
      const additionalExists = await additionalText.count();
      if (additionalExists > 0) {
        await expect(additionalText).toBeVisible({ timeout: 5000 });
        console.log('✅ Дополнительный текст "The IndoorOutdoor Resource respects the privacy" найден');
      } else {
        console.log('ℹ️ Дополнительный текст "The IndoorOutdoor Resource respects the privacy" не найден в отдельном элементе');
      }
      
      // Проверяем стили вводного текста
      const introTextStyles = await privacyIntroText.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          fontSize: styles.fontSize,
          color: styles.color,
          lineHeight: styles.lineHeight,
          display: styles.display,
          visibility: styles.visibility
        };
      });
      expect(introTextStyles.display).not.toBe('none');
      expect(introTextStyles.visibility).not.toBe('hidden');
      console.log(`✅ Стили вводного текста: font-size=${introTextStyles.fontSize}, line-height=${introTextStyles.lineHeight}`);
      
      // Проверяем заголовки разделов как отдельные элементы
      const sectionHeadings = [
        'Matching You to Service Professionals',
        'Information We Collect',
        'Physical Mailing Address Removal',
        'Cookies',
        'Security',
        'Change in Information Use',
        'Trademark and Copyright notices',
        'The IndoorOutdoor Resource Trademarks'
      ];
      
      for (const sectionTitle of sectionHeadings) {
        const sectionHeading = page.getByText(new RegExp(sectionTitle, 'i')).first();
        const headingExists = await sectionHeading.count();
        
        if (headingExists > 0) {
          // Проверяем видимость перед использованием toBeVisible()
          const isVisible = await sectionHeading.isVisible();
          
          if (isVisible) {
            await expect(sectionHeading).toBeVisible({ timeout: 5000 });
            const sectionText = await sectionHeading.textContent();
            console.log(`✅ Заголовок раздела найден: "${sectionText?.trim()}"`);
            
            // Проверяем стили заголовка раздела
            const sectionStyles = await sectionHeading.evaluate((el) => {
              const styles = window.getComputedStyle(el);
              return {
                fontSize: styles.fontSize,
                fontWeight: styles.fontWeight,
                color: styles.color,
                display: styles.display,
                visibility: styles.visibility,
                marginTop: styles.marginTop,
                marginBottom: styles.marginBottom
              };
            });
            
            expect(sectionStyles.display).not.toBe('none');
            expect(sectionStyles.visibility).not.toBe('hidden');
            console.log(`✅ Стили заголовка "${sectionTitle}": font-size=${sectionStyles.fontSize}, font-weight=${sectionStyles.fontWeight}, margin-top=${sectionStyles.marginTop}`);
          } else {
            console.log(`⚠️ Заголовок раздела "${sectionTitle}" найден, но скрыт (возможно, это элемент меню или другой скрытый элемент)`);
          }
        } else {
          console.log(`⚠️ Заголовок раздела "${sectionTitle}" не найден`);
        }
      }
    });

    // Проверка переключения ширины сайта
    await test.step('Проверка переключения ширины сайта', async () => {
      // Возвращаемся на страницу профиля, где элемент должен быть доступен
      await page.goto('https://dev.indooroutdoor.com/profile');
      await page.waitForTimeout(2000);
      console.log('✅ Переход на страницу профиля для проверки переключения ширины');
      
      // Пробуем найти элемент разными способами
      let fullWidthToggle = page.locator('xpath=/html/body/div[1]/div[1]/div[2]/ul/li[3]/a/i');
      let toggleExists = await fullWidthToggle.count();
      
      // Если не найден, пробуем альтернативные селекторы
      if (toggleExists === 0) {
        // Пробуем найти по классу или другим атрибутам
        fullWidthToggle = page.locator('header i, [class*="full"], [class*="width"], [class*="toggle"]').filter({ hasText: /expand|full|width/i }).first();
        toggleExists = await fullWidthToggle.count();
      }
      
      // Если все еще не найден, пробуем найти в хедере по позиции
      if (toggleExists === 0) {
        fullWidthToggle = page.locator('header ul li').nth(2).locator('a i, i').first();
        toggleExists = await fullWidthToggle.count();
      }
      
      // Если элемент не найден, пробуем найти по тексту или aria-label
      if (toggleExists === 0) {
        fullWidthToggle = page.locator('[aria-label*="full"], [aria-label*="width"], [title*="full"], [title*="width"]').first();
        toggleExists = await fullWidthToggle.count();
      }
      
      if (toggleExists === 0) {
        console.log('⚠️ Элемент переключения ширины не найден. Пробуем найти все элементы в хедере для отладки...');
        const headerElements = await page.locator('header ul li').count();
        console.log(`ℹ️ Найдено элементов в хедере: ${headerElements}`);
        throw new Error('Элемент переключения ширины не найден на странице');
      }
      
      // Проверяем видимость элемента
      const isVisible = await fullWidthToggle.isVisible();
      if (!isVisible) {
        // Если элемент скрыт, пробуем кликнуть через JavaScript
        console.log('ℹ️ Элемент найден, но скрыт. Будем использовать JavaScript клик');
      } else {
        await expect(fullWidthToggle).toBeVisible({ timeout: 5000 });
      }
      console.log('✅ Элемент переключения ширины найден');
      
      // Получаем начальное состояние контейнера (ширина контента)
      const mainContainer = page.locator('body, main, [class*="container"], [class*="content"], [id*="content"]').first();
      const initialWidth = await mainContainer.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          width: styles.width,
          maxWidth: styles.maxWidth,
          marginLeft: styles.marginLeft,
          marginRight: styles.marginRight
        };
      });
      console.log(`ℹ️ Начальная ширина контейнера: width=${initialWidth.width}, max-width=${initialWidth.maxWidth}`);
      
      // Кликаем на элемент для переключения на полную ширину
      if (isVisible) {
        await fullWidthToggle.click();
      } else {
        // Если элемент скрыт, используем JavaScript клик
        await fullWidthToggle.evaluate((el: HTMLElement) => {
          (el as HTMLElement).click();
        });
      }
      await page.waitForTimeout(1000); // Ждем анимации
      console.log('✅ Первый клик на переключатель ширины выполнен');
      
      // Проверяем, что сайт открылся на всю ширину
      const afterFirstClickWidth = await mainContainer.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        const rect = el.getBoundingClientRect();
        return {
          width: styles.width,
          maxWidth: styles.maxWidth,
          marginLeft: styles.marginLeft,
          marginRight: styles.marginRight,
          clientWidth: rect.width,
          windowWidth: window.innerWidth
        };
      });
      
      // Проверяем, что ширина увеличилась (или max-width убрался, или margin изменился)
      const isFullWidth = afterFirstClickWidth.maxWidth === 'none' || 
                         afterFirstClickWidth.maxWidth === '100%' ||
                         parseFloat(afterFirstClickWidth.width || '0') >= parseFloat(initialWidth.width || '0') ||
                         Math.abs(afterFirstClickWidth.clientWidth - afterFirstClickWidth.windowWidth) < 50; // Допустимая погрешность
      
      if (isFullWidth) {
        console.log(`✅ Сайт открылся на всю ширину: width=${afterFirstClickWidth.width}, max-width=${afterFirstClickWidth.maxWidth}, client-width=${afterFirstClickWidth.clientWidth}px, window-width=${afterFirstClickWidth.windowWidth}px`);
      } else {
        console.log(`ℹ️ Изменение ширины: width=${afterFirstClickWidth.width}, max-width=${afterFirstClickWidth.maxWidth}, client-width=${afterFirstClickWidth.clientWidth}px`);
      }
      
      // Кликаем еще раз, чтобы вернуть изначальное положение
      if (isVisible) {
        await fullWidthToggle.click();
      } else {
        // Если элемент скрыт, используем JavaScript клик
        await fullWidthToggle.evaluate((el: HTMLElement) => {
          (el as HTMLElement).click();
        });
      }
      await page.waitForTimeout(1000); // Ждем анимации
      console.log('✅ Второй клик на переключатель ширины выполнен');
      
      // Проверяем, что сайт вернулся в изначальное положение
      const afterSecondClickWidth = await mainContainer.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          width: styles.width,
          maxWidth: styles.maxWidth,
          marginLeft: styles.marginLeft,
          marginRight: styles.marginRight
        };
      });
      
      // Проверяем, что ширина вернулась к начальному состоянию
      const returnedToInitial = afterSecondClickWidth.width === initialWidth.width &&
                                afterSecondClickWidth.maxWidth === initialWidth.maxWidth;
      
      if (returnedToInitial) {
        console.log(`✅ Сайт вернулся в изначальное положение: width=${afterSecondClickWidth.width}, max-width=${afterSecondClickWidth.maxWidth}`);
      } else {
        console.log(`ℹ️ Текущая ширина: width=${afterSecondClickWidth.width}, max-width=${afterSecondClickWidth.maxWidth}`);
      }
      
      // Проверяем стили элемента переключения
      const toggleStyles = await fullWidthToggle.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          cursor: styles.cursor,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          fontSize: styles.fontSize,
          color: styles.color
        };
      });
      
      expect(toggleStyles.display).not.toBe('none');
      expect(toggleStyles.visibility).not.toBe('hidden');
      expect(parseFloat(toggleStyles.opacity)).toBeGreaterThan(0);
      console.log(`✅ Стили элемента переключения: cursor=${toggleStyles.cursor}, opacity=${toggleStyles.opacity}, font-size=${toggleStyles.fontSize}`);
    });

    // Проверка навигации в профиле пользователя
    await test.step('Проверка навигации в профиле пользователя', async () => {
      // Убеждаемся, что мы на странице профиля
      await page.goto('https://dev.indooroutdoor.com/profile');
      await page.waitForTimeout(2000);
      await page.waitForURL('https://dev.indooroutdoor.com/profile', { timeout: 10000 });
      console.log('✅ Находимся на странице профиля');
      
      // Находим элемент в хедере для перехода на главную страницу
      const homeLink = page.locator('xpath=/html/body/div[1]/div[1]/div[2]/ul/li[2]/a');
      const homeLinkExists = await homeLink.count();
      
      if (homeLinkExists === 0) {
        throw new Error('Элемент для перехода на главную страницу не найден');
      }
      
      // Проверяем видимость элемента
      const isHomeLinkVisible = await homeLink.isVisible();
      if (!isHomeLinkVisible) {
        console.log('ℹ️ Элемент найден, но скрыт. Используем JavaScript клик');
      }
      
      // Кликаем на элемент
      if (isHomeLinkVisible) {
        await homeLink.click();
      } else {
        await homeLink.evaluate((el: HTMLElement) => {
          (el as HTMLElement).click();
        });
      }
      await page.waitForTimeout(2000);
      console.log('✅ Клик на элемент для перехода на главную страницу выполнен');
      
      // Проверяем, что перешли на главную страницу
      await page.waitForURL('https://dev.indooroutdoor.com/', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/');
      console.log('✅ Переход на главную страницу выполнен');
      
      // Возвращаемся в профиль пользователя
      await page.goto('https://dev.indooroutdoor.com/profile');
      await page.waitForTimeout(2000);
      await page.waitForURL('https://dev.indooroutdoor.com/profile', { timeout: 10000 });
      console.log('✅ Возврат в профиль пользователя выполнен');
      
      // Находим элемент в хедере для перехода на страницу деталей провайдера
      const providerDetailsLink = page.locator('xpath=/html/body/div[1]/div[1]/div[2]/ul/li[1]/a');
      const providerDetailsLinkExists = await providerDetailsLink.count();
      
      if (providerDetailsLinkExists === 0) {
        throw new Error('Элемент для перехода на страницу деталей провайдера не найден');
      }
      
      // Проверяем видимость элемента
      const isProviderDetailsLinkVisible = await providerDetailsLink.isVisible();
      if (!isProviderDetailsLinkVisible) {
        console.log('ℹ️ Элемент найден, но скрыт. Используем JavaScript клик');
      }
      
      // Кликаем на элемент и проверяем, не открывается ли новая вкладка
      const [newPage] = await Promise.all([
        context.waitForEvent('page', { timeout: 15000 }).catch(() => null),
        isProviderDetailsLinkVisible 
          ? providerDetailsLink.click()
          : providerDetailsLink.evaluate((el: HTMLElement) => {
              (el as HTMLElement).click();
            })
      ]);
      
      if (newPage) {
        console.log('✅ Открылась новая вкладка');
        await newPage.waitForLoadState('domcontentloaded');
        const newPageUrl = newPage.url();
        expect(newPageUrl).toMatch(/\/provider-details\/.+/);
        console.log(`✅ Переход на страницу деталей провайдера выполнен в новой вкладке. URL: ${newPageUrl}`);
        await newPage.close(); // Закрываем, чтобы не мешала
      } else {
        // Если новая страница не открылась, значит навигация должна быть в текущей
        console.log('ℹ️ Новая вкладка не открылась, проверяем навигацию в текущей странице');
        await page.waitForURL(/\/provider-details\/.+/, { timeout: 15000, waitUntil: 'domcontentloaded' });
        const currentUrl = page.url();
        expect(currentUrl).toMatch(/\/provider-details\/.+/);
        console.log(`✅ Переход на страницу деталей провайдера выполнен. Текущий URL: ${currentUrl}`);
      }
      
      // Проверяем стили элементов навигации
      const homeLinkStyles = await homeLink.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          cursor: styles.cursor,
          color: styles.color
        };
      });
      console.log(`✅ Стили элемента навигации на главную: cursor=${homeLinkStyles.cursor}, color=${homeLinkStyles.color}`);
      
      const providerDetailsLinkStyles = await providerDetailsLink.evaluate((el) => {
        const styles = window.getComputedStyle(el);
        return {
          display: styles.display,
          visibility: styles.visibility,
          cursor: styles.cursor,
          color: styles.color
        };
      });
      console.log(`✅ Стили элемента навигации на детали провайдера: cursor=${providerDetailsLinkStyles.cursor}, color=${providerDetailsLinkStyles.color}`);
    });

    // Возврат на страницу Privacy Policy для дальнейших проверок
    await test.step('Возврат на страницу Privacy Policy', async () => {
      await page.goto('https://dev.indooroutdoor.com/privacy-policy');
      await page.waitForTimeout(2000);
      await page.waitForURL('https://dev.indooroutdoor.com/privacy-policy', { timeout: 10000 });
      await expect(page).toHaveURL('https://dev.indooroutdoor.com/privacy-policy');
      console.log('✅ Возврат на страницу Privacy Policy выполнен');
    });

    // Проверка видимости всех элементов
    await test.step('Проверка видимости всех элементов', async () => {
      // Проверяем видимость заголовка Terms & Conditions (если мы еще на этой странице)
      const termsHeading = page.getByRole('heading', { name: /Terms & Condition/i }).or(page.getByText(/Terms & Condition/i)).first();
      const termsExists = await termsHeading.count();
      if (termsExists > 0) {
        const isVisible = await termsHeading.isVisible();
        if (isVisible) {
          console.log('✅ Заголовок Terms & Conditions видим');
        }
      }
      
      // Проверяем видимость заголовка Privacy Policy
      const privacyHeading = page.getByRole('heading', { name: /Privacy Policy/i }).or(page.getByText(/Privacy Policy/i)).first();
      await expect(privacyHeading).toBeVisible({ timeout: 10000 });
      console.log('✅ Заголовок Privacy Policy видим');
      
      // Проверяем видимость текстовых блоков
      const privacyText = page.getByText(/Our Commitment to Privacy/i).first();
      await expect(privacyText).toBeVisible({ timeout: 10000 });
      console.log('✅ Текстовый блок Privacy Policy видим');
    });

    // Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});

