export const USER_ROLES = {
    ADMIN: 'admin',
    USER: 'user',
    CONTRACTOR: 'contractor',
    HOMEOWNER: 'homeowner',
} as const;

export const VALIDATION_MESSAGES = {
    REQUIRED_FIELD: 'This field is required',
    INVALID_EMAIL: 'Please enter a valid email address',
    PASSWORD_TOO_SHORT: 'Password must be at least 8 characters',
} as const;

export const TIMEOUTS = {
    SHORT_WAIT_MILLISECONDS: 3000,
    MEDIUM_WAIT_MILLISECONDS: 10000,
    LONG_WAIT_MILLISECONDS: 30000,
} as const;
