import { APIResponse } from '@playwright/test';
import { BaseClient } from 'api/base.client';

export class UserClient extends BaseClient {
    async getAllUsers(): Promise<APIResponse> {
        return await this.apiRequestContext.get('/users');
    }

    async getUserById(userId: string): Promise<APIResponse> {
        return await this.apiRequestContext.get(`/users/${userId}`);
    }

    async createUser(userData: Record<string, unknown>): Promise<APIResponse> {
        return await this.apiRequestContext.post('/users', { data: userData });
    }

    async deleteUser(userId: string): Promise<APIResponse> {
        return await this.apiRequestContext.delete(`/users/${userId}`);
    }
}
