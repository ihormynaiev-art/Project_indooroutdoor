import * as dotenv from 'dotenv';
import * as path from 'path';

const ENVIRONMENT = process.env.TEST_ENV || 'dev';

dotenv.config({
    path: path.resolve(__dirname, '..', 'config', `.env.${ENVIRONMENT}`),
});

export const BASE_URL = process.env.BASE_URL!;
export const API_BASE_URL = process.env.API_BASE_URL!;
