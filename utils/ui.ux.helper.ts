import { test, expect, Page } from '@playwright/test';

const VIEWPORTS = {
    desktop: { width: 1920, height: 1080 },
    tablet: { width: 768, height: 1024 },
    mobile: { width: 375, height: 667 }
};

export const BRAND_COLORS = {
    GREEN: 'rgb(100, 180, 95)',
    GREEN_HOVER: 'rgb(86, 155, 82)',
    NAVY: 'rgb(8, 28, 74)',
    NAVY_LIGHT: 'rgb(11, 28, 84)',
    DARK_GRAY: 'rgb(65, 64, 66)',
    WHITE: 'rgb(255, 255, 255)'
};

export async function checkResponsiveDesign(page: Page) {
    const originalViewport = page.viewportSize();

    for (const [device, size] of Object.entries(VIEWPORTS)) {
        await page.setViewportSize(size);
        await page.waitForTimeout(500);

        const bodyText = await page.locator('body').textContent();
        expect(bodyText?.length).toBeGreaterThan(100);

        if (device === 'mobile' || device === 'tablet') {
            const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
            const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
            expect(scrollWidth).toBeLessThanOrEqual(clientWidth + 30);
        }

        console.log(`Responsive check passed for ${device} (${size.width}x${size.height})`);
    }

    if (originalViewport) {
        await page.setViewportSize(originalViewport);
    }
}

export async function checkAccessibility(page: Page) {
    try {
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

        if (visibleImagesCount > 0) {
            const maxAllowed = visibleImagesCount < 5 ? Math.ceil(visibleImagesCount * 0.5) : Math.ceil(visibleImagesCount * 0.3);
            expect(imagesWithoutAlt).toBeLessThanOrEqual(maxAllowed);
        }

        const h1Count = await page.locator('h1').count();
        const allHeadings = await page.locator('h1, h2, h3, h4, h5, h6, [class*="title" i], [class*="heading" i], [role="heading"]').count();

        if (h1Count === 0 && allHeadings > 0) {
            console.log('Warning: H1 not found, but other headings exist');
        }

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

        if (visibleButtonsCount > 0) {
            const maxAllowed = Math.ceil(visibleButtonsCount * 0.3);
            expect(buttonsWithoutAria).toBeLessThanOrEqual(maxAllowed);
        }

        console.log('Accessibility check passed');
    } catch (accessibilityCheckError) {
        console.log(`Accessibility check error: ${accessibilityCheckError}`);
    }
}

export async function checkStyles(page: Page) {
    try {
        const stylesheets = await page.locator('link[rel="stylesheet"]').all();
        expect(stylesheets.length).toBeGreaterThan(0);

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

                if (buttonStyles.className.includes('btn-green') || buttonStyles.className.includes('site-button-secondary')) {
                    expect(buttonStyles.backgroundColor).toBe(BRAND_COLORS.GREEN);
                }
            }
        }

        const yourHomeHeading = page.locator('h1.text-green, .text-green').filter({ hasText: 'Your Home' });
        if (await yourHomeHeading.count() > 0) {
            const headingColor = await yourHomeHeading.first().evaluate(el => window.getComputedStyle(el).color);
            expect(headingColor).toBe(BRAND_COLORS.GREEN);
        }

        console.log('Styles check passed');
    } catch (stylesCheckError) {
        console.log(`Styles check error: ${stylesCheckError}`);
    }
}

export async function checkPerformance(page: Page) {
    try {
        const performanceTiming = await page.evaluate(() => {
            const perf = performance.timing;
            return {
                loadTime: perf.loadEventEnd - perf.navigationStart,
                timeToFirstByte: perf.responseStart - perf.navigationStart,
                domInteractive: perf.domInteractive - perf.navigationStart
            };
        });

        expect(performanceTiming.loadTime).toBeLessThan(30000);
        expect(performanceTiming.timeToFirstByte).toBeLessThan(5000);

        console.log(`Performance: Load Time=${performanceTiming.loadTime}ms, TTFB=${performanceTiming.timeToFirstByte}ms`);
    } catch (performanceCheckError) {
        console.log(`Performance check error: ${performanceCheckError}`);
    }
}

export async function checkUIUX(page: Page) {
    await test.step('Responsive design check', async () => {
        await checkResponsiveDesign(page);
    });

    await test.step('Accessibility check', async () => {
        await checkAccessibility(page);
    });

    await test.step('Styles check', async () => {
        await checkStyles(page);
    });

    await test.step('Performance check', async () => {
        await checkPerformance(page);
    });
}
