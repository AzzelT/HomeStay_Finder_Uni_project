# Role 5 — Admin Dashboard & Reviews

This patch adds the Role 5 features to HomeStay Finder.

## What was added

- Admin Panel link already present in the main navbar is now functional.
- Admin authorization through the existing `roles` + `role_user` tables.
- Admin dashboard at `/admin`.
- Real dashboard statistics:
  - total users
  - total hosts
  - total homestays
  - total reviews
  - average review rating
- Recent reviews on the dashboard.
- Review management at `/admin/reviews`.
- Admin can delete a review.
- Admin layout uses the dashboard assets already included in `public/backend/assets`.
- Database seeder creates a demo admin account.

## Demo admin login

Email: `admin@homestayfinder.test`

Password: `password`

Run:

```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Then log in and use **Admin Panel** from the user dropdown.

## Important

If the team already has data in the database, do not run `migrate:fresh` because it deletes the database.

The admin account is created by `DatabaseSeeder`. If the team does not want the demo account, change the seeder email/password before committing.

## Files changed

- `app/Models/User.php`
- `app/Models/Role.php`
- `app/Http/Controllers/AdminController.php`
- `routes/web.php`
- `database/seeders/DatabaseSeeder.php`
- `resources/views/layouts/admin.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/reviews.blade.php`
