import { defineConfig, devices } from '@playwright/test';
import * as dotenv from 'dotenv';
import * as path from 'path';

const ENVIRONMENT = process.env.TEST_ENV || 'dev';
dotenv.config({ path: path.resolve(__dirname, 'config', `.env.${ENVIRONMENT}`) });

export default defineConfig({
    testDir: './tests',
    fullyParallel: true,
    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 2 : 0,
    workers: process.env.CI ? 1 : undefined,
    reporter: [
        ['html', { outputFolder: 'playwright-report' }],
    ],
    outputDir: './test-results',

    use: {
        baseURL: process.env.BASE_URL,
        trace: 'on-first-retry',
        screenshot: 'only-on-failure',
    },

    projects: [
        {
            name: 'setup',
            testDir: './tests/setup',
            testMatch: '**/*.setup.ts',
        },
        {
            name: 'chromium',
            use: {
                ...devices['Desktop Chrome'],
                storageState: './storage-states/user-state.json',
            },
            dependencies: ['setup'],
        },
        {
            name: 'firefox',
            use: {
                ...devices['Desktop Firefox'],
                storageState: './storage-states/user-state.json',
            },
            dependencies: ['setup'],
        },
        {
            name: 'webkit',
            use: {
                ...devices['Desktop Safari'],
                storageState: './storage-states/user-state.json',
            },
            dependencies: ['setup'],
        },
    ],
});
