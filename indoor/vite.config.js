import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/edition.css',
                'resources/js/admin/admins.js',
                'resources/js/admin/categories.js',
                'resources/js/admin/contact-messages.js',
                'resources/js/admin/contractors.js',
                'resources/js/admin/homeowners.js',
                'resources/js/admin/invite-codes.js',
                'resources/js/admin/landings.js',
                'resources/js/admin/licenses.js',
                'resources/js/admin/magazineImages.js',
                'resources/js/admin/magazines.js',
                'resources/js/admin/plans.js',
                'resources/js/admin/smsMessages.js',
                'resources/js/admin/smsTemplates.js',
                'resources/js/admin/testimonials.js',
                'resources/js/admin/users.js',
            ],
            refresh: true,
        }),
    ]
});
