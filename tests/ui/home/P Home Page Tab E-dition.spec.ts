import { test, expect } from '@playwright/test';
import { checkUIUX, checkStyles } from './helpers/ui-ux-helpers';

test.describe('Home Page E-dition Tab Audit @regression', () => {
  test.beforeEach(async ({ page }) => {
    // Установка стандартного viewport и переход на главную страницу
    await page.setViewportSize({ width: 1920, height: 1080 });
    await page.goto('https://dev.indooroutdoor.com/');
  });

  // ОБЯЗАТЕЛЬНО: Закрытие браузера после каждого теста для очистки ресурсов
  test.afterEach(async ({ page, context }) => {
    await page.close();
    await context.close();
  });

  test('Комплексная проверка вкладки E-dition и интерактивного iframe', async ({ page }) => {
    await test.step('Навигация к странице E-dition', async () => {
      const editionLink = page.getByRole('navigation').getByRole('link', { name: 'E-dition' });
      await expect(editionLink).toBeVisible();
      await editionLink.click();
      
      // Проверка корректности перехода по URL
      await expect(page).toHaveURL(/.*e-dition.*/);
    });

    // Определение локатора для iframe E-dition
    // В исходном тесте использовался .nth(2), сохраняем для совместимости, но оборачиваем в переменную
    const editionIframe = page.locator('iframe').nth(2).contentFrame();

    await test.step('Проверка базовых элементов управления E-dition (Next/Prev)', async () => {
      await expect(editionIframe.getByRole('main')).toBeVisible();
      
      const nextBtn = editionIframe.getByRole('button', { name: 'Next page' });
      const prevBtn = editionIframe.getByRole('button', { name: 'Previous page' });
      
      await expect(nextBtn).toBeVisible();
      await nextBtn.click();
      
      await expect(prevBtn).toBeVisible();
      await prevBtn.click();
      
      await nextBtn.click();
      await expect(prevBtn).toBeVisible();
      await prevBtn.click();
    });

    await test.step('Проверка функций масштабирования и управления просмотром', async () => {
      await editionIframe.getByRole('main').click();
      
      const zoomIn = editionIframe.getByRole('button', { name: 'Zoom in' });
      const zoomOut = editionIframe.getByRole('button', { name: 'Zoom out' });
      
      await expect(zoomIn).toBeVisible();
      await zoomIn.click();
      await expect(zoomOut).toBeVisible();
      await zoomOut.click();

      // Взаимодействие со слайдером масштаба (используем более надежные селекторы если возможно)
      const zoomSlider = editionIframe.locator('#slider-track').first();
      if (await zoomSlider.isVisible()) {
        await zoomSlider.click();
      }
    });

    await test.step('Проверка панели страниц (Pages) и полноэкранного режима', async () => {
      const pagesBtn = editionIframe.getByRole('button', { name: 'Pages' });
      await pagesBtn.click();
      
      // Проверка видимости панели страниц
      await expect(editionIframe.getByRole('button', { name: 'Close' })).toBeVisible();
      await editionIframe.getByRole('button', { name: 'Close' }).click();

      // Полноэкранный режим
      const fullScreenBtn = editionIframe.getByRole('button', { name: 'Full screen' });
      await fullScreenBtn.click();
      
      const exitFullScreenBtn = editionIframe.getByRole('button', { name: 'Exit full screen' });
      await expect(exitFullScreenBtn).toBeVisible();
      await exitFullScreenBtn.click();
    });

    // ОБЯЗАТЕЛЬНО: Проверка стилей (CSS) согласно README.md
    await test.step('Проверка стилей (CSS)', async () => {
      await checkStyles(page);
    });

    // ОБЯЗАТЕЛЬНО: Проверка UI/UX и адаптивности
    await test.step('Проверка UI/UX и адаптивности', async () => {
      await checkUIUX(page);
    });
  });
});
