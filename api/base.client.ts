import { APIRequestContext, request } from '@playwright/test';
import { API_BASE_URL } from 'utils/env.helper';

export class BaseClient {
    protected apiRequestContext!: APIRequestContext;
    protected authorizationToken: string;

    constructor(authorizationToken: string = '') {
        this.authorizationToken = authorizationToken;
    }

    async initialize(): Promise<void> {
        this.apiRequestContext = await request.newContext({
            baseURL: API_BASE_URL,
            extraHTTPHeaders: {
                'Content-Type': 'application/json',
                ...(this.authorizationToken && { 'Authorization': `Bearer ${this.authorizationToken}` }),
            },
        });
    }

    async dispose(): Promise<void> {
        await this.apiRequestContext.dispose();
    }
}
