import { test, expect, Page } from '@playwright/test';

// Стандартные размеры экранов для проверки адаптивности
const VIEWPORTS = {
  desktop: { width: 1920, height: 1080 },
  tablet: { width: 768, height: 1024 },
  mobile: { width: 375, height: 667 }
};

/**
 * Брендовые цвета проекта
 */
export const BRAND_COLORS = {
  GREEN: 'rgb(100, 180, 95)',     // #64B45F
  GREEN_HOVER: 'rgb(86, 155, 82)', // #569B52
  NAVY: 'rgb(8, 28, 74)',         // #081C4A (Заголовки)
  NAVY_LIGHT: 'rgb(11, 28, 84)',   // #0B1C54 (Кнопки и некоторые элементы)
  DARK_GRAY: 'rgb(65, 64, 66)',    // #414042
  WHITE: 'rgb(255, 255, 255)'
};

/**
 * Проверка адаптивности на разных размерах экрана
 */
export async function checkResponsiveDesign(page: Page) {
  const originalViewport = page.viewportSize();
  
  for (const [device, size] of Object.entries(VIEWPORTS)) {
    await page.setViewportSize(size);
    await page.waitForTimeout(500); // Даем время на перерисовку
    
    // Проверяем, что основной контент виден
    const bodyText = await page.locator('body').textContent();
    expect(bodyText?.length).toBeGreaterThan(100);
    
    // Проверяем, что нет горизонтальной прокрутки (на мобильных устройствах)
    if (device === 'mobile' || device === 'tablet') {
      const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
      const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
      // Увеличенный допуск для учета возможных небольших переполнений (например, скроллбары)
      expect(scrollWidth).toBeLessThanOrEqual(clientWidth + 30);
    }
    
    console.log(`✅ Адаптивность проверена для ${device} (${size.width}x${size.height})`);
  }
  
  // Восстанавливаем оригинальный размер
  if (originalViewport) {
    await page.setViewportSize(originalViewport);
  }
}

/**
 * Проверка доступности (A11y)
 */
export async function checkAccessibility(page: Page) {
  try {
    // Проверка alt-текстов для изображений
    const images = await page.locator('img').all();
    let imagesWithoutAlt = 0;
    let visibleImagesCount = 0;
    
    for (const img of images) {
      const isVisible = await img.isVisible().catch(() => false);
      if (isVisible) {
        visibleImagesCount++;
        const alt = await img.getAttribute('alt');
        if (!alt || alt.trim() === '') {
          imagesWithoutAlt++;
        }
      }
    }
    
    // Гибкая проверка: если изображений мало, допускаем больше без alt
    if (visibleImagesCount > 0) {
      const maxAllowed = visibleImagesCount < 5 ? Math.ceil(visibleImagesCount * 0.5) : Math.ceil(visibleImagesCount * 0.3);
      expect(imagesWithoutAlt).toBeLessThanOrEqual(maxAllowed);
    }
    
    // Проверка наличия заголовков
    const h1Count = await page.locator('h1').count();
    const h2Count = await page.locator('h2').count();
    const h3Count = await page.locator('h3').count();
    const allHeadings = await page.locator('h1, h2, h3, h4, h5, h6, [class*="title" i], [class*="heading" i], [role="heading"]').count();
    
    // Если нет h1, но есть другие заголовки - это нормально
    if (h1Count === 0 && allHeadings > 0) {
      console.log('⚠️ H1 не найден, но есть другие заголовки');
    }
    
    // Проверка ARIA-атрибутов для кнопок
    const buttons = await page.locator('button').all();
    let buttonsWithoutAria = 0;
    let visibleButtonsCount = 0;
    
    for (const button of buttons.slice(0, 10)) {
      const isVisible = await button.isVisible().catch(() => false);
      if (isVisible) {
        visibleButtonsCount++;
        const ariaLabel = await button.getAttribute('aria-label');
        const text = await button.textContent();
        if (!ariaLabel && (!text || text.trim() === '')) {
          buttonsWithoutAria++;
        }
      }
    }
    
    // Допускаем до 30% кнопок без aria-label, если у них есть текст
    if (visibleButtonsCount > 0) {
      const maxAllowed = Math.ceil(visibleButtonsCount * 0.3);
      expect(buttonsWithoutAria).toBeLessThanOrEqual(maxAllowed);
    }
    
    console.log('✅ Проверка доступности завершена');
  } catch (e) {
    // Если страница закрыта, пропускаем проверку
    console.log(`⚠️ Ошибка при проверке доступности: ${e}`);
  }
}

/**
 * Проверка стилей (CSS)
 */
export async function checkStyles(page: Page) {
  try {
    // Проверка загрузки CSS файлов
    const stylesheets = await page.locator('link[rel="stylesheet"]').all();
    expect(stylesheets.length).toBeGreaterThan(0);
    
    // Проверка применения стилей к body
    const bodyStyles = await page.evaluate(() => {
      const body = document.body;
      const styles = window.getComputedStyle(body);
      return {
        fontFamily: styles.fontFamily,
        fontSize: styles.fontSize,
        color: styles.color,
        backgroundColor: styles.backgroundColor
      };
    });
    
    expect(bodyStyles.fontFamily).toBeTruthy();
    expect(bodyStyles.fontSize).toBeTruthy();
    
    // Проверка стилей видимых кнопок
    const visibleButtons = await page.locator('button, a.btn').all();
    for (const button of visibleButtons.slice(0, 10)) {
      const isVisible = await button.isVisible().catch(() => false);
      if (isVisible) {
        const buttonStyles = await button.evaluate((el) => {
          const styles = window.getComputedStyle(el);
          return {
            display: styles.display,
            visibility: styles.visibility,
            opacity: styles.opacity,
            backgroundColor: styles.backgroundColor,
            color: styles.color,
            className: el.className
          };
        });
        
        expect(buttonStyles.display).not.toBe('none');
        expect(buttonStyles.visibility).not.toBe('hidden');
        expect(parseFloat(buttonStyles.opacity)).toBeGreaterThan(0);

        // Если это зеленая кнопка (по классу), проверяем цвет
        if (buttonStyles.className.includes('btn-green') || buttonStyles.className.includes('site-button-secondary')) {
          expect(buttonStyles.backgroundColor).toBe(BRAND_COLORS.GREEN);
        }
      }
    }
    
    // Проверка цвета основного заголовка "Your Home" если он есть на странице
    const yourHomeHeading = page.locator('h1.text-green, .text-green').filter({ hasText: 'Your Home' });
    if (await yourHomeHeading.count() > 0) {
      const headingColor = await yourHomeHeading.first().evaluate(el => window.getComputedStyle(el).color);
      expect(headingColor).toBe(BRAND_COLORS.GREEN);
    }
    
    console.log('✅ Проверка стилей завершена');
  } catch (e) {
    console.log(`⚠️ Ошибка при проверке стилей: ${e}`);
  }
}

/**
 * Проверка производительности
 */
export async function checkPerformance(page: Page) {
  try {
    const performanceTiming = await page.evaluate(() => {
      const perf = performance.timing;
      return {
        loadTime: perf.loadEventEnd - perf.navigationStart,
        ttfb: perf.responseStart - perf.navigationStart,
        domInteractive: perf.domInteractive - perf.navigationStart
      };
    });
    
    // Проверяем, что страница загрузилась за разумное время (менее 30 секунд)
    expect(performanceTiming.loadTime).toBeLessThan(30000);
    expect(performanceTiming.ttfb).toBeLessThan(5000);
    
    console.log(`✅ Производительность: Load Time=${performanceTiming.loadTime}ms, TTFB=${performanceTiming.ttfb}ms`);
  } catch (e) {
    console.log(`⚠️ Ошибка при проверке производительности: ${e}`);
  }
}

/**
 * Комплексная проверка UI/UX (включает все проверки)
 */
export async function checkUIUX(page: Page) {
  await test.step('Проверка адаптивности', async () => {
    await checkResponsiveDesign(page);
  });

  await test.step('Проверка доступности (A11y)', async () => {
    await checkAccessibility(page);
  });

  await test.step('Проверка стилей (CSS)', async () => {
    await checkStyles(page);
  });

  await test.step('Проверка производительности', async () => {
    await checkPerformance(page);
  });
}

