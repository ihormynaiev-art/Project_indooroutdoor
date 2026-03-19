import { test, expect } from '@playwright/test';
import { checkStyles, checkAccessibility, checkResponsiveDesign, checkPerformance } from 'utils/ui.ux.helper';

test.describe.configure({ mode: 'serial' }); // Выполнять тесты по очереди

test.describe('Home Page Tests @regression', () => {
  test.beforeEach(async ({ page }) => {
    await page.setViewportSize({ width: 1920, height: 1080 });
    await page.goto('https://dev.indooroutdoor.com/');
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Проверка элементов навигации и контента', async ({ page }) => {
    // Проверка навигации
    await test.step('Проверка элементов навигации', async () => {
      await expect(page.getByRole('link', { name: 'Logo', exact: true })).toBeVisible();
      await expect(page.getByRole('navigation')).toContainText('Home');
      await expect(page.getByRole('navigation').getByRole('link', { name: 'Home' })).toBeVisible();
      await expect(page.getByRole('navigation')).toContainText('Request Quote');
      await expect(page.getByRole('link', { name: 'Request Quote' })).toBeVisible();
      await expect(page.locator('#menu-services')).toContainText('Services');
      await expect(page.locator('#menu-services')).toBeVisible();
      await expect(page.getByRole('navigation')).toContainText('E-dition');
      await expect(page.getByRole('navigation').getByRole('link', { name: 'E-dition' })).toBeVisible();
      await expect(page.getByRole('navigation')).toContainText('Login');
      await expect(page.getByRole('link', { name: 'Log In ImageLogin' })).toBeVisible();
      await expect(page.getByRole('navigation')).toContainText('Sign Up');
      await expect(page.getByRole('link', { name: 'Sign Up' })).toBeVisible();
    });

    // Проверка баннера
    await test.step('Проверка баннера и заголовков', async () => {
      await expect(page.getByRole('banner')).toBeVisible();
      await expect(page.locator('body')).toContainText('Helping make a House');
      await expect(page.getByRole('heading', { name: 'Helping make a House' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Your Home®');
      await expect(page.getByRole('heading', { name: 'Your Home®' })).toBeVisible();
    });

    // Проверка поисковой строки
    await test.step('Проверка поисковой строки', async () => {
      await expect(page.locator('.search-box')).toBeVisible();
    });

    // Проверка секции "FROM TO-DO TO DONE"
    await test.step('Проверка секции "FROM TO-DO TO DONE"', async () => {
      await expect(page.locator('h3').filter({ hasText: 'FROM TO-DO TO DONE ®' }).first()).toContainText('FROM TO-DO TO DONE ®');
      await expect(page.getByRole('heading', { name: 'FROM TO-DO TO DONE ®' }).first()).toBeVisible();
      await expect(page.locator('body')).toContainText(/Whether it.s routine maintenance/);
      await expect(page.getByText(/Whether it.s routine/)).toBeVisible();
    });

    // Проверка шагов (step 1, 2, 3)
    await test.step('Проверка шагов процесса', async () => {
      // Step 1
      await expect(page.locator('.work-icon').first()).toBeVisible();
      await expect(page.locator('body')).toContainText('step 1');
      await expect(page.getByRole('heading', { name: 'step 1' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Select Your Project');
      await expect(page.getByRole('heading', { name: 'Select Your Project' })).toBeVisible();
      await expect(page.locator('body')).toContainText("Choose the type of work you need, and we'll connect you with contractors who specialize in that service.");
      await expect(page.getByText('Choose the type of work you')).toBeVisible();
      await expect(page.locator('.work-box.on-top > .work-icon')).toBeVisible();

      // Step 2
      await expect(page.locator('body')).toContainText('step 2');
      await expect(page.getByRole('heading', { name: 'step 2' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Compare Contractors');
      await expect(page.getByRole('heading', { name: 'Compare Contractors' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Browse detailed profiles, portfolios, reviews, and credentials to find contractors that meet your needs.');
      await expect(page.getByText('Browse detailed profiles,')).toBeVisible();
      await expect(page.locator('.work-icon.w-4')).toBeVisible();

      // Step 3
      await expect(page.locator('body')).toContainText('step 3');
      await expect(page.getByRole('heading', { name: 'step 3' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Make It Happen');
      await expect(page.getByRole('heading', { name: 'Make It Happen' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Choose the right contractor for your needs and budget. After the job is complete, share your feedback to support your community.');
      await expect(page.getByText('Choose the right contractor')).toBeVisible();
    });

    // Проверка ссылок
    await test.step('Проверка ссылок', async () => {
      await expect(page.locator('body')).toContainText('Request Quote');
      await expect(page.getByRole('button', { name: 'Request Quote' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Search by Service');
      await expect(page.getByRole('link', { name: 'Search by Service' })).toBeVisible();
    });

    // Проверка секций
    await test.step('Проверка секций контента', async () => {
      await expect(page.locator('section').filter({ hasText: 'Browse Edition For over two' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Browse Edition');
      await expect(page.getByRole('heading', { name: 'Browse Edition' })).toBeVisible();
      await expect(page.locator('body')).toContainText('For over two decades, Michigan homeowners have trusted IndoorOutdoor as their go-to home improvement resource.');
      await expect(page.getByText('For over two decades,')).toBeVisible();
      await expect(page.getByRole('link', { name: 'img' }).nth(2)).toBeVisible();
      await expect(page.locator('body')).toContainText('Browse E-dition');
      await expect(page.getByRole('link', { name: 'Browse E-dition' })).toBeVisible();

      await expect(page.locator('section').filter({ hasText: 'Explore painting basement kitchen bathroom flooring landscaping lighting window roofing gutter flooring paver masonry Projects' })).toBeVisible();
      await expect(page.locator('body')).toContainText('Explore painting basement kitchen bathroom flooring landscaping lighting window roofing gutter flooring paver masonry Projects');
      await expect(page.getByRole('heading', { name: 'Explore painting basement' })).toBeVisible();
      await expect(page.getByText('Home Furnishings Kitchens')).toBeVisible();
      await expect(page.locator('body')).toContainText('View All Services');
      await expect(page.getByRole('link', { name: 'View All Services' })).toBeVisible();

      await expect(page.locator('section').filter({ hasText: /Michigan.s Premier Home Goods/ })).toBeVisible();
      await expect(page.locator('body')).toContainText(/Michigan.s Premier Home Goods/);
      await expect(page.getByRole('heading', { name: /Michigan.s Premier Home Goods/ })).toBeVisible();
      await expect(page.locator('.owl-carousel.partners-slider > .owl-stage-outer > .owl-stage')).toBeVisible();
      await expect(page.locator('body')).toContainText('INprint & ONline | Your Local Home Resource Guide®');
      await expect(page.getByText('INprint & ONline | Your Local')).toBeVisible();
    });
  });

  test('Проверка стилей элементов', async ({ page }) => {
    // Проверка стилей навигации
    await test.step('Проверка стилей навигации', async () => {
      const navigation = page.getByRole('navigation');
      await expect(navigation).toBeVisible();

      const navStyles = await navigation.evaluate((el) => {
        const computed = window.getComputedStyle(el);
        return {
          display: computed.display,
          visibility: computed.visibility,
          opacity: computed.opacity,
          backgroundColor: computed.backgroundColor
        };
      });

      expect(navStyles.display).not.toBe('none');
      expect(navStyles.visibility).not.toBe('hidden');
      expect(parseFloat(navStyles.opacity)).toBeGreaterThan(0);
    });

    // Проверка стилей заголовков
    await test.step('Проверка стилей заголовков', async () => {
      const mainHeading = page.getByRole('heading', { name: 'Helping make a House' });
      await expect(mainHeading).toBeVisible();

      const headingStyles = await mainHeading.evaluate((el) => {
        const computed = window.getComputedStyle(el);
        return {
          fontSize: computed.fontSize,
          fontWeight: computed.fontWeight,
          color: computed.color,
          display: computed.display,
          visibility: computed.visibility
        };
      });

      expect(headingStyles.fontSize).toBeTruthy();
      expect(headingStyles.fontWeight).toBeTruthy();
      expect(headingStyles.color).toBeTruthy();
      expect(headingStyles.display).not.toBe('none');
      expect(headingStyles.visibility).not.toBe('hidden');
    });

    // Проверка стилей поисковой строки
    await test.step('Проверка стилей поисковой строки', async () => {
      await expect(page.locator('.search-box')).toBeVisible();

      const searchBoxStyles = await page.locator('.search-box').evaluate((el) => {
        const computed = window.getComputedStyle(el);
        return {
          display: computed.display,
          visibility: computed.visibility,
          opacity: computed.opacity
        };
      });

      expect(searchBoxStyles.display).not.toBe('none');
      expect(searchBoxStyles.visibility).not.toBe('hidden');
    });

    // Проверка стилей кнопок
    await test.step('Проверка стилей кнопок', async () => {
      const requestQuoteButton = page.getByRole('button', { name: 'Request Quote' });
      await expect(requestQuoteButton).toBeVisible();

      const buttonStyles = await requestQuoteButton.evaluate((el) => {
        const computed = window.getComputedStyle(el);
        return {
          display: computed.display,
          visibility: computed.visibility,
          opacity: computed.opacity,
          cursor: computed.cursor,
          backgroundColor: computed.backgroundColor,
          color: computed.color
        };
      });

      expect(buttonStyles.display).not.toBe('none');
      expect(buttonStyles.visibility).not.toBe('hidden');
      expect(parseFloat(buttonStyles.opacity)).toBeGreaterThan(0);
      expect(buttonStyles.cursor).toBe('pointer');
    });
  });

  test('Визуальные проверки и доступность', async ({ page }) => {
    await checkStyles(page);
    await checkAccessibility(page);
    await checkResponsiveDesign(page);
  });

  test('Проверка производительности', async ({ page }) => {
    await checkPerformance(page);
  });

  test('Функциональные клики в навигации', async ({ page }) => {
    await page.locator('section').filter({ hasText: 'Helping make a House Your' }).getByRole('button').click();
    await page.goto('https://dev.indooroutdoor.com/');
    await expect(page.locator('section').filter({ hasText: 'Helping make a House Your' }).getByRole('button')).toBeVisible();

    await page.getByRole('button', { name: 'Request Quote' }).click();
    await page.getByRole('button', { name: 'Close' }).click();

    await page.getByRole('link', { name: 'Search by Service' }).click();
    // Возвращаемся на главную страницу, чтобы найти элемент "Browse E-dition"
    await page.goto('https://dev.indooroutdoor.com/');
    await page.getByRole('link', { name: 'Browse E-dition' }).click();
    // Возвращаемся на главную страницу, чтобы найти элемент "View All Services"
    await page.goto('https://dev.indooroutdoor.com/');
    await page.getByRole('link', { name: 'View All Services' }).click();
  });

  /**
   * SEARCH FUNCTIONALITY TESTS
   */
  test.describe('Search Functionality Audit @search', () => {

    test('Валидный поисковый запрос через Enter', async ({ page }) => {
      const searchInput = page.locator('#search-autocomplete-input');
      const query = 'Kitchen';

      await searchInput.fill(query);
      await searchInput.press('Enter');

      // Проверяем, что в URL появился параметр search
      const params = new URL(page.url()).searchParams;
      expect(params.get('search')).toBe(query);

      // Проверяем, что мы не на 404 странице и контент загрузился
      await expect(page.locator('body')).toBeVisible();
    });

    test('Пустой ввод', async ({ page }) => {
      await page.goto('/');
      const searchInput = page.locator('#search-autocomplete-input');
      await searchInput.press('Enter');

      const params = new URL(page.url()).searchParams;
      expect(params.get('search')).toBe('');
    });

    test('Несуществующий запрос', async ({ page }) => {
      await page.goto('/');
      const searchInput = page.locator('#search-autocomplete-input');
      await searchInput.fill('NonExistent123');
      await searchInput.press('Enter');

      const params = new URL(page.url()).searchParams;
      expect(params.get('search')).toBe('NonExistent123');
    });

    test('Спецсимволы и длинный запрос', async ({ page }) => {
      await page.goto('/');
      const searchInput = page.locator('#search-autocomplete-input');
      await searchInput.fill('!@#$%^&*'.repeat(20));
      await searchInput.press('Enter');

      const params = new URL(page.url()).searchParams;
      expect(params.get('search')).toBe('!@#$%^&*'.repeat(20));
    });
  });
});
